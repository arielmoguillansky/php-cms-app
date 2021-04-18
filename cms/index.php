<?php
  include "./database/db.php";
  include "./coolFunctions.php";
  session_start();
  isLoggedIn();
  if(isset($_GET['delete_user_id'])) {
    $userId = $_GET['delete_user_id'];
    $query = "DELETE FROM users WHERE id = $userId";
    $result = mysqli_query($connection, $query);
    if(!$result) {
      die("query failed".mysqli_error($connection));
    }
  }
  $query = "SELECT * FROM users";
  $result = mysqli_query($connection, $query);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cms/styles/index.css">
    <?php include "./partials/links.php";?>
    <title>CMS DASHBOARD</title>
  </head>
  <body>
    <header>
      <h3>¡Hola <?php echo $_SESSION['userFirstName'];?>!</h3>
      <a href="logout.php">Cerrar sesión</a>
    </header>
    <div class="main">
      <div class="usersTable">
        <h2 class="title">Lista de usuarios</h2>
        <table class="styled-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Edad</th>
              <th>Email</th>
              <th>Rol</th>
              <th>Fecha de creación</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php  
              while($row = mysqli_fetch_assoc($result)) {
                $userId = $row['id'];
                $userFirstName = $row['firstname'];
                $userLastName = $row['lastname'];
                $email = $row['email'];
                $role = $row['user_role'];
                $creationDate = $row['creation_date'];
                $userAge = $row['age'];
            ?>
                <tr onMouseOver="rowActive(this);" onMouseOut="rowInactive(this);">
                <td><?php echo $userId; ?></td>
                <td><?php echo $userFirstName; ?></td>
                <td><?php echo $userLastName; ?></td>
                <td><?php echo $userAge; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $role; ?></td>
                <td><?php echo $creationDate; ?></td>
                <td><a class="action"  href="user_edition.php?edit_user_id=<?php echo $userId;?>">editar</a></td>
                <td><span class="action" onClick='showModal(<?php echo $userId?>, "<?php echo $userFirstName?>");'>eliminar</span></td>
                </tr>
            <?php }?>
          </tbody>
        </table>
        <a class="addBtn" href="user_creation.php">+ Agregar usuario</a>
      </div>
      <div class="modal" style="display:none;">
        <div class="modalContent" >
          <span>¿Está seguro que desea eliminar a <strong></strong> de la lista?</span>
          <div>
            <button class="confirm" onClick="deleteUser();">Eliminar</button>  
            <button class="cancel">Cancelar</button>
          </div>
        </div>  
      </div>
    </div>
  </body>
  <?php include "./partials/scripts.php";?>
</html>