<?php 
  session_start();
  include "./database/db.php";
  include "coolFunctions.php";

  if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $hashedPassword = hashPassword($password);

    if($email && $password) {
      $query = "SELECT * from users WHERE email = '{$email}'";
      $user = mysqli_query($connection, $query);
      while($row = mysqli_fetch_array($user)) {
        $userId = $row['id'];
        $userEmail = $row['email'];
        $userPassword = $row['password'];
        $userFirstName = $row['firstname'];
      }
      if($userEmail === $email && password_verify($password,$userPassword)) {
        $_SESSION['userFirstName'] = $userFirstName;
        $_SESSION['userEmail'] = $userEmail;
        $_SESSION['userPassword'] = $userPassword;
        header('Location: index.php');
      } else {
        $errorMsg = 'Email o contraseña incorrectos';
      } 
    } else {
      $errorMsg = "Debe completar todos los campos";
    }
  }

  if(isset($_POST['singup'])) {
    $userEmail = mysqli_real_escape_string($connection, $_POST['email']);
    $userPassword = mysqli_real_escape_string($connection, $_POST['password']);
    $rePassword = mysqli_real_escape_string($connection, $_POST['rPassword']);
    $userFirstName = mysqli_real_escape_string($connection, $_POST['firstName']);
    $userLastName = mysqli_real_escape_string($connection, $_POST['lastName']);
    $userAge = mysqli_real_escape_string($connection, $_POST['age']);

    $mailQuery = "SELECT id from users WHERE email = '{$userEmail}'";
    $emaiResult = mysqli_query($connection, $mailQuery);
    $emailExists = mysqli_fetch_assoc($emaiResult);

    $isAdmin = $_POST['isAdmin'];
    if(isset($isAdmin)) {
      $role = "ADMIN";
    } else {
      $role ="GUEST";
    }

    $hashedPassword = hashPassword($userPassword);
    
    if($userEmail && $userPassword  && $userFirstName && $userLastName && $userAge && !isset($emailExists) && strlen($userPassword) >= 6 && $userPassword === $rePassword) {
      $query = "INSERT INTO users(id, firstName, lastName, email, password, salt, age, avatar, user_role, creation_date)";
      $query .= "VALUES(null, '$userFirstName', '$userLastName', '$userEmail', '$hashedPassword', '', $userAge, '', '$role', now())";
      $result = mysqli_query($connection, $query);
      if(!$result) {
        die("query failed".mysqli_error($connection));
      }
        $_SESSION['userFirstName'] = $userFirstName;
        $_SESSION['userEmail'] = $userEmail;
        $_SESSION['userPassword'] = $hashedPassword;
        header('Location: index.php');
    } else if(isset($emailExists)) {
      $errorMsg = "Ya existe un usuario con este email";
    } 
    else {
      $errorMsg = "Debe completar todos los campos";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./partials/links.php";?>
    <title>CMS</title>
  </head>
  <body>
    <div class="main">
      <h1>CMS</h1>
      <div class="form loginForm">
        <h2 class="title">Acceso</h2>
        <form action="" method="post">
          <div class="formGroup">
            <label>Email
              <input type="text" placeholder="e.g:nombre@mail.com" name="email">
            </label>
          </div>
          <div class="formGroup">
            <label>Contraseña
              <input type="password" name="password">
            </label>
          </div>
          <input class="submitBtn" type="submit" name="submit" value="Iniciar sesión">
          <span class="errorMsg"><?=$errorMsg?></span>
        </form>
        <span class="link registrationLink">¿Éres nuevo? <strong>Regístrate</strong></span>
      </div>
      <div class="form registrationForm" style="display: none;">
        <h2 class="title">Registro</h2>
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
            <label>Confirmar contraseña *
              <input type="password" name="rPassword">
              <span class="errorMsg confirmPassMsg" style="display: none;">Las contraseñas deben ser iguales</span>
            </label>
          </div>
          <div class="formGroup">
            <label>
              <input class="checkbox" type="checkbox" name="isAdmin" value="1"> 
              Soy administrador
            </label>
          </div>
          <input class="submitBtn" type="submit" name="singup" value="registrarme">
          <span class="errorMsg"><?=$errorMsg?></span>
        </form>
        <span class="link loginLink">¿Eres usuario? <strong>Inicia sesión</strong></span>
      </div>
    </div>
  </body>
  <?php include "./partials/scripts.php";?>
</html>