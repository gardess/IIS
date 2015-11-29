<?php
session_start();
header('Content-type: text/html; charset=utf-8');
  include "database.php";
  if ($_SESSION['Zarazeni'] != "Administrator")
  {
    echo "Nemate dostatecna opravneni.";
    exit;
  }

  if (isset($_POST['pridat_button']))
  {
    header('Location: prislusenstvi_pridat.php');
  }
  elseif (isset($_POST['upravit_button']))
  {
    if (!isset($_POST['vyber']))
    {
      echo "Nebylo vybráno žádné příslušenství pro úpravu.";
    }
    else
    {
      $_SESSION['value'] = $_POST['vyber'];
      if ($_SESSION['value'] != "")
      {
          header('Location: prislusenstvi_upravit.php');
        }
        else
        {
          echo "Nebylo vybráno žádné příslušenství.";
        }
      }
  }
  elseif (isset($_POST['odebrat_button']))
  {
    if (!isset($_POST['vyber']))
    {
      echo "Nebylo vybráno žádné příslušenství pro smazání.";
    }
    else
      {
        if(smazUcebnu($_POST['vyber']))
          {
            echo "Příslušenství odebráno.<br>";
          }
        else
        {
            echo "Příslušenství se nepodařilo odebrat!<br>";
        }
      }
  }
  else
  {
      $_SESSION['value'] = "";
      
  }

  function smazUcebnu($zkratka)
    {
      connectDB();
      $requestt = "DELETE FROM prislusenstvi WHERE Inventarni_cislo = '".$zkratka."' ";
      if(!mysql_query($requestt))
      {
        echo mysql_error();
        return false;
      }
      else
      {
        echo "Smazání proběhlo úspěšně.";
        return true;
      }
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>Informační systém - Učebny</title>
    
    <meta charset="UTF-8">
  </head>
    
  <body>  
    <h1>Správa učeben</h1>
    <?php
      include "menu.php";
      echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
      showMenu($_SESSION['Zarazeni']);
      administraceMenu();
      ?>
      <!-- Zobrazeni tabulky s uzivateli -->
      <?php
    
        connectDB();
        $result = mysql_query("select * from prislusenstvi");
            
            if(mysql_num_rows($result) == 0)
            {
              echo "<center><h3>Neexistuje žádná učebna!</h3></center>";
              return false;
            }
            echo "<center><h2>Seznam příslušenství</h2>";
            echo "<table border=\"1\"><form method=\"post\"";
            echo "<tr><td> </td><td>Inventární číslo</td><td>Název</td><td>Místnost</td><td>Pořizovací cena</td><td>Datum pořízení</td><td>Určení</td></tr>";
            while($record = MySQL_Fetch_Array($result))
            {
              
                $a = $record['Inventarni_cislo'];
                $b = $record['Nazev'];
                $c = $record['Mistnost'];   
                $d = $record['Porizovaci_cena'];
                $e = $record['Datum_porizeni'];
                $f = $record['Urceni'];
                echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$a\"></td><td>$a</td><td>$b</td><td>$c</td><td>$d</td><td>$e</td><td>$f</td></tr>";
            }
            echo "<tr><td colspan=\"7\"><center>
              <input type=\"submit\" name=\"pridat_button\" value=\"Přidat\">
              <input type=\"submit\" name=\"upravit_button\" value=\"Upravit\">
              <input type=\"submit\" name=\"odebrat_button\" value=\"Odebrat\">
              </center></td></tr>";
            echo "</table></center>";
    ?>  
      <!-- -->
    <?php
      echo "</br>";
      print_r($_SESSION);
    ?>
  </body>
</html>