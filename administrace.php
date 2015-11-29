<?php
session_start();
  include "database.php";
  if ($_SESSION['Zarazeni'] != "Administrator")
  {
    echo "Nemate dostatecna opravneni.";
    exit;
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>Informační systém - Učebny</title>
    
    <meta charset="UTF-8">
  </head>
    
  <body>  
    <h1>Administrace</h1>
    <?php
      include "menu.php";
      echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
      showMenu($_SESSION['Zarazeni']);
      administraceMenu();
      ?>
      

    <?php
      echo "</br>";
      print_r($_SESSION);
    ?>
  </body>
</html>