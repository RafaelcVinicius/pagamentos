<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.mercadopago.com/v2/security.js" view="item"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>

    <input id="firstCompany" type="button" onclick="payment()" value="Pague a compra"/>
    <div id="wallet_container"></div>
    <script>
        const mp = new MercadoPago('TEST-f77977b8-7bb1-4d1f-8b88-89c7fedbe11a');
        const bricksBuilder = mp.bricks();

        function payment(){
            const obj =
            {
                payerUuid: "fafff861-a91c-49a7-b8b8-e4a88eb54333",
                totalAmount: 1500,
                gateway: "MP",
                urlCallback: "https://rafaelcoldebella.com.br",
                webHook: "https://rafaelcoldebella.com.br/webHook",
                items : [{
                    id: 4521,
                    title: "Celular iPhone 15",
                    description: "Dispositivo de loja de comércio eletrônico móve",
                    picture_url: "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-14-model-unselect-gallery-1-202209?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1660689596976",
                    category_id: "Celular",
                    quantity: 1,
                    currency_id: "BRL",
                    unit_price: 1500,
                }]

            }

            fetch("/api/v1/intentions", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJIUzNDSzBFbTBINi1pZFBYTE9xWXFBeS1ndG00RTN1c0oweWh3YlRNdmtrIn0.eyJleHAiOjE3MDI3MTg2OTksImlhdCI6MTcwMjY4MjY5OSwianRpIjoiZjA3YWU1MTEtNmUzNC00ZTRiLThlZDgtOTEyOTNlNTg1MWFmIiwiaXNzIjoiaHR0cHM6Ly9hdXRoLnJhZmFlbGNvbGRlYmVsbGEuY29tLmJyL3JlYWxtcy9wYXltZW50cyIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiI1NDRlNTBjNy0wNTNiLTQ4MTctODljNC1jZDRiN2M5M2QxN2MiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJwYXltZW50c0NsaWVudCIsInNlc3Npb25fc3RhdGUiOiJlMzUwNjUzZC1lNjgyLTQwYTgtYjY1Mi0wMGJlMDNjMjdhNTgiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIi8qIl0sInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJkZWZhdWx0LXJvbGVzLXBheW1lbnRzIiwib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsInNpZCI6ImUzNTA2NTNkLWU2ODItNDBhOC1iNjUyLTAwYmUwM2MyN2E1OCIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlJhZmFlbCIsInByZWZlcnJlZF91c2VybmFtZSI6InJhZmFlbCIsImdpdmVuX25hbWUiOiJSYWZhZWwiLCJmYW1pbHlfbmFtZSI6IiIsImVtYWlsIjoicmFmYWVsLmNvbGRlYmVsbGFhQGdtYWlsLmNvbSJ9.PoxLKJuxGt-tx7KIMg7tgYiAg4KdwwFc4jcqg0-LDQniSR_cItCvT0GQNMwtOdxLbwgYDAXdOzjwX-Sn5wa1AttdNQHX7VnuHKJvTxvjsZ3fOqyYUtZwg9S3iht-KKPqfilApKdDcdfOgfkYxo2DnOuQBRHSDZBdLLxr7YnaZRo0TkBG5BZnA8lHujOW9LqtsnXutx9kAM8SU3Nmsm5XCMHFi8cvm5sYS-mWjYusLQ5n4IJawx3xWuYZofavmbMBN-OOqPTHgkPKeq2dZXI34Sm6_aZEpHw0dIcCTxupwZbN2RHUor7siDhAWkkcZLEaDdCmJupRcGSOWqmPyiuYyA'
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
