<?php

$img_default = "uploads/calavera.png";


function verFormulario() {

    include("captura.html");
}


function verResultado() {

    global $img_default;


    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : ""; 
    $alias  = isset($_POST['alias']) ? $_POST['alias'] : "";
    $edad   = isset($_POST['edad']) ? intval($_POST['edad']) : 0;
    $armas  = isset($_POST['armas']) ? $_POST['armas'] : [];
    $magia  = isset($_POST['magia']) ? $_POST['magia'] : "no";

    $imagen_a_mostrar = $img_default;
    $mensaje = "";

    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['name'] != "") {

        $img = $_FILES['imagen'];
        $tipo_correcto = $img['type'] == 'image/png';
        $tam_ok = $img['size'] <= 10240; 

        if ($img['error'] == 0 && $tipo_correcto && $tam_ok) {
            
            $nombre_nuevo = "jugador_" . uniqid() . ".png";
            $ruta = "uploads/" . $nombre_nuevo;

            
            if (move_uploaded_file($img['tmp_name'], $ruta)) {
                $imagen_a_mostrar = $ruta;
            } else {
                $mensaje = "No se pudo mover la imagen al destino.";
            }
        } else {
        
            if (!$tipo_correcto) {
                $mensaje = "Solo se permiten imágenes PNG.";
            } elseif (!$tam_ok) {
                $mensaje = "La imagen no puede pesar más de 10KB.";
            } else {
                $mensaje = "Ocurrió un error al subir la imagen.";
            }
        }
    }

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <title>Resultado del Jugador</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="resultado">
            <h2>Datos del Jugador</h2>
            <div class="resultado-contenido">
                <div class="datos">
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                    <p><strong>Alias:</strong> <?php echo htmlspecialchars($alias); ?></p>
                    <p><strong>Edad:</strong> <?php echo $edad; ?></p>
                    <p><strong>Armas:</strong> <?php echo htmlspecialchars(implode(", ", $armas)); ?></p>
                    <p><strong>¿Usa magia?:</strong> <?php echo htmlspecialchars($magia); ?></p>
                </div>

                <div class="imagen">
                    <?php if ($imagen_a_mostrar != $img_default) { ?>
                        <p><strong>Imagen subida:</strong></p>
                    <?php } else { ?>
                        <p><strong>Imagen por defecto:</strong></p>
                    <?php } ?>

                    <img src="<?php echo $imagen_a_mostrar; ?>" alt="Imagen del jugador">

                    <?php if ($mensaje != "") { ?>
                        <p class="error"><?php echo $mensaje; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    verResultado();
}
 else {
    verFormulario();
}
?>