<?php
session_start();

if (!isset($_SESSION['dinero']) || $_SESSION['dinero'] <= 0) {

    header("Location: index.php");
    exit;
}

if (isset($_POST['salir'])) {

    header("Location: salir.php");
    exit;
}

if (!isset($_COOKIE['visitas'])) {
    $visitas = 1;
} 

else {

    $visitas = $_COOKIE['visitas'] + 1;
}

setcookie('visitas', $visitas, time() + (30 * 24 * 3600));

if (isset($_POST['apostar'])) {

    $apuesta = intval($_POST['dinero']);
    $eleccion = $_POST['eleccion'];
    $dinero = $_SESSION['dinero'];

    if ($apuesta > $dinero || $apuesta <= 0) {

        $mensaje = "Error: no dispone de $apuesta euros disponibles. Dispone de $dinero para jugar.";
    } 
    
    else {

        $numero = rand(1, 100);
        $resultado = ($numero % 2 == 0) ? "par" : "impar";

        if ($eleccion == $resultado) {

            $dinero += $apuesta;
            $mensaje = "Ha ganado. Salió $resultado ($numero).";
        } 
        
        else {

            $dinero -= $apuesta;
            $mensaje = "Ha perdido. Salió $resultado ($numero).";
        }

        $_SESSION['dinero'] = $dinero;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del juego</title>
</head>

<body>
    <h1>RESULTADO DEL JUEGO</h1>
    <h3>Esta es su <?php echo $visitas; ?>º visita.</h3>

    <p>Saldo disponible para jugar: <strong><?php echo $_SESSION['dinero']; ?>€</strong></p>
    <?php if (isset($mensaje)): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <form method="post" action="juegoCasino.php">
        <p>Cantidad a apostar:
            <input type="number" name="dinero" id="dinero">
        </p>
        <p>Tipo de apuesta:
            <input type="radio" name="eleccion" id="par" value="par">
            <label for="par">Par</label>
            <input type="radio" name="eleccion" id="impar" value="impar">
            <label for="impar">Impar</label>
        </p>
        <input type="submit" name="apostar" value="Apostar Cantidad">
        <input type="submit" name="salir" value="Abandonar el casino">
    </form>

</body>
</html>