<?php
session_start();

if (!isset($_COOKIE['visitas'])) {
    $visitas = 1;
} 

else {

    $visitas = $_COOKIE['visitas'] + 1;
}

setcookie('visitas', $visitas, time() + (30 * 24 * 3600));

if (isset($_SESSION['dinero']) && $_SESSION['dinero'] > 0) {

    header("Location: juegoCasino.php");
    exit;
}

if (isset($_POST['dinero'])) {

    $_SESSION['dinero'] = intval($_POST['dinero']);
    header("Location: juegoCasino.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino</title>
</head>
<body>
    <h1>BIENVENIDO AL CASINO</h1>
    <h3>Esta es su <?php echo $visitas; ?>º visita.</h3>
    <form method="post" action="index.php">
        Introduzca el dinero con el que va a jugar: 
        <input type="number" name="dinero" id="dinero" required min="1">
        <input type="submit" value="Jugar">
    </form>
</body>
</html>