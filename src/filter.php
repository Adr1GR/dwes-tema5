<?php

/*********************************************************************************************************************
 * Este script muestra un formulario a través del cual se pueden buscar imágenes por el nombre y mostrarlas. Utiliza
 * el operador LIKE de SQL para buscar en el nombre de la imagen lo que llegue por $_GET['nombre'].
 * 
 * Evidentemente, tienes que controlar si viene o no por GET el valor a buscar. Si no viene nada, muestra el formulario
 * de búsqueda. Si viene en el GET el valor a buscar (en $_GET['nombre']) entonces hay que preparar y ejecutar una 
 * sentencia SQL.
 * 
 * El valor a buscar se tiene que mantener en el formulario.
 */

/**********************************************************************************************************************
 * Lógica del programa
 * 
 * Tareas a realizar:
 * - TODO: tienes que realizar toda la lógica de este script
 */
require("./bd.php");

session_start();
$usuario = $_SESSION && isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : null;

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

$valido = false;
$errores = [
    'nombre' => []
];

if ($_GET) {
    if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
        $nombreSaneado = sanear_nombre($_GET['nombre']);
        $resultado = filter_images_by_name($nombreSaneado['nombre']);
        $valido = true;
    } else {
        header('location: index.php');
    }
}

?>

<?php
/*********************************************************************************************************************
 * Salida HTML
 * 
 * Tareas a realizar:
 * - TODO: completa el código de la vista añadiendo el menú de navegación.
 * - TODO: en el formulario falta añadir el nombre que se puso cuando se envió el formulario.
 * - TODO: debajo del formulario tienen que aparecer las imágenes que se han encontrado en la base de datos.
 */

echo "<h1>Galería de imágenes</h1>";
if ($usuario == null) {
    echo <<<END
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><strong>Filtrar imágenes</strong></li>
            <li><a href="login.php">Iniciar sesión</a></li>
            <li><a href="signup.php">Regístrate</a></li>
        </ul>
    END;
} else {
    echo <<<END
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add.php">Añadir imagen</a></li>
            <li><strong>Filtrar imágenes</strong></li>
            <li><a href="logout.php">Cerrar sesión ($usuario)</a></li>
        </ul>
    END;
}
?>

<h2>Busca imágenes por filtro</h2>

<form method="get">
    <p>
        <label for="nombre">Busca por nombre</label>
        <input type="text" name="nombre" id="nombre">
    </p>
    <p>
        <input type="submit" value="Buscar">
    </p>
</form>

<?php
if ($valido && $resultado->num_rows == 0) {
    echo "<h2>No hay imágenes.</h2>";
} else if ($valido){
    echo "<h2>Imágenes totales: $resultado->num_rows</h2>";
    while (($fila = $resultado->fetch_assoc()) != null) {
        echo <<<END
            <figure>
                <div>{$fila['nombre']} (subida por {$fila['nombreUser']})</div>
                <img src="{$fila['ruta']}" width="200px">
                <a href="delete.php?id={$fila['id']}">Borrar</a>
            </figure>
        END;
    }
}
?>