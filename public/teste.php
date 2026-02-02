<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Webhook Ecompag</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000000;
            color: #FFFFFF;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            width: 100%;
        }
        
        .card {
            background: #1a1a1a;
            border: 1px solid #DC2626;
            border-radius: 8px;
            padding: 30px;
        }
        
        h1 {
            color: #DC2626;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #DC2626;
            padding-bottom: 15px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            color: #999;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        
        input {
            width: 100%;
            padding: 10px 15px;
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            border-radius: 4px;
            color: #FFFFFF;
            font-size: 0.9rem;
        }
        
        input:focus {
            outline: none;
            border-color: #DC2626;
        }
        
        button {
            width: 100%;
            background: #DC2626;
            color: #FFFFFF;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        button:hover {
            background: #991B1B;
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            background: #2a2a2a;
            border-radius: 4px;
            display: none;
        }
        
        .result.show {
            display: block;
        }
        
        .result.success {
            border-left: 3px solid #059669;
        }
        
        .result.error {
            border-left: 3px solid #DC2626;
        }
        
        pre {
            background: #000;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            margin-top: 10px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🔔 Teste Webhook Ecompag</h1>
            
            <div class="form-group">
                <label>Transaction ID (do log acima):</label>
                <input type="text" id="transactionId" value="2763f486c4c28c1ab148mkmzic3e1thu" placeholder="Transaction ID">
            </div>
            
            <div class="form-group">
                <label>Valor (R$):</label>
                <input type="number" id="amount" value="2.00" step="0.01" placeholder="2.00">
            </div>
            
            <div class="form-group">
                <label>URL do Webhook:</label>
                <input type="text" id="webhookUrl" value="https://girocapital.fun/ondapay/callback" placeholder="https://girocapital.fun/ondapay/callback">
            </div>
            
            <button onclick="testarWebhook()">🚀 Simular Pagamento Confirmado</button>
            
            <div class="result" id="result"></div>
        </div>
    </div>

    <script>
        async function testarWebhook() {
            const transactionId = document.getElementById('transactionId').value;
            const amount = parseFloat(document.getElementById('amount').value);
            const webhookUrl = document.getElementById('webhookUrl').value;
            const result = document.getElementById('result');
            
            if (!transactionId || !amount || !webhookUrl) {
                alert('Preencha todos os campos!');
                return;
            }
            
            // Payload do webhook da Ecompag
            const payload = {
                transactionType: 'RECEIVEPIX',
                transactionId: transactionId,
                amount: amount,
                paymentType: 'PIX',
                status: 'PAID',
                dateApproval: new Date().toISOString().slice(0, 19).replace('T', ' '),
                creditParty: {
                    name: 'Jc_scripts',
                    email: 'teste@ecompag.com',
                    taxId: '11261678940'
                },
                debitParty: {
                    bank: 'Ecompag Pagamentos LTDA',
                    taxId: '59.667.922/0001-08'
                }
            };
            
            try {
                result.innerHTML = '<p>⏳ Enviando webhook...</p>';
                result.classList.add('show');
                result.classList.remove('success', 'error');
                
                const response = await fetch(webhookUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                
                const text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    data = text;
                }
                
                if (response.ok) {
                    result.classList.add('success');
                    result.innerHTML = `
                        <strong>✅ Webhook processado com sucesso!</strong>
                        <p>Status: ${response.status}</p>
                        <strong>Payload enviado:</strong>
                        <pre>${JSON.stringify(payload, null, 2)}</pre>
                        <strong>Resposta:</strong>
                        <pre>${typeof data === 'object' ? JSON.stringify(data, null, 2) : data}</pre>
                    `;
                } else {
                    result.classList.add('error');
                    result.innerHTML = `
                        <strong>❌ Erro ao processar webhook</strong>
                        <p>Status: ${response.status}</p>
                        <strong>Payload enviado:</strong>
                        <pre>${JSON.stringify(payload, null, 2)}</pre>
                        <strong>Resposta:</strong>
                        <pre>${typeof data === 'object' ? JSON.stringify(data, null, 2) : data}</pre>
                    `;
                }
            } catch (error) {
                result.classList.add('error');
                result.innerHTML = `
                    <strong>❌ Erro na requisição</strong>
                    <p>${error.message}</p>
                    <strong>Payload que seria enviado:</strong>
                    <pre>${JSON.stringify(payload, null, 2)}</pre>
                `;
            }
        }
    </script>
</body>
</html>