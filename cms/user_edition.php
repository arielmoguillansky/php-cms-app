<?php
    include "./database/db.php";
    include "./coolFunctions.php";
    session_start();
    isLoggedIn();
    if(isset($_GET['edit_user_id'])) {
      $roles = mysqli_query($connection, getAllRoles());
      
      $userId = $_GET['edit_user_id'];
      if($userId) {
        $user = mysqli_query($connection, getUserById($userId));
        while($row = mysqli_fetch_assoc($user)) {
          $userFirstName = $row['firstname'];
          $userLastName = $row['lastname'];
          $userEmail = $row['email'];
          $userAge = $row['age'];
          $userAvatar = $row['avatar'];
          $userRole = $row['user_role'];
        }
        if(!$user) {
          die("query failed".mysqli_error($connection));
        }
      }
    }
  if(isset($_POST['submit'])) {
    $userFirstName = mysqli_real_escape_string($connection, $_POST['firstName']);
    $userLastName = mysqli_real_escape_string($connection, $_POST['lastName']);
    $userEmail = mysqli_real_escape_string($connection, $_POST['email']);
    $userAge = $_POST['age'];
    $userRole = mysqli_real_escape_string($connection, $_POST['role']);

    $query = "UPDATE users set 
      firstName = '{$userFirstName}', 
      lastName = '{$userLastName}', 
      email = '{$userEmail}', 
      age = '{$userAge}', 
      user_role = '{$userRole}'
      WHERE id = $userId
    ";
    $result = mysqli_query($connection, $query);
    if(!$result) {
      die("query failed".mysqli_error($connection));
    }
    $successMsg = "Se han actualizado los datos";
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
  <title>CMS USER EDITION</title>
</head>
<body>
  <div class="main">
    <h2>Formulario de edición</h2>
    <div class="form loginForm">
      <form action="" method="post">
        <div class="formGroup">
          <label>Email *
            <input onBlur="inputEmailValidation(this);" type="text" placeholder="e.g:nombre@mail.com" name="email" value="<?php echo $userEmail;?>">
            <span class="errorMsg validationEmailMsg" style="display: none;">Formato inválido de email</span>
          </label>
        </div>
        <div class="formGroup">
          <label>Nombre *
            <input type="text" placeholder="e.g:Juan" name="firstName" value="<?php echo $userFirstName;?>">
          </label>
        </div>
        <div class="formGroup">
          <label>Apellido *
            <input type="text" placeholder="e.g:Perez" name="lastName"  value="<?php echo $userLastName;?>">
          </label>
        </div>
        <div class="formGroup">
          <label>Edad *
            <input type="number" placeholder="e.g:30" name="age" value="<?php echo $userAge;?>">
          </label>
        </div>
        <div class="formGroup">
          <label for="role">Rol</label>
          <select name="role" id="">
            <?php  
              while($row = mysqli_fetch_assoc($roles)) {
                $roleId = $row['id'];
                $roleName = $row['role'];
            ?>
              <option value=<?php echo $roleName;?> <?php if($roleName === $userRole):?> selected <?php endif; ?>><?php echo $roleName; ?></option>";
            <?php }?>
          </select>
        </div>
        <input class="submitBtn" type="submit" name="submit" value="Grabar">
        <span class="successMsg"><?php echo $successMsg;?></span>
        <a href="index.php">Listado de usarios</a>
      </form>
    </div>
  </div>
</body>
</html>