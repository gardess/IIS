<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function upravRezervaci($zkratka, $nazev, $garant, $dotace, $kredity, $rocnik)
	{
		connectDB();

    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE predmet SET 
		Zkratka='$zkratka',
		Nazev='$nazev',
		Garant='$garant',
		Hodinova_dotace='$dotace',
		Kredity='$kredity',
    Rocnik='$rocnik'
		WHERE Zkratka ='".$_SESSION['value']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Úprava předmětu proběhla úspěšně.";
			header('Location: spravapredmetu.php');
			return true;
		}
	}

	function ziskejGaranta($garant)
  {
    connectDB();
      
    $result = mysql_query("select * from akademicky_pracovnik");
    $i = 0;
    while($record = MySQL_Fetch_Array($result))
    {
      $RC = $record['Rodne_cislo'];
      $Jmeno = $record['Jmeno'];
      $Prijmeni = $record['Prijmeni'];
      if ($garant == $RC)
      {
        echo "<option value='$RC' selected='selected'>";
      }
      else
      {
        echo "<option value='$RC'>";
      }
      echo $Jmeno." ". $Prijmeni;
      echo "</option><br>";
      $i++;
    }
  }

function optionSelect($rocnik)
{
  if ($rocnik == '1BIT')
  {
    echo "
    <option value='1BIT' selected='selected'>1BIT</option><br>
    <option value='2BIT'>2BIT</option><br>
    <option value='3BIT'>3BIT</option><br>
    <option value='1MIT'>1MIT</option><br>
    <option value='2MIT'>2MIT</option><br>";
  }
  if ($rocnik == '2BIT')
  {
    echo "
    <option value='1BIT'>1BIT</option><br>
    <option value='2BIT' selected='selected'>2BIT</option><br>
    <option value='3BIT'>3BIT</option><br>
    <option value='1MIT'>1MIT</option><br>
    <option value='2MIT'>2MIT</option><br>";
  }
  if ($rocnik == '3BIT')
  {
    echo "
    <option value='1BIT'>1BIT</option><br>
    <option value='2BIT'>2BIT</option><br>
    <option value='3BIT' selected='selected'>3BIT</option><br>
    <option value='1MIT'>1MIT</option><br>
    <option value='2MIT'>2MIT</option><br>";
  }
  if ($rocnik == '1MIT')
  {
    echo "
    <option value='1BIT'>1BIT</option><br>
    <option value='2BIT'>2BIT</option><br>
    <option value='3BIT'>3BIT</option><br>
    <option value='1MIT' selected='selected'>1MIT</option><br>
    <option value='2MIT'>2MIT</option><br>";
  }
  if ($rocnik == '2MIT')
  {
    echo "
    <option value='1BIT'>1BIT</option><br>
    <option value='2BIT'>2BIT</option><br>
    <option value='3BIT'>3BIT</option><br>
    <option value='1MIT'>1MIT</option><br>
    <option value='2MIT' selected='selected'>2MIT</option><br>";
  }
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
     "http://www.w3.org/TR/html4/strict.dtd">
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
    <h2 class="nadpis">Upravit předmět</h2>
    
  	<?php
  		connectDB();
  		$req = "SELECT * FROM predmet WHERE Zkratka ='".$_SESSION['value']."' ";
        $res = mysql_query($req);
        while($rec = MySQL_Fetch_Array($res))
    	{
    		$DB_Zkratka = $rec['Zkratka'];
    	   	$DB_Nazev = $rec['Nazev'];
    	   	$DB_Garant = $rec['Garant'];
    	   	$DB_Hodinova_dotace = $rec['Hodinova_dotace'];
    	   	$DB_Kredity = $rec['Kredity'];
          $DB_Rocnik = $rec['Rocnik'];    	   	
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      
        if(upravRezervaci($_POST['zkratka'], $_POST['nazev'], $_POST['garant'], $_POST['dotace'], $_POST['kredity'], $_POST['rocnik']))
          {;}//echo "Předmět přidán.<br>";
        else
          {;}//echo "Předmět se nepodařilo přidat!<br>";
        endif;
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td>Zkratka:</td>
	    <td><input type="text" name="zkratka" size="20" value="<?php echo $DB_Zkratka; ?>"></td>
    </tr>

    <tr>
    	<td>Název:</td>
	    <td><input type="text" name="nazev" size="20" value="<?php echo $DB_Nazev; ?>"></td>
    </tr>

    <tr>
      <td>Garant:</td>
      <td>
        <select name="garant" style="width: 173px">
          <?php 
            ziskejGaranta($DB_Garant);
          ?>
      </select>
      </td>
    </tr>

    <tr>
      <td>Ročník:</td>
      <td>
        <select name="rocnik" style="width: 173px">
            <option value='1BIT'>1BIT</option><br>
            <option value='2BIT'>2BIT</option><br>
            <option value='3BIT'>3BIT</option><br>
            <option value='1MIT'>1MIT</option><br>
            <option value='2MIT'>2MIT</option><br>
            <?php
                optionSelect($DB_Rocnik)
            ?>
        </select>
      </td>
    <tr>

    <tr>
    	<td>Hodinová dotace:</td>
	    <td><input type="text" name="dotace" size="20" value="<?php echo $DB_Hodinova_dotace; ?>"></td>
    </tr>

    <tr>
    	<td>Počet kreditů:</td>
	    <td><input type="text" name="kredity" size="20" value="<?php echo $DB_Kredity; ?>"></td>
    </tr>
	
	</table></center>
  <br>
  <center><input type="submit" name="submit" value="Upravit předmět"></center>
    </form>

    <br>
    <!-- -->
    </div>
      <div id="footer">
      Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
    </div>
    </div>
  </body>
</html>