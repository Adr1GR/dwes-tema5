<?php

//Comprueba si un usuario existe en la base de datos
function user_already_exist($nombre)
{
    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
        return false;
    }

    //Preparacion
    $sentencia = $mysqli->prepare('select count(nombre) as cantidad from usuario where nombre = ?');
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
        return false;
    }

    //Vinculacion
    $vinculacion = $sentencia->bind_param('s', $nombre);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
        return false;
    }

    //Ejecutamos
    $ejecucion  = $sentencia->execute();
    if (!$ejecucion) {
        echo "Falló al ejecutar la sentencia: " . $mysqli->error;
        $sentencia->close();
        exit();
        return false;
    }

    // Obtenemos los resultados con get_result()
    $resultado = $sentencia->get_result();
    if (!$resultado) {
        echo "Falló al obtener los resultados.";
        $sentencia->close();
        exit();
        return false;
    }

    // Usamos el objeto mysqi_result para obtener la fila obtenida en la SELECT
    $fila = $resultado->fetch_assoc();
    if ($fila != null) {
        if ($fila['cantidad'] == 1) {
            //Cerramos todo
            $sentencia->close();
            $mysqli->close();
            return true;
        } else {
            //Cerramos todo
            $sentencia->close();
            $mysqli->close();
            return false;
        }
    }
}

//Añade un nuevo usuario a la base de datos
function add_new_user($nombre, $clave)
{
    $clave = md5($clave);

    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
        return null;
    }

    //Preparacion
    $sentencia = $mysqli->prepare("insert into usuario (nombre, clave) values (?, ?)");
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
        return null;
    }

    //Vinculacion
    $vinculacion = $sentencia->bind_param('ss', $nombre, $clave);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
        return null;
    }

    //Ejecutamos
    $resultado = $sentencia->execute();
    if (!$resultado) {
        echo "Algo grave ha sucedido: " . $mysqli->error;
        return null;
    }

    //Cerramos todo
    $sentencia->close();
    $mysqli->close();

    return $nombre;
}

//Usuario se puede logear
function user_can_login($nombreSaneado, $claveCifrada)
{
    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
        return false;
    }

    //Preparacion
    $sentencia = $mysqli->prepare('select clave from usuario where nombre = ?');
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
        return false;
    }

    //Vinculacion
    $vinculacion = $sentencia->bind_param('s', $nombreSaneado);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
        return false;
    }

    //Ejecutamos
    $ejecucion  = $sentencia->execute();
    if (!$ejecucion) {
        echo "Falló al ejecutar la sentencia: " . $mysqli->error;
        $sentencia->close();
        exit();
        return false;
    }

    // Obtenemos los resultados con get_result()
    $resultado = $sentencia->get_result();
    if (!$resultado) {
        echo "Falló al obtener los resultados.";
        $sentencia->close();
        exit();
        return false;
    }

    // Usamos el objeto mysqi_result para obtener la fila obtenida en la SELECT
    $fila = $resultado->fetch_assoc();
    if ($fila != null) {
        if ($fila['clave'] === $claveCifrada) {
            //Cerramos todo
            $sentencia->close();
            $mysqli->close();
            return true;
        } else {
            //Cerramos todo
            $sentencia->close();
            $mysqli->close();
            return false;
        }
    }
}

function get_user_id_by_name($nombre)
{
    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
        return [];
    }

    //Preparacion
    $sentencia = $mysqli->prepare('select id from usuario where nombre = ?');
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
        return [];
    }

    //Vinculacion
    $vinculacion = $sentencia->bind_param('s', $nombre);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
        return [];
    }

    //Ejecutamos
    $ejecucion  = $sentencia->execute();
    if (!$ejecucion) {
        echo "Falló al ejecutar la sentencia: " . $mysqli->error;
        $sentencia->close();
        exit();
        return [];
    }

    // Obtenemos los resultados con get_result()
    $resultado = $sentencia->get_result();
    if (!$resultado) {
        echo "Falló al obtener los resultados.";
        $sentencia->close();
        exit();
        return [];
    }

    // Usamos el objeto mysqi_result para obtener la fila obtenida en la SELECT
    $fila = $resultado->fetch_assoc();
    if ($fila != null) {
        $sentencia->close();
        $mysqli->close();
        return $fila['id'];
    } else {
        $sentencia->close();
        $mysqli->close();
        return [];
    }
}

