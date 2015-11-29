<?php
session_start();
  include "database.php";
  if ($_SESSION['Zarazeni'] != "Administrator")
  {
    echo "Nemate dostatecna opravneni.";
    exit;
  }

  if (isset($_POST['pridat_button']))
  {
    header('Location: predmet_pridat.php');
  }
  elseif (isset($_POST['upravit_button']))
  {
    if (!isset($_POST['vyber']))
    {
      echo "Nebyl vybrán žádný předmět pro úpravu.";
    }
    else
    {
      $_SESSION['value'] = $_POST['vyber'];
      if ($_SESSION['value'] != "")
      {
          header('Location: predmet_upravit.php');
        }
        else
        {
          echo "Nebyla vybrána žádná rezervace.";
        }
      }
  }
  elseif (isset($_POST['odebrat_button']))
  {
    if (!isset($_POST['vyber']))
    {
      echo "Nebyl vybrán žádný předmět pro smazání.";
    }
    else
      {
        if(smazUzivatele($_POST['vyber']))
          {
            echo "Předmět odebrán.<br>";
          }
        else
        {
              echo "Předmět se nepodařilo odebrat!<br>";
        }
      }
  }
  else
  {
      $_SESSION['value'] = "";
      
  }

  function smazUzivatele($zkratka)
    {
      connectDB();
      echo "Zkratka: " . $zkratka . "</br>";
      $requestt = "DELETE FROM predmet WHERE Zkratka = '".$zkratka."' ";
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
    <h1>Správa uživatelů</h1>
    <?php
      include "menu.php";
      echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
      showMenu($_SESSION['Zarazeni']);
      administraceMenu();
      ?>
      <!-- Zobrazeni tabulky s uzivateli -->
      <?php
    
        connectDB();
        $result = mysql_query("select * from predmet");
            
            if(mysql_num_rows($result) == 0) // nemůže nikdy nastat
            {
              echo "<center><h3>Neexistuje žádný předmět!</h3></center>";
              return false;
            }
            echo "<center><h2>Seznam předmětů</h2>";
            echo "<table border=\"1\"><form method=\"post\"";
            echo "<tr><td> </td><td>Zkratka</td><td>Název</td><td>Garant</td><td>Hodinová dotace</td><td>Počet kreditů</td></tr>";
            while($record = MySQL_Fetch_Array($result))
            {
              
                $a = $record['Zkratka'];
                $b = $record['Nazev'];
                $c = $record['Garant'];   
                $d = $record['Hodinova_dotace'];
                $e = $record['Kredity'];     
                echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$a\"></td><td>$a</td><td>$b</td><td>$c</td><td>$d</td><td>$e</td></tr>";

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