<?php

/**********************************************************************************************************************
 * Este programa, a través del formulario que tienes que hacer debajo, en el área de la vista, realiza el inicio de
 * sesión del usuario verificando que ese usuario con esa contraseña existe en la base de datos.
 * 
 * Para mantener iniciada la sesión dentrás que usar la $_SESSION de PHP.
 * 
 * En el formulario se deben indicar los errores ("Usuario y/o contraseña no válido") cuando corresponda.
 * 
 * Dicho formulario enviará los datos por POST.
 * 
 * Cuando el usuario se haya logeado correctamente y hayas iniciado la sesión, redirige al usuario a la
 * página principal.
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

//Array de errores
$errores = [
    'nombre' => [],
    'clave' => []
];

//Sanear nombre
function sanear_nombre($nombre)
{
    $nombre = htmlspecialchars($nombre);
    $nombre = trim($nombre, " ");
    $estado = true;
    return [
        'estado' => $estado,
        'nombre' => $nombre
    ];
}

//Ciframos la clave
function cifrar_clave($clave)
{
    $clave = md5($clave);
    $estado = true;
    return [
        'estado' => $estado,
        'clave' => $clave
    ];
}


//Validar nombre
if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
    $nombreSaneado = sanear_nombre($_POST['nombre']);
} else if (isset($_POST['nombre'])) {
    array_push($errores['nombre'], 'Falta el nombre de usuario');
}

//Validar clave
if (isset($_POST['clave']) && $_POST['clave'] != '') {
    $claveCifrada = cifrar_clave($_POST['clave']);
} else if (isset($_POST['clave'])) {
    array_push($errores['clave'], 'Falta la contraseña');
}

if (
    isset($nombreSaneado) && isset($claveCifrada)
    && $nombreSaneado['estado'] && $claveCifrada['estado']
) {
    //Comprobamos que el usuario existe y que se puede logear
    if (user_already_exist($nombreSaneado['nombre']) && user_can_login($nombreSaneado['nombre'], $claveCifrada['clave'])) {
        $_SESSION['usuario'] = $nombreSaneado['nombre'];
        $_SESSION['mensaje'] = 'Bienvenid@ '.$nombreSaneado['nombre'];
        header('location: index.php');
    } else {
        //Error
        $error = "Usuario y/o contraseña no válido";
    }
}

/*********************************************************************************************************************
 * Salida HTML
 * 
 * Tareas a realizar en la vista:
 * - TODO: añadir el menú.
 * - TODO: formulario con nombre de usuario y contraseña.
 */
?>
<h1>Galería de imágenes</h1>
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="filter.php">Filtrar imágenes</a></li>
    <li><strong>Iniciar sesión</strong></li>
    <li><a href="signup.php">Regístrate</a></li>
</ul>
<h1>Inicia sesión</h1>
<?php
if (isset($error)) {
    echo "<p>" . $error . "</p>";
}
?>
<form action="login.php" method="post">
    <p>
        <label for="nombre">Nombre de usuario</label>
        <input type="text" name="nombre" id="nombre" value="<?= $_POST && $_POST['nombre'] ? $_POST['nombre'] : '' ?>">
        <?php
        foreach ($errores['nombre'] as $key => $value) {
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
        <input type="submit" value="Iniciar Sesión">
    </p>
</form>