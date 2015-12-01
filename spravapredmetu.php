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
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="styl.css" />
  </head>
    
  <body>  
  <div id="wrapper">
        <div id="header">
    		<h1>&nbsp;Učebny</h1>
    	</div>
    <?php
    
    	echo "<div id=\"prihlasen\">Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni']."&nbsp;</div>";
		include "menu.php";
		showMenu();
		administraceMenu();
    ?>
    <!-- -->
    <div id="telo">	
		<h2 class="nadpis">Seznam předmětů</h2>
      <!-- Zobrazeni tabulky s uzivateli -->
      <?php
    
        connectDB();

        $result = mysql_query("select * from predmet");
            
            if(mysql_num_rows($result) == 0) // nemůže nikdy nastat
            {
              echo "<center><h3>Neexistuje žádný předmět!</h3></center>";
              echo "
				    		</div>
		   					<div id=\"footer\">
		   						Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
						</div>";
              return false;
            }
            echo "<center>";
            echo "<table border=\"1\"><form method=\"post\"";
            echo "<tr><td> </td><td>Zkratka</td><td>Název</td><td>Garant</td><td>Ročník</td><td>Obor</td><td>Hodinová dotace</td><td>Počet kreditů</td></tr>";
            while($record = MySQL_Fetch_Array($result))
            {
              
                $a = $record['Zkratka'];
                $b = $record['Nazev'];
                $c = $record['Garant'];
                $res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$c."' ");
		        	while($rec = MySQL_Fetch_Array($res))
		        	{
		        		$ca = $rec['Jmeno'];
		        		$cb = $rec['Prijmeni'];
		        	}   
                $d = $record['Hodinova_dotace'];
                $e = $record['Kredity'];
                //$f = $record['Obor'];
                $g = $record['Rocnik'];     
                if ($g [1] == 'B')
                {
                	$go = "Bakalář";
                }
                else
                {
                	$go = "Magistr";
                }
                echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$a\"></td><td>$a</td><td>$b</td><td>$ca $cb</td><td>$g</td><td>$go</td><td>$d</td><td>$e</td></tr>";

            }
            
            echo "</table></center><br>";
            echo "<center>
              <input type=\"submit\" name=\"pridat_button\" value=\"Přidat předmět\">
              <input type=\"submit\" name=\"upravit_button\" value=\"Upravit předmět\">
              <input type=\"submit\" name=\"odebrat_button\" value=\"Odebrat předmět\">
              </center></form><br>";
				    
		?>	
    <!-- -->
    </div>
   		<div id="footer">
   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
		</div>
   	</div>
  </body>
</html>