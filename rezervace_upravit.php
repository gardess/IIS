<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	include "database.php";
	function upravRezervaci($ozn, $RC, $zkr, $datum, $cas, $DB_RC, $datumR, $casR, $delkaR, $typ)
	{
		connectDB();
		if (($DB_RC != $RC) && ($_SESSION['Zarazeni'] != "Administrator"))
		{
			echo "Nemáte dostatečná oprávnění pro úpravu této rezervace.";
			return false;
		}

    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE rezervace SET 
		Datum_pridani='$datum',
		Cas_pridani='$cas',
		Oznaceni='$ozn',
		Zkratka='$zkr',
		Datum='$datumR',
		Cas='$casR',
		Delka='$delkaR',
		Typ='$typ'
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
    <meta http-equiv="content-type" 
    content="text/html; charset=utf-8">
  </head>
  
  <body>  
    <h1>Rezervace - UPRAVIT</h1>
     <?php
    	echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		include "menu.php";
		showMenu($_SESSION['Zarazeni']);
		
  	?>
    
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

    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      
        if(upravRezervaci($_POST['ucebna'], $_POST['RC'], $_POST['zkratka'], $_POST['datum'], $_POST['cas'], $DB_RC, $_POST['datumR'], $_POST['casR'], $_POST['delkaR'], $_POST['typ']))
          {;}//echo "Předmět přidán.<br>";
        else
          {;}//echo "Předmět se nepodařilo přidat!<br>";
        endif;
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Upravit Rezervaci</h3></center></td></tr>
    <tr>
    	<td>Ucebna:</td>
	    <td>
		    <select name="ucebna">
		    <?php 
		      getUsersOptions('ucebna', 'Oznaceni');
		    ?>
		    </select>
	    </td>
    </tr>
    

    <input type="hidden" name="RC" / value="<?php echo $uzivatel; ?>">
    <tr>
	    <td>Zkratka predmetu:</td>
	    <td>
		    <select name="zkratka">
		    <?php 
		      getUsersOptions('predmet', 'Zkratka');
		    ?>
		    </select>
	    </td>
	</tr>
	<tr>
		<td>Datum:</td>
		<td><input type="text" name="datumR" value="<?php echo $DB_DatumR; ?>"></td>
	</tr>
	<tr>
		<td>Cas:</td>
		<td><input type="text" name="casR" value="<?php echo $DB_CasR; ?>"></td>
	</tr>
	<tr>
		<td>Delka:</td>
		<td><input type="text" name="delkaR" value="<?php echo $DB_DelkaR; ?>"></td>
	</tr>

	<tr>
      <td>Typ výuky:<td>
      <select name="typ">
          <option value='Přednáška'>Přednáška</option><br>
          <option value='Cvičení'>Cvičení</option><br>
          <option value='Demonstrační cvičení'>Demonstrační cvičení</option><br>
          <option value='Zkouška'>Zkouška</option><br>
        </select>

    <tr>

    <input type="hidden" name="datum" / value="<?php
      												$nowFormat = getdate();
													$datum = $nowFormat["year"] . "-" . $nowFormat["mon"] . "-" . $nowFormat["mday"];
													$cas = $nowFormat["hours"] . ":" . $nowFormat["minutes"] . ":" . $nowFormat["seconds"];
													echo $datum;
													?>">
	<input type="hidden" name="cas" / value="<?php echo $cas; ?>" />
	<tr>
		<td colspan="2"><center><input type="submit" name="submit" value="Upravit"></center></td>
	</tr>
	</table></center>
    </form>


    <!-- -->
    <?php
   		echo "</br>";
		print_r($_SESSION);
  	?>
  </body>
</html>