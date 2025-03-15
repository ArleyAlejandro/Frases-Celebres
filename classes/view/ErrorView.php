<?php
class ErrorView
{
    public static function show($error)
    {
?>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Frases</title>
            <link rel="stylesheet" type="text/css" href="./css/styles.css">
        </head>

        <body id="errorBody">
            <div class="container">
                <h1>¡ERROR!</h1>
                <p class="error"> <?= $error ?></p>
                <button onclick="location.href='?autor/show'">Volver</button>
            </div>
        </body>

<?php
    }
}
?>