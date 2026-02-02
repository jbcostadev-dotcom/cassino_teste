<?php

namespace App\Traits\Gateways;

use App\Helpers\Core;
use App\Models\AffiliateHistory;
use App\Models\AffiliateLogs;
use App\Models\AffiliateWithdraw;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Notifications\NewDepositNotification;
use Exception;
use App\Helpers\Core as Helper;
use App\Models\ConfigRoundsFree;
use App\Models\OndaPay;
use App\Services\PlayFiverService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


trait OndaPayTrait
{
    protected static string $uriOnda;
    protected static string $clienteIdOnda;
    protected static string $clienteSecretOnda;

    private static function generateCredentialsOnda()
    {
        $setting = Gateway::first();
        if (!empty($setting)) {
            // URL da API Onda v2
            self::$uriOnda = rtrim($setting->getAttributes()['ondapay_uri'] ?? 'https://api.ecompag.com/v2', '/');
            self::$clienteIdOnda = $setting->getAttributes()['ondapay_client'];
            self::$clienteSecretOnda = $setting->getAttributes()['ondapay_secret'];
        }
    }

    public function requestQrcodeOnda($request)
    {
        try {
            $setting = Core::getSetting();
            $rules = [
                'amount' => ['required', 'numeric', 'min:' . $setting->min_deposit, 'max:' . $setting->max_deposit],
                'cpf'    => ['required', 'string', 'max:255'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            self::generateCredentialsOnda();

            // Preparar dados para a API Onda v2
            $postData = [
                'client_id'     => self::$clienteIdOnda,
                'client_secret' => self::$clienteSecretOnda,
                'nome'          => auth('api')->user()->name,
                'cpf'           => Helper::soNumero($request->cpf),
                'valor'         => (float) $request->input("amount"),
                'descricao'     => 'Depósito PIX',
                'urlnoty'       => url('/ondapay/callback'),
            ];

            // Endpoint Onda v2
            $url = self::$uriOnda . '/pix/qrcode.php';

            Log::info('[ONDAPAY → ECOMPAG] Requisição QRCode', [
                'url' => $url,
                'data' => $postData
            ]);

            $response = Http::asForm()->post($url, $postData);

            $responseData = $response->json();
            
            Log::info('[ONDAPAY → ECOMPAG] Resposta QRCode', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $responseData
            ]);

            if ($response->successful() && is_array($responseData)) {
                if (isset($responseData['qrcode']) && isset($responseData['transactionId'])) {
                    self::generateTransactionOnda(
                        $responseData['transactionId'], 
                        $request->input("amount")
                    );
                    self::generateDepositOnda($responseData['transactionId'], $request->input("amount"));
                    
                    return response()->json([
                        'status' => true, 
                        'idTransaction' => $responseData['transactionId'], 
                        'qrcode' => $responseData['qrcode']
                    ]);
                } else {
                    Log::error('[ONDAPAY → ECOMPAG] Resposta sem qrcode ou transactionId', [
                        'response' => $responseData
                    ]);
                    return response()->json([
                        'error' => $responseData['message'] ?? 'Erro ao gerar QRCode'
                    ], 500);
                }
            }

            Log::error('[ONDAPAY → ECOMPAG] Erro na requisição', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'error' => "Ocorreu uma falha ao entrar em contato com o gateway de pagamento."
            ], 500);
            
        } catch (Exception $e) {
            Log::error('[ONDAPAY → ECOMPAG] Exception no QRCode', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json(['error' => 'Erro interno'], 500);
        }
    }

    public function webhookOnda($request)
    {
        try {
            Log::info('[ONDAPAY → ECOMPAG] Webhook recebido', $request->all());

            // Verificar o tipo de transação
            $transactionType = $request->input('transactionType');

            if ($transactionType === 'RECEIVEPIX') {
                // Webhook de pagamento recebido
                $status = $request->input('status');
                $transactionId = $request->input('transactionId');

                if ($status === 'PAID') {
                    if (self::finalizaPaymentOnda($transactionId)) {
                        return response()->json(['message' => 'Pagamento processado com sucesso'], 200);
                    }
                }
            } elseif ($transactionType === 'PAYMENT') {
                // Webhook de transferência (saque)
                $statusCode = $request->input('statusCode');
                
                if (isset($statusCode['statusId']) && $statusCode['statusId'] == 1) {
                    Log::info('[ONDAPAY → ECOMPAG] Saque confirmado', $request->all());
                    return response()->json(['message' => 'Saque processado'], 200);
                }
            }

            return response()->json(['message' => 'Webhook recebido'], 200);
        } catch (Exception $e) {
            Log::error('[ONDAPAY → ECOMPAG] Erro no webhook', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            return response()->json(['error' => 'Erro ao processar webhook'], 500);
        }
    }

    private static function finalizaPaymentOnda($idTransaction)
    {
        $transaction = Transaction::where('payment_id', $idTransaction)
            ->where('status', 0)
            ->first();
            
        $setting = Helper::getSetting();
        
        if (!empty($transaction)) {
            $user = User::find($transaction->user_id);
            $wallet = Wallet::where('user_id', $transaction->user_id)->first();

            if (!empty($wallet)) {
                $setting = Setting::first();

                /// verifica se é o primeiro deposito, verifica as transações, somente se for transações concluidas
                $checkTransactions = Transaction::where('user_id', $transaction->user_id)
                    ->where('status', 1)
                    ->count();

                if ($checkTransactions == 0 || empty($checkTransactions)) {
                    /// pagar o bonus
                    $bonus = Helper::porcentagem_xn($setting->initial_bonus, $transaction->price);
                    $wallet->increment('balance_bonus', $bonus);
                    $wallet->update(['balance_bonus_rollover' => $bonus * $setting->rollover]);
                }
                
                $configRounds = ConfigRoundsFree::orderBy('value', 'asc')->get();
                foreach ($configRounds as $value) {
                    if ($transaction->price >= $value->value) {
                        $dados = [
                            "username" => $user->email,
                            "game_code" => $value->game_code,
                            "rounds" => $value->spins
                        ];
                        PlayFiverService::RoundsFree($dados);
                        break;
                    }
                }
                
                $wallet->update(['balance_deposit_rollover' => $transaction->price * intval($setting->rollover_deposit)]);

                if ($wallet->increment('balance', $transaction->price)) {
                    if ($transaction->update(['status' => 1])) {
                        $deposit = Deposit::where('payment_id', $idTransaction)->where('status', 0)->first();
                        
                        if (!empty($deposit)) {
                            /// fazer o deposito em cpa
                            $affHistoryCPA = AffiliateHistory::where('user_id', $user->id)
                                ->where('commission_type', 'cpa')
                                ->where('status', 0)
                                ->first();

                            if (!empty($affHistoryCPA)) {
                                // Verifica se o CPA pode ser pago com base no baseline do sponsor
                                $sponsorCpa = User::find($user->inviter);
                                if (!empty($sponsorCpa)) {
                                    // Defina o valor do depósito para ser atualizado
                                    $deposited_amount = $transaction->price;

                                    // Verifica se o valor acumulado ou o depósito atual atinge o baseline
                                    if ($affHistoryCPA->deposited_amount >= $sponsorCpa->affiliate_baseline || $deposit->amount >= $sponsorCpa->affiliate_baseline) {
                                        $walletCpa = Wallet::where('user_id', $affHistoryCPA->inviter)->first();
                                        if (!empty($walletCpa)) {
                                            // Paga o valor de CPA
                                            $walletCpa->increment('refer_rewards', $sponsorCpa->affiliate_cpa);
                                            $affHistoryCPA->update([
                                                'status' => 1,
                                                'deposited' => $deposited_amount,
                                                'commission_paid' => $sponsorCpa->affiliate_cpa
                                            ]);
                                        }
                                    } else {
                                        // Atualiza o valor depositado no histórico de afiliados
                                        $affHistoryCPA->update(['deposited_amount' => $transaction->price]);
                                    }
                                }
                            }

                            if ($deposit->update(['status' => 1])) {
                                $admins = User::where('role_id', 0)->get();
                                foreach ($admins as $admin) {
                                    $admin->notify(new NewDepositNotification($user->name, $transaction->price));
                                }
                                return true;
                            }
                            return false;
                        }
                        return false;
                    }
                }

                return false;
            }
            return false;
        }
        return false;
    }

    public function pixCashOutOnda($id, $tipo)
    {
        self::generateCredentialsOnda();

        $withdrawal = Withdrawal::find($id);

        if ($tipo == "afiliado") {
            $withdrawal = AffiliateWithdraw::find($id);
        }

        if ($withdrawal != null) {
            $user = User::find($withdrawal->user_id);

            // Preparar a chave PIX de acordo com o tipo
            $chave_pix = null;

            switch ($withdrawal->pix_type) {
                case 'document':
                    $chave_pix = preg_replace('/[^0-9]/', '', $withdrawal->pix_key);
                    break;

                case 'phoneNumber':
                    $chave_pix = preg_replace('/[^0-9]/', '', $withdrawal->pix_key);
                    break;

                case 'email':
                case 'randomKey':
                    $chave_pix = $withdrawal->pix_key;
                    break;
            }

            $postData = [
                'client_id'     => self::$clienteIdOnda,
                'client_secret' => self::$clienteSecretOnda,
                'nome'          => $withdrawal->name,
                'cpf'           => preg_replace('/[^0-9]/', '', $user->cpf ?? '00000000000'),
                'valor'         => (float) $withdrawal->amount,
                'chave_pix'     => $chave_pix,
                'urlnoty'       => url('/ondapay/callback'),
            ];

            // Endpoint Onda v2
            $url = self::$uriOnda . '/pix/payment.php';

            Log::info('[ONDAPAY → ECOMPAG] Payload de saque', [
                'url' => $url,
                'data' => $postData
            ]);

            $response = Http::asForm()->post($url, $postData);

            $responseData = $response->json();

            Log::info('[ONDAPAY → ECOMPAG] Resposta de saque', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $responseData
            ]);

            if ($response->successful() && is_array($responseData)) {
                if (isset($responseData['statusCode']) && $responseData['statusCode'] == 200) {
                    $withdrawal->update(['status' => 1]);
                    
                    OndaPay::create([
                        "user_id"       => $withdrawal->user_id,
                        "withdrawal_id" => $withdrawal->id,
                        "amount"        => $withdrawal->amount,
                        "status"        => 1,
                    ]);

                    Log::info('[ONDAPAY → ECOMPAG] Saque aprovado e atualizado no banco', [
                        'withdrawal_id' => $withdrawal->id,
                        'transaction_id' => $responseData['transactionId'] ?? null
                    ]);

                    return true;
                } else {
                    Log::error('[ONDAPAY → ECOMPAG] Erro no saque', [
                        'message' => $responseData['message'] ?? 'Erro desconhecido',
                        'response' => $responseData
                    ]);
                    return false;
                }
            }

            Log::error('[ONDAPAY → ECOMPAG] Falha na requisição de saque', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return false;
        }

        return false;
    }

    private static function generateDepositOnda($idTransaction, $amount)
    {
        $userId = auth('api')->user()->id;
        $wallet = Wallet::where('user_id', $userId)->first();

        Deposit::create([
            'payment_id' => $idTransaction,
            'user_id'   => $userId,
            'amount'    => $amount,
            'type'      => 'pix',
            'currency'  => $wallet->currency,
            'symbol'    => $wallet->symbol,
            'status'    => 0
        ]);
    }

    private static function generateTransactionOnda($idTransaction, $amount)
    {
        $setting = Core::getSetting();

        Transaction::create([
            'payment_id' => $idTransaction,
            'user_id' => auth('api')->user()->id,
            'payment_method' => 'pix',
            'price' => $amount,
            'currency' => $setting->currency_code,
            'status' => 0
        ]);
    }
}