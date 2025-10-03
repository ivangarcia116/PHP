<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>¡Piedra, papel, tijera!</h1>

    <?php

    define('PIEDRA1',  "&#x1F91C;");
    define('PIEDRA2',  "&#x1F91B;");
    define('TIJERAS',  "&#x1F596;");
    define('PAPEL',    "&#x1F91A;");

    $valores = ["piedra", "papel", "tijeras"];

    $jugador1 = $valores[array_rand($valores)];
    $jugador2 = $valores[array_rand($valores)];

    function logoJuego($opcion, $jugador) {

        switch ($opcion) {

            case "piedra":

                if ($jugador == 1) {

                    return PIEDRA1;
                } 
                
                else {

                    return PIEDRA2;
                }

            case "papel":

                return PAPEL;


            case "tijeras":

                return TIJERAS;
        }
    }

    function obtenerResultado($resultadoJugador1, $resultadoJugador2) {

        if ($resultadoJugador1 == $resultadoJugador2) {

            return "¡Empate!";
        }

        if ($resultadoJugador1 == "piedra" && $resultadoJugador2 == "tijeras" || $resultadoJugador1 == "tijeras" && $resultadoJugador2 == "papel" ||
            $resultadoJugador1 == "papel" && $resultadoJugador2 == "piedra") {

            return "Gana el Jugador 1";
        } 
        
        else {

            return "Gana el Jugador 2";
        }
    }

    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Piedra, Papel o Tijera</title>
    </head>

    <body style="font-size: 50px; text-align: center;">

        <p>Actualize la página para mostrar otra partida.</p>

        <p>
            Jugador 1: <?= logoJuego($jugador1, 1) ?>
            
            Jugador 2: <?= logoJuego($jugador2, 2) ?>
        </p>

        <h3><?= obtenerResultado($jugador1, $jugador2) ?></h3>

    </body>

    </html>
