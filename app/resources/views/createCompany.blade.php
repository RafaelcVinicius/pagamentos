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
        const mp = new MercadoPago('APP_USR-8e558cad-4b8b-467a-83c2-0f3ea8b049f7');
        const bricksBuilder = mp.bricks();

        function payment(){
            const obj =
            {
                payerUuid: "9167a6d6-25af-4934-996d-0e0598a68994",
                totalAmount: 1,
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
                    unit_price: 1,
                }]

            }

            fetch("/api/v1/intentions", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJIUzNDSzBFbTBINi1pZFBYTE9xWXFBeS1ndG00RTN1c0oweWh3YlRNdmtrIn0.eyJleHAiOjE3MDI3ODQ4NDYsImlhdCI6MTcwMjc0ODg0NiwianRpIjoiZDdmMTk5NzMtMDdhMS00Y2E1LWE2NWUtZmE1ZTgzMjJmZjg2IiwiaXNzIjoiaHR0cHM6Ly9hdXRoLnJhZmFlbGNvbGRlYmVsbGEuY29tLmJyL3JlYWxtcy9wYXltZW50cyIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiI1NDRlNTBjNy0wNTNiLTQ4MTctODljNC1jZDRiN2M5M2QxN2MiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJwYXltZW50c0NsaWVudCIsInNlc3Npb25fc3RhdGUiOiJmYzY5N2ZkNS00MDYwLTQxMmMtYjNjYi03ZTNiMGVjMGZiNzIiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIi8qIl0sInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJkZWZhdWx0LXJvbGVzLXBheW1lbnRzIiwib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsInNpZCI6ImZjNjk3ZmQ1LTQwNjAtNDEyYy1iM2NiLTdlM2IwZWMwZmI3MiIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlJhZmFlbCIsInByZWZlcnJlZF91c2VybmFtZSI6InJhZmFlbCIsImdpdmVuX25hbWUiOiJSYWZhZWwiLCJmYW1pbHlfbmFtZSI6IiIsImVtYWlsIjoicmFmYWVsLmNvbGRlYmVsbGFhQGdtYWlsLmNvbSJ9.vRSi_b8VMh0lBQteIzOWSSS1kGJR9djD3bTqKQiVM4CBi5Vrj0inO0hijf7weftTtvGAqOnufVj5vrxmIqF1mTS8E5B7g-0eT4mHPV6FccprGMXLjUmr7kgXW11GjDZ9z_rQw8zH79gHYAWgxUKXQtPEFCdA_IewwQe_UdD-z3-LpzNucRYP6NT-lbQ1rwns3lb4gqC34HIA65FVxczDGynATWGPAmHnLqAZAmv5gimhEMY4ndWkSQe-SntpCbxlk6FUk4apQjJTk2VjqBuq3Qgvs5Kea6puZzqXS08VPOi05ZxMTOSaLwT8q-SzrnZ_TA5TJDRNCEfoAwpS2wg4aQ'
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
