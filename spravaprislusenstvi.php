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
    <h2 class="nadpis">Správa příslušenství</h2>
      <!-- Zobrazeni tabulky s uzivateli -->
      <?php
    
        connectDB();
        $result = mysql_query("select * from prislusenstvi");
            
            if(mysql_num_rows($result) == 0)
            {
              echo "<center><h3>Neexistuje žádná učebna!</h3></center>";
              echo "
                    </div>
                    <div id=\"footer\">
                      Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
                </div>";
              return false;
            }
            echo "<center>";
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
                echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$a\"></td><td>$a</td><td>$b</td><td>$c</td><td>$d Kč</td><td>$e</td><td>$f</td></tr>";
            }
            
            echo "</table><br>
              <input type=\"submit\" name=\"pridat_button\" value=\"Přidat příslušenství\">
              <input type=\"submit\" name=\"upravit_button\" value=\"Upravit příslušenství\">
              <input type=\"submit\" name=\"odebrat_button\" value=\"Odebrat příslušenství\">
              </form></center>";
    ?>  
      <!-- -->
      <br>
    </div>
      <div id="footer">
      Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
    </div>
    </div>
  </body>
</html>