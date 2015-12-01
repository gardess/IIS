<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function upravUcebnu($oznaceni, $cislo, $budova, $kapacita)
	{
		connectDB();


    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE ucebna SET 
		Oznaceni='$oznaceni',
		Cislo_mistnosti='$cislo',
		Budova='$budova',
		Kapacita='$kapacita'
		WHERE Oznaceni ='".$_SESSION['value']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Úprava proběhla úspěšně.";
			header('Location: spravauceben.php');
			return true;
		}
	}

	function getUsersOptions($tabulka, $PK)
	{
		connectDB();
		$result = mysql_query("select * from $tabulka");
		$i = 0;
		while($record = MySQL_Fetch_Array($result))
		{
			$zkratka = $record[$PK];
			echo "<option value='$zkratka'>";
			echo "$zkratka";
			echo "</option><br>";
			$i++;
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
        if ((($_SESSION['Zarazeni']) == "Administrator") || (($_SESSION['Zarazeni']) == "Akademicky pracovnik"))
        echo "<div id=\"prihlasen\">Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni']."&nbsp;</div>";
        connectDB();
        include "menu.php";
      showMenu();
      administraceMenu();
      ?>
    <div id="telo"> 
    <h2 class="nadpis">Upravení učebny</h2>
    
  	<?php
  		connectDB();
  		$req = "SELECT * FROM ucebna WHERE Oznaceni ='".$_SESSION['value']."' ";
        $res = mysql_query($req);
        while($rec = MySQL_Fetch_Array($res))
    	{
    		$DB_Oznaceni = $rec['Oznaceni'];
    	   	$DB_Cislo_Mistnosti = $rec['Cislo_mistnosti'];
    	   	$DB_Budova = $rec['Budova'];
    	   	$DB_Kapacita = $rec['Kapacita'];
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      
        if(upravUcebnu($_POST['oznaceni'], $_POST['cislo'], $_POST['budova'], $_POST['kapacita']))
          {;}//echo "Předmět přidán.<br>";
        else
          {;}//echo "Předmět se nepodařilo přidat!<br>";
        endif;
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td>Označení:</td>
	    <td><input type="text" name="oznaceni" size="20" value="<?php echo $DB_Oznaceni; ?>"></td>
    </tr>

    <tr>
    	<td>Číslo místnosti:</td>
	    <td><input type="text" name="cislo" size="20" value="<?php echo $DB_Cislo_Mistnosti; ?>"></td>
    </tr>

    <tr>
    	<td>Budova:</td>
	    <td><input type="text" name="budova" size="20" value="<?php echo $DB_Budova; ?>"></td>
    </tr>

    <tr>
    	<td>Kapacita:</td>
	    <td><input type="text" name="kapacita" size="20" value="<?php echo $DB_Kapacita; ?>"></td>
    </tr>

	</table>
  <br>
  <center><input type="submit" name="submit" value="Upravit učebnu"></center>
  </center>
    </form>


    <!-- -->
    <br>
    </div>
      <div id="footer">
      Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
    </div>
    </div>
  </body>
</html>