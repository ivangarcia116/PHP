<?php

define ('FICHERO', 'bicis.csv');
require_once 'BiciElectrica.php';

function cargarBicis(): array {

    $fichero = @fopen(FICHERO, 'r');

    if (!$fichero) {

        die ("Error al abrir el fichero");
    }

    $tabla = [];

    while ($datosBici = fgetcsv($fichero)) {

        $bici = new BiciElectrica ($datosBici[0],$datosBici[1], $datosBici[2], $datosBici[3], $datosBici[4]);
        $tabla[] = $bici;
    }

    return $tabla;
}

function mostrarTablaBicis($tabla): string {

   $cadena = "<table><tr><th>ID</th><th>Coord X</th><th>Coord Y</th><th>Batería</th></tr>";

    foreach ($tabla as $bici) {

        if ($bici -> operativa == 1) {

        $cadena .= "<tr>";
        $cadena .= "<td>".$bici->id . "</td>";
        $cadena .= "<td>".$bici->coordx ."</td>";
        $cadena .= "<td>".$bici->coordy ."</td>";
        $cadena .= "<td>".$bici->bateria ."%</td>";
        $cadena .= "</tr>";

        }
    }

    $cadena .= "</table>";
    return $cadena;

}

function biciMasCercana($x, $y, $tabla) {

    $biciMin = null;

    $distanciaMin = PHP_INT_MAX;

    foreach ($tabla as $bici) {

        if ($bici->operativa == 1) {

            $distancia = $bici->distancia($x, $y);
        }

        if ($distancia < $distanciaMin) {

            $biciMin = $bici;
            $distanciaMin = $distancia;
        }
    }

    return $biciMin;
}


// Programa principal
$tabla = cargarBicis();

if (!empty($_GET['coordx']) && !empty($_GET['coordy'])) {

    $biciRecomendada = biciMasCercana($_GET['coordx'], $_GET['coordy'], $tabla);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MOSTRAR BICIS OPERATIVAS</title>

    <style>

        table,
        th,
        td {

            border: 1px solid black;
        }

    </style>
</head>
<body>

    <h1> Listado de bicicletas operativas </h1>
    <?= mostrarTablaBicis($tabla); ?>
    <?php if (isset($biciRecomendada)) : ?>
        <h2> Bicicleta disponible más cercana es <?= $biciRecomendada ?> </h2>
        <button onclick="history.back()"> Volver </button>
    <?php else : ?>
        <h2> Indicar su ubicación: <h2>
                <form>
                    Coordenada X: <input type="number" name="coordx"><br>
                    Coordenada Y: <input type="number" name="coordy"><br>
                    <input type="submit" value=" Consultar ">
                </form>
    <?php endif ?>

</body>
</html>