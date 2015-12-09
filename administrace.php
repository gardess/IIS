<?php
session_save_path("tmp/");
session_start();
header('Content-type: text/html; charset=utf-8');
  include "database.php";
  if ($_SESSION['Zarazeni'] != "Administrator")
  {
    echo "Nemate dostatecna opravneni.";
    exit;
  }

  if (time() - $_SESSION['cas'] > 900)
  {
    unset($_SESSION['Jmeno'], $_SESSION['Prijmeni'], $_SESSION['Rodne_cislo'], $_SESSION['login_user']);
    $_SESSION['Zarazeni'] = "null";
    header('Location: prihlaseni2.php');
  }
  else
  {
    $_SESSION['cas'] = time();
  }
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>Informační systém - Učebny</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="styl.css" />
  </head>
    
  <body>  
    <div id="wrapper">
        <div id="header">
        <h1>&nbsp;Učebny</h1>
      </div>
      <?php
        if ((($_SESSION['Zarazeni']) == "Administrator") || (($_SESSION['Zarazeni']) == "Akademicky pracovnik"))
        echo "<div id=\"prihlasen\">Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni']."&nbsp;</div>";

        connectDB();
        include "menu.php";
      showMenu();
      administraceMenu();
      ?>
    <div id="telo"> 
    <h2 class="nadpis">Administrace</h2>
    <center>Vyberte si jakou kategorii chcete spravovat.</center>
    <br>
      

    </div>
      <div id="footer">
      Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
    </div>
    </div>
  </body>
</html>