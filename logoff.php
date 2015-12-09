<?php
session_save_path("tmp/");
  session_start();
  $_SESSION = array();
  session_destroy();
  header("Location: index.php");

?>