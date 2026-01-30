<?php
define('FILEUSER', 'dat/usuarios.txt');
/**
 * 
 * Compruba que la usuario y la contraseña son correctos consultando
 * el archivo de datos
 * @param mixed $login
 * @param mixed $passwd
 * @return bool
 */
function userOk($login, $passwd): bool {

    if (!is_readable(FILEUSER)) {

        die("Error al crear el fichero.");
    }

    $filearray = file(FILEUSER);

    foreach ($filearray as &$linea) {

        $partes = explode('|', trim($linea));

        if ($partes[0] == $login && password_verify($passwd, $partes[1])) {

            return true;
        }  
    }
    return false;
}

/**
 *  Actualiza la password de un usuario en el archivo de datos
 * @param mixed $login
 * @param mixed $passwd
 * @return bool true si el usuarios existe en el fichero
 */
function updatePasswd($login, $passwd): bool {

    if (!is_readable(FILEUSER)) {

        die("Error al crear el fichero");
    }

    $fileContraseña = file(FILEUSER);
    $contraseñaActualizada = false;

    foreach ($fileContraseña as &$linea) {

        $partes = explode('|',(trim($linea)));

        if ($partes[0] == $login) {
            $partes[1] = password_hash($passwd, PASSWORD_DEFAULT);
            $linea = implode('|', $partes) . "\n";
            $contraseñaActualizada = true;
            break; 
        }
    }

    if ($contraseñaActualizada) {

        file_put_contents(FILEUSER, implode("", $fileContraseña));
        return true;
    }
    
    return false;
}