<?php

/**********************************************************************************************************************
 * Este es el script que añade imágenes en la base de datos. En la tabla "imagen" de la base de datos hay que guardar
 * el nombre que viene vía POST, la ruta de la imagen como se indica más abajo, la fecha de la inserción (función
 * UNIX_TIMESTAMP()) y el identificador del usuario que inserta la imagen (el usuario que está logeado en estos
 * momentos).
 * 
 * ¿Cuál es la ruta de la imagen? ¿De dónde sacamos esta ruta? Te lo explico a continuación:
 * - Busca una forma de asignar un nombre que sea único.
 * - La extensión será la de la imagen original, que viene en $_FILES['imagne']['name'].
 * - Las imágenes se subirán a la carpeta llamada "imagenes/" que ves en el proyecto.
 * - En la base de datos guardaremos la ruta relativa en el campo "ruta" de la tabla "imagen".
 * 
 * Así, si llega por POST una imagen PNG y le asignamos el nombre "imagen1", entonces en el campo "ruta" de la tabla
 * "imagen" de la base de datos se guardará el valor "imagenes/imagen1.png".
 * 
 * Como siempre:
 * 
 * - Si no hay POST, entonces tan solo se muestra el formulario.
 * - Si hay POST con errores se muestra el formulario con los errores y manteniendo el nombre en el campo nombre.
 * - Si hay POST y todo es correcto entonces se guarda la imagen en la base de datos para el usuario logeado.
 * 
 * Esta son las validaciones que hay que hacer sobre los datos POST y FILES que llega por el formulario:
 * - En el nombre debe tener algo (mb_strlen > 0).
 * - La imagen tiene que ser o PNG o JPEG (JPG). Usa FileInfo para verificarlo.
 * 
 * NO VAMOS A CONTROLAR SI YA EXISTE UNA IMAGEN CON ESE NOMBRE. SI EXISTE, SE SOBREESCRIBIRÁ Y YA ESTÁ.
 * 
 * A ESTE SCRIPT SOLO SE PUEDE ACCEDER SI HAY UN USARIO LOGEADO.
 */

/**********************************************************************************************************************
 * Lógica del programa
 * 
 * Tareas a realizar:
 * - TODO: tienes que desarrollar toda la lógica de este script.
 */
require("./bd.php");

session_start();

//Si hay sesion de usuario volvemos al index, aunque si esta logeado no deberia tener el boton de register
if (!isset($_SESSION['usuario'])) {
    header('location: index.php');
}
$usuario = $_SESSION && isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : null;

$errores = [
    'nombre' => [],
    'archivo' => [],
    'estado' => []
];

function moverFichero($nombre, $fichero)
{
    $fichero["name"] = $nombre . "." . pathinfo($fichero["name"])["extension"];
    $rutaFicheroDestino = 'imagenes/' . basename($fichero["name"]);
    move_uploaded_file($fichero["tmp_name"], $rutaFicheroDestino);
}

function validarFichero($fichero, $errores)
{
    $estado = true;
    $permitido = array('image/png', 'image/jpeg');
    //Validar fichero
    if ($fichero['size'] <= 0) {
        array_push($errores['archivo'], "Error al subir el archivo");
        $estado = false;
    } else if (!isset($fichero) || $fichero['error'] !== UPLOAD_ERR_OK) {
        array_push($errores['archivo'], "Error al subir el archivo");
        $estado = false;
    } else if (!in_array(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $fichero["tmp_name"]), $permitido)) {
        array_push($errores['archivo'], "Formato de imágen no valido");
        $estado = false;
    }

    return [
        'estado' => $estado,
        'errores' => $errores
    ];
}

function validarNombreFichero($nombre, $errores)
{
    $nombre = htmlspecialchars($nombre);
    $nombre = trim($nombre, " ");
    $estado = true;
    if (strlen($nombre) > 200) {
        array_push($errores['archivo'], 'El nombre no puede superar los 200 caracteres');
        $estado = false;
    }
    return [
        'estado' => $estado,
        'nombre' => $nombre,
        'errores' => $errores
    ];
}

if ($_POST && $_FILES) {
    if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
        $validacionNombre = validarNombreFichero($_POST['nombre'], $errores);
        $errores = $validacionNombre['errores'];
    } else {
        array_push($errores['nombre'], 'Se necesita nombre de imágen');
    }

    if (isset($_FILES['imagen'])) {
        $validacionFichero = validarFichero($_FILES['imagen'], $errores);
        $errores = $validacionFichero['errores'];
    } else {
        array_push($errores['archivo'], 'Se necesita imágen');
    }

    if (
        isset($validacionNombre) && isset($validacionFichero)
        && $validacionNombre['estado'] == true
        && $validacionFichero['estado'] == true
    ) {
        $idUsuario = get_user_id_by_name($usuario);
        moverFichero($validacionNombre['nombre'], $_FILES['imagen']);
        subir_imagen($validacionNombre['nombre'], $_FILES['imagen'], $idUsuario);
        array_push($errores['estado'], 'Imágen subida correctamente');
    }
}

/*********************************************************************************************************************
 * Salida HTML
 * 
 * Tareas a realizar:
 * - TODO: añadir el menú de navegación.
 * - TODO: añadir en el campo del nombre el valor del mismo cuando haya errores en el envío para mantener el nombre
 *         que el usuario introdujo.
 * - TODO: añadir los errores que se produzcan cuando se envíe el formulario debajo de los campos.
 */
?>
<h1>Galería de imágenes</h1>

<ul>
    <li><a href="index.php">Home</a></li>
    <li><strong>Añadir imagen</strong></li>
    <li><a href="filter.php">Filtrar imágenes</a></li>
    <li><a href="logout.php">Cerrar sesión (<?= $usuario ?>)</a></li>
</ul>

<h1>Añadir imágen</h1>
<form method="post" enctype="multipart/form-data">
    <p>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre">
        <?php
        foreach ($errores['nombre'] as $key => $value) {
            echo $value;
        }
        ?>
    </p>

    <p>
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" id="imagen">
        <?php
        foreach ($errores['archivo'] as $key => $value) {
            echo $value;
        }
        ?>
    </p>
    <p>
        <input type="submit" value="Añadir">
    </p>
    <?php
        foreach ($errores['estado'] as $key => $value) {
            echo $value;
        }
        ?>
</form>