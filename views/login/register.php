<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login</title>
    </head>
    <body>
        <form action="http://localhost:8080/signup" method="post">
            <label for="name">
                <input id="name" name="name" type="name" placeholder="Digite seu nome">
            </label>

            <label for="username">
                <input id="username" name="username" type="text" placeholder="Digite seu usuário">
            </label>

            <label for="password">
                <input id="password" name="password" type="password" placeholder="Digite sua senha">
            </label>

            <button type="submit">Cadastre-se</button>
        </form>
    </body>
</html>