//Sube una imagen a la base de datos
function subir_imagen($nombre, $fichero, $idUsuario)
{

    $path = $fichero['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $rutaFichero = "imagenes/" . $nombre . "." . $ext;

    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
    }

    //Preparacion
    $sentencia = $mysqli->prepare("insert into imagen (nombre, ruta, subido, usuario) values (?, ?, UNIX_TIMESTAMP(), ?)");
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
    }

    //Vinculacion
    $vinculacion = $sentencia->bind_param('ssi', $nombre, $rutaFichero, $idUsuario);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
    }

    //Ejecutamos
    $resultado = $sentencia->execute();
    if (!$resultado) {
        echo "Algo grave ha sucedido: " . $mysqli->error;
    }

    //Cerramos to
    $sentencia->close();
    $mysqli->close();

    return $nombre;
}

function delete_image_from_id($id)
{

    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
        return null;
    }

    //Preparacion
    $sentencia = $mysqli->prepare("delete from imagen where id = ?");
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
        return null;
    }

    //Vinculacion
    $vinculacion = $sentencia->bind_param('i', $id);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
        return null;
    }

    //Ejecutamos
    $resultado = $sentencia->execute();
    if (!$resultado) {
        echo "Algo grave ha sucedido: " . $mysqli->error;
        return null;
    }

    //Cerramos todo
    $sentencia->close();
    $mysqli->close();

    return true;
}

function get_image_name_from_id($id)
{
    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
        return [];
    }

    //Preparacion
    $sentencia = $mysqli->prepare('select ruta from imagen where id = ?');
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
        return [];
    }

    //Vinculacion
    $vinculacion = $sentencia->bind_param('i', $id);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
        return [];
    }

    //Ejecutamos
    $ejecucion  = $sentencia->execute();
    if (!$ejecucion) {
        echo "Falló al ejecutar la sentencia: " . $mysqli->error;
        $sentencia->close();
        exit();
        return [];
    }

    // Obtenemos los resultados con get_result()
    $resultado = $sentencia->get_result();
    if (!$resultado) {
        echo "Falló al obtener los resultados.";
        $sentencia->close();
        exit();
        return [];
    }

    // Usamos el objeto mysqi_result para obtener la fila obtenida en la SELECT
    $fila = $resultado->fetch_assoc();
    if ($fila != null) {
        $sentencia->close();
        $mysqli->close();
        return $fila['ruta'];
    } else {
        $sentencia->close();
        $mysqli->close();
        return [];
    }
}


function filter_images_by_name($nombre)
{
    //Conectamos
    $mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
    if ($mysqli->connect_errno) {
        echo "No ha sido posible conectarse a la base de datos.";
        exit();
        return [];
    }

    //Preparacion
    $sentencia = $mysqli->prepare('select i.nombre, i.ruta, i.id, u.nombre as nombreUser from imagen i join usuario u on i.usuario = u.id where i.nombre like ?');
    if (!$sentencia) {
        echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
        return [];
    }

    //Vinculacion
    $nombre = '%' . $nombre . '%';
    $vinculacion = $sentencia->bind_param('s', $nombre);
    if (!$vinculacion) {
        echo "Falló la vinculación de parámetros: (" . $sentencia->errno . ") " . $mysqli->error;
        $sentencia->close();
        exit();
        return [];
    }

    //Ejecutamos
    $ejecucion  = $sentencia->execute();
    if (!$ejecucion) {
        echo "Falló al ejecutar la sentencia: " . $mysqli->error;
        $sentencia->close();
        exit();
        return [];
    }

    // Obtenemos los resultados con get_result()
    $resultado = $sentencia->get_result();
    if (!$resultado) {
        echo "Falló al obtener los resultados.";
        $sentencia->close();
        exit();
        return [];
    }

    // Usamos el objeto mysqi_result para obtener la fila obtenida en la SELECT
    if (!$resultado) {
        return [];
    } else {
        return $resultado;
    }
}
