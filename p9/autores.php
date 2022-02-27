<!DOCTYPE html>
<html lang="es">
<head>
  <title>B&uacute;squeda por autores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
  <script>
    window.onload = function () {

      document.getElementById("formu").reset();

      const httpRequest = new XMLHttpRequest();

      texto.onkeyup = function () {
        if (texto.value.length > 0) {
          httpRequest.open(
              "GET",
              "http://<?php echo $_SERVER['SERVER_NAME'];?>/p7/api.php?action=get_datos_autor&nombre="
              + texto.value
          );
          httpRequest.send();
        } else {
          resultado.innerHTML = "<h3>Buscar por autor:</h3>";
        }

      };

      httpRequest.onload = function () {
        console.log(httpRequest.responseText);
        const resp = JSON.parse(httpRequest.responseText);
        if (resp.data.length > 0) {
          let res = "<table class='table'>";
          res += "<tr><th>AUTOR</th><th>LIBROS</th></tr>";
          res += resp.data.map(crearFila).reduce((s1, s2) => s1 + s2);
          res += "</table>";
          resultado.innerHTML = res;
        } else {
          resultado.innerHTML = "<h3>Vaya, parece que no hay nada...</h3>";
        }
      }
    }

    function crearFila(autor) {
      let res = "<tr>";
      res += crearCelda(autor.nombre + " " + autor.apellidos);
      res += crearCelda(formatearLibros(autor.libros));
      return res + "</tr>";
    }

    function formatearLibros(libros) {
      let res = "<ul class='list-group-flush'>";
      res += libros.map(l => l.titulo + " (" + l.fecha_publicacion + ")")
      .map(s => "<li class='list-group-item'>" + s + "</li>")
      .reduce((s1, s2) => s1 + s2);
      return res + "</ul>";
    }

    function crearCelda(valor) {
      return "<td>" + valor + "</td>";
    }
  </script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="#">B&uacute;squeda de autores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./usuario.php">Usuario aleatorio</a>
      </li>
    </ul>
  </div>
</nav>
<form id="formu">
  <div class="container mt-3">
    <label class="form-label">Autor: <input type="text" id="texto" name="texto"></label>
  </div>
</form>
<div id="resultado" class="container mt-3">
  <h3>Introduce un autor para buscar</h3>
</div>
</body>
</html>
