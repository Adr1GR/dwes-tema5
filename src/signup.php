<?php

/*********************************************************************************************************************
 * Este script realiza el registro del usuario vía el POST del formulario que hay debajo, en la vista.
 * 
 * Cuando llegue POST hay que validarlo y si todo fue bien insertar en la base de datos el usuario.
 * 
 * Requisitos del POST:
 * - El nombre de usuario no tiene que estar vacío y NO PUEDE EXISTIR UN USUARIO CON ESE NOMBRE EN LA BASE DE DATOS.
 * - La contraseña tiene que ser, al menos, de 8 caracteres.
 * - Las contraseñas tiene que coincidir.
 * 
 * La contraseña la tienes que guardar en la base de datos cifrada mediante el algoritmo BCRYPT.
 * 
 * UN USUARIO LOGEADO NO PUEDE ACCEDER A ESTE SCRIPT.
 */

/**********************************************************************************************************************
 * Lógica del programa
 * 
 * Tareas a realizar:
 * - TODO: tienes que realizar toda la lógica de este script
 */

require("./bd.php");

session_start();

//Si hay sesion de usuario volvemos al index, aunque si esta logeado no deberia tener el boton de register
if (isset($_SESSION['usuario'])) {
    header('location: index.php');
}

function validarNombre($nombre, $errores)
{
    $nombre = htmlspecialchars($nombre);
    $nombre = trim($nombre, " ");
    $estado = true;
    if (strlen($nombre) > 10) {
        array_push($errores['nombre'], 'El nombre no puede superar los 10 caracteres');
        $estado = false;
    }
    return [
        'estado' => $estado,
        'nombre' => $nombre,
        'errores' => $errores
    ];
}

function validarClave($clave, $errores)
{
    $estado = true;
    if (strlen($clave) < 8) {
        $estado = false;
        array_push($errores['clave'], 'Usa 8 caracteres como mínimo para la contraseña');
    }
    if (strlen($clave) > 200) {
        $estado = false;
        array_push($errores['clave'], 'La contraseña no puede superar los 200 caracteres');
    }
    return [
        'estado' => $estado,
        'clave' => $clave,
        'errores' => $errores
    ];
}

function validarClaveRepetida($clave, $claveRepetida, $errores)
{
    $estado = true;
    if ($clave != $claveRepetida) {
        $estado = false;
        array_push($errores['claveRepetida'], 'Las contraseñas no coinciden');
    }
    return [
        'estado' => $estado,
        'errores' => $errores
    ];
}

$validacionGeneral = false;
$errores = [
    'nombre' => [],
    'clave' => [],
    'claveRepetida' => [],
    'usuario' => []
];

//Comprobamos que hay $_POST para registar un usuario
if ($_POST) {

    //Validar nombre
    if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
        $validacionNombre = validarNombre($_POST['nombre'], $errores);
        $errores = $validacionNombre['errores'];
    } else {
        array_push($errores['nombre'], 'Se necesita un nombre');
    }

    //Validar clave
    if (isset($_POST['clave']) && $_POST['clave'] != '') {
        $validacionClave = validarClave($_POST['clave'], $errores);
        $errores = $validacionClave['errores'];
    } else {
        array_push($errores['clave'], 'Se necesita una contraseña');
    }

    //Validar clave repetida
    if (isset($_POST['repite_clave']) && $_POST['repite_clave'] != '') {
        $validacionClaveRepetida = validarClaveRepetida($_POST['clave'], $_POST['repite_clave'], $errores);
        $errores = $validacionClaveRepetida['errores'];
    } else if (isset($_POST['clave']) && $_POST['clave'] != '' && $validacionClave['estado']) {
        array_push($errores['claveRepetida'], 'Confirme su contraseña');
    }



    //Insertear usuario
    if (
        isset($validacionNombre) && $validacionNombre['estado']
        && isset($validacionClave) && $validacionClave['estado']
        && isset($validacionClaveRepetida) && $validacionClaveRepetida['estado']
    ) {
        $validacionGeneral = true;
        if (!user_already_exist($validacionNombre['nombre'])) {
            $_SESSION['usuario'] = add_new_user($validacionNombre['nombre'], $validacionClave['clave']);
            $_SESSION['mensaje'] = 'Registrado correctamente';
            header("location: index.php");
        } else {
            array_push($errores['usuario'], 'El nombre de usuario ya está en uso');
        }
    }
}

/*********************************************************************************************************************
 * Salida HTML
 * 
 * Tareas a realizar en la vista:
 * - TODO: los errores que se produzcan tienen que aparecer debajo de los campos.
 * - TODO: cuando hay errores en el formulario se debe mantener el valor del nombre de usuario en el campo
 *         correspondiente.
 */
?>
<h1>Galería de imágenes</h1>
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="filter.php">Filtrar imágenes</a></li>
    <li><a href="login.php">Iniciar sesión</a></li>
    <li><strong>Regístrate</strong></li>
</ul>
<h1>Regístrate</h1>
<form action="signup.php" method="post">
    <p>
        <label for="nombre">Nombre de usuario</label>
        <input type="text" name="nombre" id="nombre" value="<?= $_POST && $_POST['nombre'] ? $_POST['nombre'] : '' ?>">
        <?php
        foreach ($errores['nombre'] as $key => $value) {
            echo $value;
        }
        foreach ($errores['usuario'] as $key => $value) {
            echo $value;
        }
        ?>
    </p>
    <p>
        <label for="clave">Contraseña</label>
        <input type="password" name="clave" id="clave">
        <?php
        foreach ($errores['clave'] as $key => $value) {
            echo $value;
        }
        ?>
    </p>
    <p>
        <label for="repite_clave">Repite la contraseña</label>
        <input type="password" name="repite_clave" id="repite_clave">
        <?php
        foreach ($errores['claveRepetida'] as $key => $value) {
            echo $value;
        }
        ?>
    </p>
    <p>
        <input type="submit" value="Regístrate">
    </p>
</form>