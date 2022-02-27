
<?php

require_once "const.php";
require_once "modelo.php";

/**
 * Devuelve todos los autores salvados en el sistema
 *
 * @return mixed|null
 */
function get_lista_autores()
{
    $modelo = new modelo();

    $conn = $modelo->conexion(SERVER, SCHEMA, USER, PASS);

    return $modelo->consultarAutores($conn);
}

/**
 * Devuelve la información y los libros escritos por un autor dado su id
 * @param $id
 * @return array|mixed|null
 */
function get_datos_autor($id)
{
    $modelo = new modelo();

    $conn = $modelo->conexion(SERVER, SCHEMA, USER, PASS);

    return $modelo->consultarAutor($conn, $id);
}

/**
 * Devuelve la información y los libros escritos por un autor dado un nombre
 * @param $id
 * @return array|mixed|null
 */
function buscar_por_nombre_autor($nombre)
{
    $modelo = new modelo();

    $conn = $modelo->conexion(SERVER, SCHEMA, USER, PASS);

    return $modelo->consultarAutorPorNombre($conn, $nombre);
}

/**
 * Recupera la informción de un libro dado su id
 * @param $id
 * @return mixed|null
 */
function get_datos_libro($id)
{
    $modelo = new modelo();

    $conn = $modelo->conexion(SERVER, SCHEMA, USER, PASS);

    return $modelo->consultarDatosLibro($conn, $id);
}

/**
 * Retorna todos los libros alamcenados en el sistema
 *
 * @return mixed|null
 */
function get_libros()
{
    $modelo = new modelo();
    $conn = $modelo->conexion(SERVER, SCHEMA, USER, PASS);
    return $modelo->obtenerLibros($conn);
}

/**
 * Recupera los libros buscando con título.
 *
 * @param $titulo
 * @return mixed|null
 */
function get_libros_por_titulo($titulo)
{
    $modelo = new modelo();
    $conn = $modelo->conexion(SERVER, SCHEMA, USER, PASS);
    return $modelo->buscarPorTitulo($conn, $titulo);
}

$posibles_URL = array("get_lista_autores", "get_datos_autor", "get_datos_libro");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL)) {
    switch ($_GET["action"]) {
        case "get_lista_autores":
            $valor = get_lista_autores();
            break;
        case "get_datos_autor":
            if (isset($_GET["id"])) {
                $valor = get_datos_autor($_GET["id"]);
            } else if (isset($_GET["nombre"])) {
                $valor = new stdClass();
                $valor->data = buscar_por_nombre_autor($_GET["nombre"]);
            } else {
                $valor = "Argumento no encontrado";
            }
            break;
        case "get_datos_libro":
            if (isset($_GET["id"])) {
                $valor = get_datos_libro($_GET["id"]);
            } else if (isset($_GET["titulo"])){
                $valor = get_libros_por_titulo($_GET["titulo"]);
            } else {
                $valor = get_libros();
            }
            break;
    }
}

//devolvemos los datos serializados en JSON
header("Content-Type: application/json");
// permitimos CORS
header('Access-Control-Allow-Origin: *');
exit(json_encode($valor));