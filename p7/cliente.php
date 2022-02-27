<body>

<?php
require_once "const.php";
// Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor") {
    //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
    $app_info = file_get_contents(API_SERVER . "/p7/api.php?action=get_datos_autor&id=" . $_GET["id"]);
    // Se decodifica el fichero JSON y se convierte a array
    $app_info = json_decode($app_info, true);
    ?>
    <p>
    <td>Nombre:</td>
    <td> <?php echo $app_info["datos"]["nombre"] ?></td>
    <p>
    <td>Apellidos:</td>
    <td> <?php echo $app_info["datos"]["apellidos"] ?></td>
    <p>
    <td>Fecha de nacimiento:</td>
    <td> <?php echo $app_info["datos"]["nacionalidad"] ?></td>
    <ul>
        <!-- Mostramos los libros del autor -->
        <?php foreach ($app_info["libros"] as $libro): ?>
            <li>
                <a href="<?php echo API_SERVER . "/p7/cliente.php?action=get_datos_libro&id=" . $libro["id"]; ?>">
                    <?php echo $libro["titulo"]; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <br/>
    <!-- Enlace para volver a la lista de autores -->
    <a href="<?php echo API_SERVER; ?>/p7/cliente.php?action=get_lista_autores">
        Volver a la lista de autores
    </a>
    <?php

} elseif (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_libro") {
    $app_info = file_get_contents(API_SERVER . "/p7/api.php?action=get_datos_libro&id=" . $_GET["id"]);
    // Se decodifica el fichero JSON y se convierte a array
    $app_info = json_decode($app_info, true);
    ?>
    <table style="border: #000000 solid; width: 100%;">
        <tr>
            <th style="border: #000000 solid">Autor</th>
            <th style="border: #000000 solid">Título</th>
            <th style="border: #000000 solid">Fecha de publicación</th>
        </tr>
        <tr>
            <td style="border: #000000 solid"><?php echo $app_info["nombre"] . " " . $app_info["apellidos"]; ?></td>
            <td style="border: #000000 solid"><?php echo $app_info["titulo"]; ?></td>
            <td style="border: #000000 solid"><?php echo $app_info["f_publicacion"]; ?></td>
        </tr>
    </table>
    <br><br><br>
    <ul>
        <li>
            <a href="<?php echo API_SERVER; ?>/p7/cliente.php?action=get_lista_autores">
                Volver a la lista de autores
            </a>
        </li>
        <li>
            <a href="<?php echo API_SERVER . "/p7/cliente.php?action=get_datos_libro"; ?>">
                Volver a la lista de libros.
            </a>
        </li>
    </ul>
    <?php
} elseif (isset($_GET["action"]) && $_GET["action"] == "get_datos_libro") {
    $libros = file_get_contents(API_SERVER . "/p7/api.php?action=get_datos_libro");
    $libros = json_decode($libros, true);
    ?>
    <ul>
        <!-- Mostramos una entrada por cada autor -->
        <?php foreach ($libros as $l): ?>
            <li>
                <a href="<?php echo API_SERVER . "/p7/cliente.php?action=get_datos_libro&id=" . $l["id"]; ?>">
                    <?php echo $l["titulo"]; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
} else {
    // Pedimos al la api que nos devuelva una lista de autores. La respuesta se da en formato JSON
    $lista_autores = file_get_contents(API_SERVER . "/p7/api.php?action=get_lista_autores");
    // Convertimos el fichero JSON en array
    //var_dump($lista_autores);
    $lista_autores = json_decode($lista_autores, true);
    ?>
    <ul>
        <!-- Mostramos una entrada por cada autor -->
        <?php foreach ($lista_autores as $autores): ?>
            <li>
                <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
                <a href="<?php echo API_SERVER . "/p7/cliente.php?action=get_datos_autor&id=" . $autores["id"] ?>">
                    <?php echo $autores["nombre"] . " " . $autores["apellidos"] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
} ?>
</body>
