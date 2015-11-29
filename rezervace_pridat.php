<?php
session_start();
header('Content-type: text/html; charset=utf-8');
/*if (isset($_SESSION['Zarazeni']))
{
	header('Location: selecting.php');
}*/
?>
<?php
  include "database.php";
  function udelejRezervaci($ozn, $RC, $zkr, $datum, $cas, $datumR, $casR, $delkaR, $typ)
  {
    connectDB();
    $request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Datum, Cas, Delka, Typ) values('$datum','$cas','$ozn','$RC','$zkr','$datumR','$casR','$delkaR','$typ')";

    if(!mysql_query($request))
    {
      echo mysql_error();
      return false;
    }
    else
    {
      echo "Rezervace byla úspěšně přidána..";
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
    <h1>Rezervace</h1>
     <?php
    	echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		include "menu.php";
		//include "login.php";
		showMenu($_SESSION['Zarazeni']);
		
  	?>

    <!-- Formulář pro zadání nové rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      //echo "ucebna: " . $_POST['ucebna'] . "rodne cislo: " . $_POST['RC'] . "predmet: " . $_POST['zkratka'] . "jednorazova: " . $_POST['jed']. "datum: " . $_POST['datum']. "cas: " . $_POST['cas'] . "</br>";
        if(udelejRezervaci($_POST['ucebna'], $_POST['RC'], $_POST['zkratka'], $_POST['datum'], $_POST['cas'], $_POST['datumR'], $_POST['casR'], $_POST['delkaR'], $_POST['typ']))
          echo "Rezervace přidána.<br>";
        else
          echo "Rezervaci se nepodařilo přidat!<br>";
        endif;
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Přidat Rezervaci</h3></center></td></tr>
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
		<td><input type="text" name="datumR">yyyy-mm--dd</td>
	</tr>
  <tr>
    <td>Čas:</td>
    <td><input type="text" name="casR">:00</td>
  </tr>
  <tr>
    <td>Délka:</td>
    <td><input type="text" name="delkaR"></td>
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
		<td colspan="2"><center><input type="submit" name="submit" value="Přidat"></center></td>
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