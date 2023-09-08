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
    </style>
</head>
<body>
        <form action="/create" method="post">
            @csrf
            <label for="accessToken">Public key</label>
            <input type="text" id="publicKey" name="publicKey">
            <label for="accessToken">Access token</label>
            <input type="text" id="accessToken" name="accessToken">
            <button type="submit" id="submit">Create</button>
        </form>
</body>
</html>
