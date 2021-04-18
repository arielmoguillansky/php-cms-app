<?php
  $connection = mysqli_connect('localhost', 'root', '', 'cmsTest');
  if(!$connection) {
    die("DB connection failed");
  }
?>