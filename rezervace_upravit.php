<?php
session_start();
/*if (isset($_SESSION['Zarazeni']))
{
	header('Location: selecting.php');
}*/

?>
<!-- UPDATE TABLE-->
<?php
  include "database.php";
  function upravRezervaci($ozn, $RC, $zkr, $jed, $datum, $cas, $DB_RC)
  {
    connectDB();
    echo "DB_RC: " . $DB_RC;
    echo "RC:    " . $RC;
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
    Jednorazova='$jed'
    WHERE ID ='".$_SESSION['value']."' ";
    if(!mysql_query($sql))
    {
      echo mysql_error();
      return false;
    }
    else
    {
    	header('Location: rezervace.php');
    	echo "Úprava proběhla úspěšně.";

    }
                  
    return true;
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
		//include "login.php";
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
    	   	$DB_Jednorazova = $rec['Jednorazova'];
    	   	$DB_RC = $rec['Rodne_cislo'];
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      
        if(upravRezervaci($_POST['ucebna'], $_POST['RC'], $_POST['zkratka'], $_POST['jed'], $_POST['datum'], $_POST['cas'], $DB_RC))
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
		<td>Jednorazova:</td>
		<td><input type="text" name="jed" value="<?php echo $DB_Jednorazova; ?>"></td>
	</tr>
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