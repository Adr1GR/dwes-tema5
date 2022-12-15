<?php

/**********************************************************************************************************************
 * Este script simplemente elimina la imagen de la base de datos y de la carpeta <imagen>
 *
 * La información de la imagen a eliminar viene vía GET. Por GET se tiene que indicar el id de la imagen a eliminar
 * de la base de datos.
 * 
 * Busca en la documentación de PHP cómo borrar un fichero.
 * 
 * Si no existe ninguna imagen con el id indicado en el GET o no se ha inicado GET, este script redirigirá al usuario
 * a la página principal.
 * 
 * En otro caso seguirá la ejecución del script y mostrará la vista de debajo en la que se indica al usuario que
 * la imagen ha sido eliminada.
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
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '' || !$_GET || !isset($_GET['id'])) {
    $_SESSION['mensaje'] = 'Inicie sesión para poder borrar imágenes';
    header('location: index.php');
} else {
    $ruta = get_image_name_from_id($_GET['id']);
    unlink($ruta);
    delete_image_from_id($_GET['id']);
}



/*********************************************************************************************************************
 * Salida HTML
 */
?>
<h1>Galería de imágenes</h1>

<p>Imagen eliminada correctamente</p>
<p>Vuelve a la <a href="index.php">página de inicio</a></p>