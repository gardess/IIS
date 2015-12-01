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
    <h2 class="nadpis">Přidání rezervace</h2>

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
    <tr>
    	<td>Ucebna:</td>
	    <td>
		    <select name="ucebna" style="width: 173px">
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
		    <select name="zkratka" style="width: 173px">
		    <?php 
		      getUsersOptions('predmet', 'Zkratka');
		    ?>
		    </select>
	    </td>
	</tr>
	<tr>
		<td>Datum:</td>
		<td><input type="text" name="datumR" id="inputField" size="20" value="<?php echo date("Y-m-d"); ?>"></td>
	</tr>
  <tr>
    <td>Čas:</td>
    <td><input type="text" name="casR" size="17">:00</td>
  </tr>
  <tr>
    <td>Délka:</td>
    <td><input type="text" name="delkaR" size="16">hod</td>
  </tr>

  <tr>
      <td>Typ výuky:<td>
      <select name="typ" style="width: 173px">
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
	</table></center>
  <br>
  <center><input type="submit" name="submit" value="Přidat rezervaci"></center>
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