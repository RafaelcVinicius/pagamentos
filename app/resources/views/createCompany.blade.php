<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagamentos-create div{
            display: flex;
            flex-direction: column;
            margin-bottom: 5px;
        }

        #submit{
            width: 250px;
            height: 30px;
            background-color: rgb(49, 108, 218);
            border: none;
            color: #fff;
            cursor: pointer;
        }

        #firstCompany{
            margin-top: 5px;
            width: 250px;
            height: 30px;
            background-color: rgb(43, 214, 94);
            border: none;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="pagamentos-create">
        <form action="/create" method="post">
            @csrf
            <div>
                <label for="accessToken">Public key</label>
                <input type="text" id="publicKey" name="publicKey">
            </div>
            <div>
                <label for="accessToken">Access token</label>
                <input type="text" id="accessToken" name="accessToken">
            </div>
            <button type="submit" id="submit">Create</button>
        </form>

        <button id="firstCompany" onclick="firstCompany()">Company - Rafael</button>
    </div>
<script>

function firstCompany(){
    window.location = window.location.protocol + "//" + window.location.host + "/payment/1";
}
</script>
</body>
</html>
