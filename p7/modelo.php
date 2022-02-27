<?php

class modelo
{

    /**
     * Genera una conexión para usarse en el resto de métodos.
     *
     * @param $server
     * @param $schema
     * @param $user
     * @param $pass
     * @return mysqli|null
     */
    public function conexion($server, $schema, $user, $pass)
    {
        @$mysqli = new mysqli($server, $user, $pass, $schema);
        if ($mysqli->connect_errno) {
            return null;
        } else {
            $mysqli->set_charset("utf8");
            return $mysqli;
        }
    }

    /**
     * Recupera todos los autores.
     *
     * @param $mysqli
     * @return mixed|null
     */
    function consultarAutores($mysqli)
    {
        return $this->ejecutarConsulta($mysqli, "SELECT * FROM Autor");
    }

    /**
     * Recupera un autor y sus libros dado su id.
     *
     * @param $mysqli
     * @param $id
     * @return mixed|null
     */
    function consultarAutor($mysqli, $id)
    {
        $consulta = "select nombre, apellidos, nacionalidad, l.id as id, titulo, f_publicacion 
                     from autor a inner join libro l on a.id = l.id_autor where a.id = $id";
        $rs = $this->ejecutarConsulta($mysqli, $consulta);
        $info_autor = array();
        if ($rs != null) {
            $libros = array();
            $info_autor["datos"] = array(
                "nombre" => $rs[0]["nombre"]
            , "apellidos" => $rs[0]["apellidos"]
            , "nacionalidad" => $rs[0]["nacionalidad"]
            );
            foreach ($rs as $r) {
                array_push($libros
                    , array("id" => $r["id"], "titulo" => $r["titulo"], "f_publicacion" => $r["f_publicacion"])
                );
            }
            $info_autor["libros"] = $libros;
        }
        return $info_autor;
    }

    /**
     * Recupera un autor y sus libros por nombre.
     *
     * @param $mysqli
     * @param $nombre
     * @return mixed|null
     */
    function consultarAutorPorNombre($mysqli, $nombre)
    {
        $nombre = strtolower($nombre);
        $nombre = str_replace('*', '%', $nombre);
        $consulta = "select nombre, apellidos, a.id as id, titulo, f_publicacion 
                     from Autor a 
                     inner join Libro l on a.id = l.id_autor 
                     where concat(lower(nombre), ' ', lower(apellidos)) like '%$nombre%'";
        $rs = $this->ejecutarConsulta($mysqli, $consulta);
        $autores = array();
        if ($rs != null) {
            $id = -1;
            $a = null;
            foreach ($rs as $r) {
                if ($r["id"] != $id) {
                    $id = $r["id"];
                    $a = new stdClass();
                    $a->id = $id;
                    $a->nombre = $r["nombre"];
                    $a->apellidos = $r["apellidos"];
                    $a->libros = array();
                    array_push($autores, $a);
                }
                $l = new stdClass();
                $l->titulo = $r["titulo"];
                $l->fecha_publicacion = $r["f_publicacion"];
                array_push($a->libros, $l);
            }   
        }
        return $autores;
    }

    /**
     * Recupera un libro dado su id.
     *
     * @param $mysqli
     * @param $libro
     * @return mixed|null
     */
    function consultarDatosLibro($mysqli, $libro)
    {
        $consulta = "select titulo, f_publicacion, nombre, apellidos 
                     from libro l 
                     inner join autor a on l.id_autor =  a.id 
                     where l.id = $libro";
        $resultado = $this->ejecutarConsulta($mysqli, $consulta);
        return is_null($resultado) ? $resultado : $resultado[0];
    }

    /**
     * Recupera todos los libros almacenados en el sistema.
     *
     * @param $mysqli
     * @return mixed|null
     */
    function obtenerLibros($mysqli)
    {
        return $this->ejecutarConsulta($mysqli, "select * from libro");
    }

    /**
     * Recupera los libros buscando con un 'like'. Usar '*' para indicar cualquier caracter.
     *
     * @param $mysqli
     * @param $titulo
     * @return mixed|null
     */
    function buscarPorTitulo($mysqli, $titulo)
    {
        $titulo = strtolower($titulo);
        $titulo = str_replace('*', '%', $titulo);
        $con = "select * from Libro where lower(titulo) like '%$titulo%'";
        return $this->ejecutarConsulta($mysqli, $con);
    }

    private function ejecutarConsulta($mysqli, $sql)
    {
        $resultset = $mysqli->query($sql);
        if ($resultset->num_rows > 0 && !$mysqli->error) {
            return $resultset->fetch_all(MYSQLI_ASSOC);
        } else {
            return null;
        }
    }
}