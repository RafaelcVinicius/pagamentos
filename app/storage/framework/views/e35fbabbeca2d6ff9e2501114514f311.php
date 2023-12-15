<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>

    <input id="firstCompany" type="button" onclick="payment()" value="Pague a compra"/>
    <div id="wallet_container"></div>
    <script>
        const mp = new MercadoPago('TEST-977ad40e-8a38-47ef-949c-2f915fc2640f');
        const bricksBuilder = mp.bricks();

        function payment(){
            const obj =
            {
                payerUuid: "fafff861-a91c-49a7-b8b8-e4a88eb54333",
                totalAmount: 10.00,
                gateway: "MP",
                urlCallback: "https://rafaelcoldebella.com.br",
                webHook: "https://rafaelcoldebella.com.br/webHook",
                items : [{
                    id: 1234,
                    title: "Celular iPhone 15",
                    description: "Dispositivo de loja de comércio eletrônico móve",
                    picture_url: "https://m.media-amazon.com/images/I/81gTH9iEn+L._AC_SX679_.jpg",
                    category_id: "Celular",
                    quantity: 1,
                    currency_id: "BRL",
                    unit_price: 10,
                }]

            }

            fetch("/api/v1/intentions", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJIUzNDSzBFbTBINi1pZFBYTE9xWXFBeS1ndG00RTN1c0oweWh3YlRNdmtrIn0.eyJleHAiOjE3MDI2ODM1NTUsImlhdCI6MTcwMjY0NzU1NSwianRpIjoiMDcxYzRmYzYtZWZmMS00NjJmLWIwNGItNTk0YmMxZDExYWM4IiwiaXNzIjoiaHR0cHM6Ly9hdXRoLnJhZmFlbGNvbGRlYmVsbGEuY29tLmJyL3JlYWxtcy9wYXltZW50cyIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiI1NDRlNTBjNy0wNTNiLTQ4MTctODljNC1jZDRiN2M5M2QxN2MiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJwYXltZW50c0NsaWVudCIsInNlc3Npb25fc3RhdGUiOiJlZDRkNzJjNC1hZTdjLTRkYTctOTM2Zi1kZGViZTk0ZDZjNDgiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIi8qIl0sInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJkZWZhdWx0LXJvbGVzLXBheW1lbnRzIiwib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsInNpZCI6ImVkNGQ3MmM0LWFlN2MtNGRhNy05MzZmLWRkZWJlOTRkNmM0OCIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlJhZmFlbCIsInByZWZlcnJlZF91c2VybmFtZSI6InJhZmFlbCIsImdpdmVuX25hbWUiOiJSYWZhZWwiLCJmYW1pbHlfbmFtZSI6IiIsImVtYWlsIjoicmFmYWVsLmNvbGRlYmVsbGFhQGdtYWlsLmNvbSJ9.sUpaABTxFXxwaO5dvKVTXgGr0Kh7vg9s_1_MLcdkQRcLFDzTU0kAV2n-B72pJaRmlwarYm6FWOCJ7D9u3tycmateyPkWF56sZq7ZXrp-N_Inypxbu1kyeyf_-a2UOYXFmdh-eiQbHu_qHeDmnkLyh1GBKMwgc70LQHWM0mCw-KB0MmWx_KUi443r5SJE20caYL_eX-0zhGq8dVORzG6z9It5qoX-BbPdLzLW6RSBm2noZZXu36A1TpI3pOJNCWhd_RKIHlmkHhRdRm4b4CGA0AIvC3qVNOlMnDKvkygooEsere4m0A5gKPejt0GW9y9akLN9MWtUiUsmnqoNAjr0Ng'
                },
                body: JSON.stringify(obj),
            })
            .then(response => {
                console.log(response);
                return response.json();
            })
            .then(data => {
                // 'data' contém o conteúdo da resposta da API
                console.log('Resposta da API:', data);
                console.log('Resposta da API:', data.data);
                console.log('Resposta da API:', data.data.preferencesId);

                // alert("Erro ao fazer a requisição: " + data.message)
                mp.bricks().create("wallet", "wallet_container", {
                    initialization: {
                        preferenceId: data.data.preferencesId,
                    },
                });
            })
            .catch(error => {
                console.error('Erro:', error);
                alert("Erro ao fazer a requisição:" + error)
            });
        }
    </script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/createCompany.blade.php ENDPATH**/ ?>