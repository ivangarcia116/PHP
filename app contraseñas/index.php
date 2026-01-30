<?php 

include_once 'util.php';
session_start();

$mensaje = "";

if (!isset($_SESSION['usuario']) && (!isset($_POST['orden']) || $_POST['orden'] != "entrar")) {

    include_once 'vistas/acceso.php';
    die();
}

if (isset($_POST['orden']) && $_POST['orden'] == "entrar" ) {
    
    // Campos de usuario y contraseña rellenos
    if (empty($_REQUEST['username']) || empty($_REQUEST['password'])) {

        $mensaje = "Debe rellenar los campos";
        include_once 'vistas/acceso.php';
        die();
    }

    else if (userOk($_REQUEST['username'], $_REQUEST['password'])) {

        // con valores correctos
        // Actualizo variable de sesión
        $_SESSION['usuario'] = $_REQUEST['username'];
        include_once 'vistas/cambiarcontra.php';
        die();
    }

    else {

        // Si falla muestro acceso.php
        $mensaje = " Usuario y contraseña no válidos";
        include_once 'vistas/acceso.php';
        die();
    }
}

if (isset($_POST['orden']) && $_POST['orden'] == "cambiar" ) {

    

    // Comprobar que los campos están llenos
    // Se cambia si la contraseña antigua es correcta
    // Y las nuevas contraseñas son iguales sino volvemos
    // a mostrar cambiar contra y cerramos la sesión
    // si falla muestro cambiarcontra.php

    if (empty($_REQUEST['password']) || empty($_REQUEST['password1']) || empty($_REQUEST['password2'])) {

        $mensaje = "Debes de rellenar todos los campos";
        include_once 'vistas/cambiarcontra.php';
        die();
    }

    if (!userOk($_SESSION['usuario'], $_REQUEST['password'])) {

        $mensaje = "La contraseña antigua no coincide";
        include_once 'vistas/cambiarcontra.php';
        die();
    }

    if ($_REQUEST['password1'] !== $_REQUEST['password2']) {

        $mensaje = "Las contraseñas no coinciden";
        include_once 'vistas/cambiarcontra.php';
        die();
    }


    if (updatePasswd($_SESSION['usuario'], $_REQUEST['password1'])) {

        session_destroy();
        include_once 'vistas/resultado.php';
        die();
    }

    else {

        $mensaje = "Error, No se ha podido actualizar la contraseña";
        include_once 'vistas/cambiarcontra.php';
        die();
    }   
}