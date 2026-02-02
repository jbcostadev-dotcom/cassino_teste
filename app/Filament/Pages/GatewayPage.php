<?php

namespace App\Filament\Pages;

use App\Models\Gateway;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;


class GatewayPage extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.gateway-page';

    public ?array $data = [];
    public Gateway $setting;

    /**
     * @dev
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin'); // Controla o acesso total à página
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin'); // Controla a visualização de elementos específicos
    }

    /**
     * @return void
     */
    public function mount(): void
    {
        $gateway = Gateway::first();
        if (!empty($gateway)) {
            $this->setting = $gateway;
            $this->form->fill($this->setting->toArray());
        } else {
            $this->form->fill();
        }
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('REGISTRE SUAS CHAVES DE API GATEWAY')
                    ->description('Configure suas chaves de API para processamento de pagamentos')
                    ->schema([
                        Section::make('ECOMPAG - API PIX COMPLETA')
                            ->description(new HtmlString('
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <div style="display: flex; align-items: center;">
                                        Integre pagamentos e transferências PIX com nossa API robusta, rápida e segura - Registro aprova na hora:
                                        <a class="dark:text-white"
                                            style="
                                                font-size: 14px;
                                                font-weight: 600;
                                                width: 150px;
                                                display: flex;
                                                background-color: #00b91e;
                                                padding: 10px;
                                                border-radius: 11px;
                                                justify-content: center;
                                                margin-left: 10px;
                                            "
                                            href="https://ecompag.com"
                                            target="_blank">
                                            Documentação
                                        </a>
                                    </div>
                                    <div style="
                                        background-color: #fef3c7;
                                        border-left: 4px solid #f59e0b;
                                        padding: 12px;
                                        border-radius: 8px;
                                        color: #92400e;
                                        margin-top: 10px;
                                    ">
                                        <strong>⚠️ IMPORTANTE:</strong> Para sacar via API, é necessário adicionar o IP do seu servidor na whitelist da ECOMPAG.
                                        <a 
                                            style="
                                                font-size: 14px;
                                                font-weight: 600;
                                                display: inline-flex;
                                                background-color: #f59e0b;
                                                color: white;
                                                padding: 8px 16px;
                                                border-radius: 8px;
                                                margin-left: 10px;
                                                text-decoration: none;
                                            "
                                            href="https://ecompag.com/meuip"
                                            target="_blank">
                                            🔍 Pegar meu IP
                                        </a>
                                    </div>
                                </div>
                        '),)
                            ->schema([
                                TextInput::make('ondapay_uri')
                                    ->label('URL DA API')
                                    ->placeholder('https://ecompag.com/api-pix')
                                    ->maxLength(191)
                                    ->columnSpanFull(),
                                TextInput::make('ondapay_client')
                                    ->label('CLIENT ID')
                                    ->placeholder('Digite o client ID')
                                    ->maxLength(191)
                                    ->columnSpanFull(),
                                TextInput::make('ondapay_secret')
                                    ->label('CLIENT SECRET')
                                    ->placeholder('Digite o client secret')
                                    ->maxLength(191)
                                    ->columnSpanFull(),
                            ]),

                        // Confirmação de Alteração
                        Section::make('Confirmação de Alteração')
                            ->schema([
                                TextInput::make('admin_password')
                                    ->label('Senha de 2FA a que esta no arquivo (.env)')
                                    ->placeholder('Digite a senha de 2FA')
                                    ->password()
                                    ->required()
                                    ->dehydrateStateUsing(fn($state) => null), // Para que o valor não seja persistido
                            ]),

                    ]),
            ])
            ->statePath('data');
    }


    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            if (env('APP_DEMO')) {
                Notification::make()
                    ->title('Atenção')
                    ->body('Você não pode realizar esta alteração na versão demo')
                    ->danger()
                    ->send();
                return;
            }

            // Validação da senha de 2FA
            if (
                !isset($this->data['admin_password']) ||
                $this->data['admin_password'] !== env('TOKEN_DE_2FA')
            ) {
                Notification::make()
                    ->title('Acesso Negado')
                    ->body('A senha de 2FA está incorreta. Você não pode atualizar os dados.')
                    ->danger()
                    ->send();
                return;
            }

            $setting = Gateway::first();
            if (!empty($setting)) {
                if ($setting->update($this->data)) {
                    Notification::make()
                        ->title('Configurações Atualizadas')
                        ->body('Suas configurações foram atualizadas com sucesso!')
                        ->success()
                        ->send();
                }
            } else {
                if (Gateway::create($this->data)) {
                    Notification::make()
                        ->title('Configurações Criadas')
                        ->body('Suas configurações foram criadas com sucesso!')
                        ->success()
                        ->send();
                }
            }
        } catch (\Filament\Support\Exceptions\Halt $exception) {
            Notification::make()
                ->title('Erro ao alterar dados!')
                ->body('Erro ao alterar dados!')
                ->danger()
                ->send();
        }
    }

}