<?php
    include "./coolFunctions.php";
    session_start();
    isLoggedIn();
  if(isset($_POST['submit'])) {
    include "./database/db.php";
    $userFirstName = mysqli_real_escape_string($connection, $_POST['firstName']);
    $userLastName = mysqli_real_escape_string($connection, $_POST['lastName']);
    $userEmail = mysqli_real_escape_string($connection, $_POST['email']);
    $userAge = $_POST['age'];
    $userRole = mysqli_real_escape_string($connection, strtoupper($_POST['role']));
    $password = $_POST['password'];

    $hashedPassword = hashPassword($password);

    $query = "INSERT INTO users(id, firstName, lastName, email, password, salt, age, avatar, user_role, creation_date)";
    $query .= "VALUES(null, '$userFirstName', '$userLastName', '$userEmail', '$hashedPassword', '', $userAge, '', '$userRole', now())";
    $result = mysqli_query($connection, $query);
    if(!$result) {
      die("query failed".mysqli_error($connection));
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cms/styles/index.css">
    <?php include "./partials/links.php";?>
    <title>CMS USER CREATION</title>
  </head>
  <body>
    <div class="main">
      <h2>Formulario de creación</h2>
      <div class="form loginForm">
        <form action="" method="post">
          <div class="formGroup">
            <label>Email *
              <input onBlur="inputEmailValidation(this);" type="text" placeholder="e.g:nombre@mail.com" name="email">
              <span class="errorMsg validationEmailMsg" style="display: none;">Formato inválido de email</span>
            </label>
          </div>
          <div class="formGroup">
            <label>Nombre *
              <input type="text" placeholder="e.g:Juan" name="firstName">
            </label>
          </div>
          <div class="formGroup">
            <label>Apellido *
              <input type="text" placeholder="e.g:Perez" name="lastName">
            </label>
          </div>
          <div class="formGroup">
            <label>Edad *
              <input type="number" placeholder="e.g:30" name="age">
            </label>
          </div>
          <div class="formGroup">
            <label>Contraseña *
              <input onBlur="validatePass(this);" type="password" name="password">
              <span class="validationPassMsg" style="color: black; display:block">*La contraseña debe tener al menos 6 caracteres</span>
            </label>
          </div>
          <div class="formGroup">
            <label for="role">Rol
            <select name="role" id="">
              <option value="guest">Seleccione un rol</option>
              <option value="admin">Admin</option>
              <option value="guest">Guest</option>
            </select>
            </label>
          </div>
          <input class="submitBtn" type="submit" name="submit" value="Crear Usuario">
          <a href="index.php">Cancelar</a>
        </form>
      </div>
    </div>
    <?php include "./partials/scripts.php";?>
  </body>
</html>