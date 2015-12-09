<?php
session_save_path("tmp/");
session_start();
header('Content-type: text/html; charset=utf-8');

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

	include "database.php";
	function upravRezervaci($ozn, $RC, $zkr, $datum, $cas, $DB_RC, $datumR, $casR, $delkaR, $typ)
	{
		connectDB();
		if (($DB_RC != $RC) && ($_SESSION['Zarazeni'] != "Administrator"))
		{
			echo "Nemáte dostatečná oprávnění pro úpravu této rezervace.";
			return false;
		}

    	$oznU = htmlspecialchars($ozn);
	    $RCU = htmlspecialchars($RC);
	    $zkrU = htmlspecialchars($zkr);
	    $datumU = htmlspecialchars($datum);
	    $casU = htmlspecialchars($cas);
	    $datumRU = htmlspecialchars($datumR);
	    $casRU = htmlspecialchars($casR);
	    $delkaRU = htmlspecialchars($delkaR);
	    $typU = htmlspecialchars($typ);

		$sql = "UPDATE rezervace SET 
		Datum_pridani='$datumU',
		Cas_pridani='$casU',
		Oznaceni='$oznU',
		Zkratka='$zkrU',
		Datum='$datumRU',
		Cas='$casRU',
		Delka='$delkaRU',
		Typ='$typU'
		WHERE ID ='".$_SESSION['value']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Úprava proběhla úspěšně.";
			header('Location: rezervace.php');
			return true;
		}
	}

function getUsersOptions($tabulka, $PK, $ucebna)
	{
		connectDB();
	    
		$result = mysql_query("select * from $tabulka");
		$i = 0;
		while($record = MySQL_Fetch_Array($result))
		{
			$zkratka = $record[$PK];
			if ($zkratka == $ucebna)
			{
				echo "<option value='$zkratka' selected='selected'>";
			}
			else
			{
				echo "<option value='$zkratka'>";
			}
			echo "$zkratka";
			echo "</option><br>";
			$i++;
		}
	}

function optionSelect($typ)
{
	if ($typ == 'Přednáška')
	{
		echo "
		<option value='Přednáška' selected='selected'>Přednáška</option><br>
        <option value='Cvičení'>Cvičení</option><br>
        <option value='Demonstrační cvičení'>Demonstrační cvičení</option><br>
        <option value='Zkouška'>Zkouška</option><br>";
	}
	else if ($typ == 'Cvičení')
	{
		echo "
		<option value='Přednáška'>Přednáška</option><br>
        <option value='Cvičení' selected='selected'>Cvičení</option><br>
        <option value='Demonstrační cvičení'>Demonstrační cvičení</option><br>
        <option value='Zkouška'>Zkouška</option><br>";
	}
	else if ($typ == 'Demonstrační cvičení')
	{
		echo "
		<option value='Přednáška'>Přednáška</option><br>
        <option value='Cvičení'>Cvičení</option><br>
        <option value='Demonstrační cvičení' selected='selected'>Demonstrační cvičení</option><br>
        <option value='Zkouška'>Zkouška</option><br>";
	}
	elseif ($typ == 'Zkouška')
	{
		echo "
		<option value='Přednáška'>Přednáška</option><br>
        <option value='Cvičení'>Cvičení</option><br>
        <option value='Demonstrační cvičení'>Demonstrační cvičení</option><br>
        <option value='Zkouška' selected='selected'>Zkouška</option><br>";
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

    <link rel="stylesheet" type="text/css" media="all" href="js/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
		<script type="text/javascript">
			window.onload = function()
			{
				new JsDatePick(
				{
					useMode:2,
					target:"inputField",
					dateFormat:"%Y-%m-%d"
				});
			};
		</script>
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
			?>
		<div id="telo">	
		<h2 class="nadpis">Upravení rezervace</h2>
    
  	<?php
  		connectDB();
  		$req = "SELECT * FROM rezervace WHERE ID ='".$_SESSION['value']."' ";
        $res = mysql_query($req);
        while($rec = MySQL_Fetch_Array($res))
    	{
    	   	$DB_Oznaceni = $rec['Oznaceni'];
    	   	$DB_Zkratka = $rec['Zkratka'];
    	   	$DB_RC = $rec['Rodne_cislo'];
    	   	$DB_DatumR = $rec['Datum'];
    	   	$DB_CasR = $rec['Cas'];
    	   	$DB_DelkaR = $rec['Delka'];
    	   	$DB_Typ = $rec['Typ'];
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit']))
    {  
    	if ((($_POST['ucebna'] == "")) || (($_POST['zkratka'] == "")) || (($_POST['datumR'] == "")) || (($_POST['casR'] == "")) || (($_POST['delkaR'] == "")) || (($_POST['typ'] == "")))
	    {
	      echo "Nezadal jsi všechna povinná pole!<br>";
	    }
	    else
	    {
	      if(upravRezervaci($_POST['ucebna'], $_POST['RC'], $_POST['zkratka'], $_POST['datum'], $_POST['cas'], $DB_RC, $_POST['datumR'], $_POST['casR'], $_POST['delkaR'], $_POST['typ']))
	      {;}//echo "Předmět přidán.<br>";
	      else
	      {;}//echo "Předmět se nepodařilo přidat!<br>";
		}
  	}
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Učebna:</b></td>
	    <td>
		    <select name="ucebna" style="width: 173px">
		    <?php 
		      getUsersOptions('ucebna', 'Oznaceni', $DB_Oznaceni);
		    ?>
		    </select>
	    </td>
    </tr>
    

    <input type="hidden" name="RC" / value="<?php echo $uzivatel; ?>">
    <tr>
	    <td><b>Zkratka předmětu:</b></td>
	    <td>
		    <select name="zkratka" style="width: 173px">
		    <?php 
		      getUsersOptions('predmet', 'Zkratka', $DB_Zkratka);
		    ?>
		    </select>
	    </td>
	</tr>
	<tr>
		<td><b>Datum:</b></td>
		<td><input type="text" name="datumR" size="20" id="inputField" value="<?php echo $DB_DatumR; ?>"></td>
	</tr>
	<tr>
		<td><b>Čas:</b></td>
		<td><input type="text" name="casR" size="17" value="<?php echo $DB_CasR; ?>">:00</td>
	</tr>
	<tr>
		<td><b>Délka:</b></td>
		<td><input type="text" name="delkaR" size="16" value="<?php echo $DB_DelkaR; ?>">hod</td>
	</tr>

	<tr>
      <td><b>Typ výuky:</b><td>
      	<select name="typ" style="width: 173px">
      	<?php
        	optionSelect($DB_Typ);
        ?>
        </select>

    <tr>

    <input type="hidden" name="datum" / value="<?php
      												$nowFormat = getdate();
													$datum = $nowFormat["year"] . "-" . $nowFormat["mon"] . "-" . $nowFormat["mday"];
													$cas = $nowFormat["hours"] . ":" . $nowFormat["minutes"] . ":" . $nowFormat["seconds"];
													echo $datum;
													?>">
	<input type="hidden" name="cas" / value="<?php echo $cas; ?>" />

	
	</table></center>
	<br>
	<center><input type="submit" name="submit" value="Upravit rezervaci"></center>
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