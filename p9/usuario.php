<!DOCTYPE html>
<html lang="es">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
  <title>Usuario aleatorio</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="./autores.php">B&uacute;squeda de autores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="#">Usuario aleatorio</a>
      </li>
    </ul>
  </div>
</nav>
<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://randomuser.me/api/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$res = curl_exec($ch);

curl_close($ch);

$user = json_decode($res)->results[0];
?>
<div class="container mt-3">
  <div class="card" style="width:400px">
    <img class="card-img-top" src="<?php echo $user->picture->large; ?>" alt="Card image">
    <div class="card-body">
      <h4 class="card-title"><?php echo $user->name->first . " " . $user->name->last; ?></h4>
      <p class="card-text">Email: <?php echo $user->email; ?> </p>
      <p class="card-text">Vive
        en <?php echo $user->location->city . " (" . $user->location->country . ")"; ?></p>
      <a href="./usuario.php" class="btn btn-primary">Ver otro perfil</a>
    </div>
  </div>
</div>
</body>
</html>

