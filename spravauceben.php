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
    header('Location: ucebna_pridat.php');
  }
  elseif (isset($_POST['upravit_button']))
  {
    if (!isset($_POST['vyber']))
    {
      echo "Nebyla vybrána žádná učebna pro úpravu.";
    }
    else
    {
      $_SESSION['value'] = $_POST['vyber'];
      if ($_SESSION['value'] != "")
      {
          header('Location: ucebna_upravit.php');
        }
        else
        {
          echo "Nebyla vybrána žádná učebna.";
        }
      }
  }
  elseif (isset($_POST['odebrat_button']))
  {
    if (!isset($_POST['vyber']))
    {
      echo "Nebyla vybrána žádná učebna pro smazání.";
    }
    else
      {
        if(smazUcebnu($_POST['vyber']))
          {
            echo "Učebna odebrána.<br>";
          }
        else
        {
            echo "Učebnu se nepodařilo odebrat!<br>";
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
      // mazání vybavení učebny
      $pomoc = "DELETE FROM prislusenstvi WHERE Mistnost = '".$zkratka."' ";
      if(!mysql_query($pomoc))
      {
        echo mysql_error();
        return false;
      }
      $requestt = "DELETE FROM ucebna WHERE Oznaceni = '".$zkratka."' ";
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
      echo '<center><table width=50%>
      <td><center><a href="spravauceben.php">Správa učeben</a></center></td>
      <td><center><a href="spravaprislusenstvi.php">Správa příslušenství</a></center></td>
      </table></center>';
      ?>
      <!-- Zobrazeni tabulky s uzivateli -->
      <?php
    
        connectDB();
        $result = mysql_query("select * from ucebna");
            
            if(mysql_num_rows($result) == 0)
            {
              echo "<center><h3>Neexistuje žádná učebna!</h3></center>";
              return false;
            }
            echo "<center><h2>Seznam učeben</h2>";
            echo "<table border=\"1\"><form method=\"post\"";
            echo "<tr><td> </td><td>Oznaceni</td><td>Budova</td><td>Číslo místnosti</td><td>Kapacita</td><td>Vybavení</td></tr>";
            while($record = MySQL_Fetch_Array($result))
            {
              
                $a = $record['Oznaceni'];
                $b = $record['Budova'];
                $c = $record['Cislo_mistnosti'];   
                $d = $record['Kapacita'];
                echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$a\"></td><td>$a</td><td>$b</td><td>$c</td><td>$d</td><td>";//</td></tr>";
                $res = mysql_query("select * from prislusenstvi where Mistnost ='".$a."' ");
                $res2 = $res;
                //echo "Hodnota res: " . $res . "</br>";
		        $i = 0;
		        $prislusenstvi = array();
		        while($rec = MySQL_Fetch_Array($res))
		        {

		        	$e = $rec['Nazev'];
		        	//$i++;
		        	//array_push($prislusenstvi, $e);
		        	$prislusenstvi[] = $e;
		        	$velikost = sizeof($prislusenstvi);
		        	$pom = 0;
		        	for($z = 0; $z < $velikost; $z++)
		        	{
		        		//echo "Prvek " . $prislusenstvi [$z];
		        		if (strcmp($e, $prislusenstvi [$z]) == 0)
		        		{
		        			$pom++;
		        		}
		        	}
		        	if ($pom > 1)
		        	{
		        		continue;
		        	}
		        	if ($i != 0)
		        	{
		        		echo ", ";
		        	}
		        	$i++;
		        	//array_push($prislusenstvi, $e);

		        	$pozadavek = mysql_query("select COUNT(*) from prislusenstvi where Mistnost ='".$a."' AND Nazev ='".$e."' ");
		        	$p = 0;

		        	while($pocet = MySQL_Fetch_Array($pozadavek))
		        	{
		        		$p = $pocet['COUNT(*)'];
		        		//print_r($pocet);
		        	}
		        	echo $p . "x ";
		        	echo "$e";
		        }
		        $j = 0;
		        echo "</td></tr>";
     
                //echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$a\"></td><td>$a</td><td>$b</td><td>$c</td><td>$d</td><td></td></tr>";

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