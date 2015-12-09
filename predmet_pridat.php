<?php
session_save_path("tmp/");
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

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
	function vytvorPredmet($zkratka, $nazev, $garant, $dotace, $kredity, $rocnik)
	{
		connectDB();

		$zkratkaU = htmlspecialchars($zkratka);
		$nazevU = htmlspecialchars($nazev);
		$garantU = htmlspecialchars($garant);
		$dotaceU = htmlspecialchars($dotace);
		$kredityU = htmlspecialchars($kredity);
		$rocnikU = htmlspecialchars($rocnik);

		$request = "insert into predmet(Zkratka, Nazev, Garant, Hodinova_dotace, Kredity, Rocnik) values('$zkratkaU','$nazevU','$garantU','$dotaceU','$kredityU','$rocnikU')";
		if(!mysql_query($request))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Předmět " . $nazevU . " byl úspěšně vytvořen.";
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
	  else
	  {
	  	echo "
	    <option value='1BIT'>1BIT</option><br>
	    <option value='2BIT'>2BIT</option><br>
	    <option value='3BIT'>3BIT</option><br>
	    <option value='1MIT'>1MIT</option><br>
	    <option value='2MIT'>2MIT</option><br>";
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
		<h2 class="nadpis">Přidat předmět</h2>
    <!-- Formulář pro vytvoření nového předmětu -->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit']))
    {
		$_SESSION['zkratkaPredmet'] = $_POST['zkratka'];
		$_SESSION['nazevPredmet'] = $_POST['nazev'];
		$_SESSION['garantPredmet'] = $_POST['garant'];
		$_SESSION['dotacePredmet'] = $_POST['dotace'];
		$_SESSION['kredityPredmet'] = $_POST['kredity'];
		$_SESSION['rocnikPredmet'] = $_POST['rocnik'];

    	if ((($_POST['zkratka'] == "")) || (($_POST['nazev'] == "")) || (($_POST['garant'] == "")) || (($_POST['rocnik'] == "")))
    	{
    		echo "Nezadal jsi všechna povinná pole!<br>";
    	}
    	else
    	{
	        if(vytvorPredmet($_POST['zkratka'], $_POST['nazev'], $_POST['garant'], $_POST['dotace'], $_POST['kredity'], $_POST['rocnik']))
	        {
	          echo "Předmět přidán.<br>";
	        }
	        else
	        {
	          echo "Předmět se nepodařilo vytvořit!<br>";
	        }   
	    }
	}
    $script_url = $_SERVER['PHP_SELF'];  
    print_r($_SESSION);
    echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Zkratka:</b></td>
	    <td><input type="text" name="zkratka" size="20" value="<?php if ($_SESSION['zkratkaPredmet'] != "") {echo $_SESSION['zkratkaPredmet'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Název:</b></td>
	    <td><input type="text" name="nazev" value="<?php if ($_SESSION['nazevPredmet'] != "") {echo $_SESSION['nazevPredmet'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Garant:</b></td>
    	<td>
		    <select name="garant" style="width: 173px">
			    <?php 
			      ziskejGaranta($_SESSION['garantPredmet']);
			    ?>
			</select>
    	</td>
    </tr>

    <tr>
    	<td><b>Ročník:</b></td>
    	<td>
	    	<select name="rocnik" style="width: 173px">
			    <?php
                	optionSelect($_SESSION['rocnikPredmet'])
            	?>
		    </select>
		</td>

    <tr>
    	<td>Hodinová dotace:</td>
	    <td><input type="text" name="dotace" value="<?php if ($_SESSION['dotacePredmet'] != "") {echo $_SESSION['dotacePredmet'];} ?>"></td>
    </tr>

    <tr>
    	<td>Počet kreditů:</td>
	    <td><input type="text" name="kredity" value="<?php if ($_SESSION['kredityPredmet'] != "") {echo $_SESSION['kredityPredmet'];} ?>"></td>
    </tr>

    
    
	
	</table></center>
	<br>
	<center><input type="submit" name="submit" value="Vytvořit předmět"></center>
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