<?php
session_save_path("tmp/");
session_start();
header('Content-type: text/html; charset=utf-8');
if (!isset($_SESSION['logged']))
{
	$_SESSION['logged'] = 1;
	$_SESSION['Zarazeni'] = "null";
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

function optionSelect($obor)
{
	if ($obor == 'bakalar')
	{
		echo "
		<option value='bakalar' selected='selected'>Bakalář</option><br>
		<option value='magistr'>Magistr</option><br>";
	}
	if ($obor == 'magistr')
	{
		echo "
		<option value='bakalar'>Bakalář</option><br>
		<option value='magistr' selected='selected'>Magistr</option><br>";
	}
}

?>
<!-- Hlavní stránka - Výpis rozvrhu, který se zobrazuje všem -->


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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
		    include "database.php";
		    connectDB();
		    include "menu.php";
			showMenu();
			rozvrhMenu();
			$datum = date("Y-m-d");
			?>

		<div id="telo">	
		<h2 class="nadpis">Rozvrh ročníků</h2>
		<?php
			if(isset($_POST['obor']))
			{
				$vybranyObor = $_POST['obor'];
				$vybraneDatum = $_POST['datum'];
				$datum = $vybraneDatum;
			}
			else
			{
				$vybranyObor = "bakalar";
				$vybraneDatum = date("Y-m-d");
			}
		?>


		<?php
			echo "<form method='post'>";
		?>
    		<center><table>
    			<tr>
    				<td>Zvol obor:</td>
    				<td>
	    				<select name="obor" style="width: 103px">
	    					<?php
	    						optionSelect($vybranyObor);
	    					?>
		    			</select>
					</td>
				</tr>
				<tr>
    				<td>Zvol datum:</td>
    				<td>
	    				<input type="text" name="datum" size="10" id="inputField" value="<?php echo $datum; ?>">
					</td>
				</tr>
				<tr>
					<td colspan="2"><center><input type="submit" name="submit" value="Zobrazit rozvrh"></center></td>
    			</tr>
    		</table></center>
    		</form></br>

    	




    	<?php
    	if ($vybranyObor == 'bakalar')
    	{
    		$sql = "SELECT predmet.*, rezervace.* FROM predmet, rezervace WHERE predmet.Rocnik ='1BIT' AND predmet.Zkratka = rezervace.Zkratka AND rezervace.Datum ='$vybraneDatum'";
			//$sql="SELECT * FROM rezervace WHERE Zkratka ='$vybranyPredmet' AND Datum ='$vybraneDatum'";
      		$result=mysql_query($sql);
      		if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace ročníku 1BIT dne " . $vybraneDatum . "!</h3></center>";
		    }
		    else
			{
				echo "<center><h2>Rozvrh pro ročník 1BIT dne ". $vybraneDatum ."</h2></center>";
			    $barvaPrednaska = "#99FF99";
			    $barvaCviceni = "FFE8B4";
			    $barvaDemoCviceni = "CCFFFF";
			    $barvaZkouska = "FFFFCC";
			    echo " <center>
			    <table border=\"1\" class=\"test\">
			    	<tr>
			    		<td width=\"40\"><center>0:00</center></td>
			    		<td width=\"40\"><center>1:00</center></td>
			    		<td width=\"40\"><center>2:00</center></td>
			    		<td width=\"40\"><center>3:00</center></td>
			    		<td width=\"40\"><center>4:00</center></td>
			    		<td width=\"40\"><center>5:00</center></td>
			    		<td width=\"40\"><center>6:00</center></td>
			    		<td width=\"40\"><center>7:00</center></td>
			    		<td width=\"40\"><center>8:00</center></td>
			    		<td width=\"40\"><center>9:00</center></td>
			    		<td width=\"40\"><center>10:00</center></td>
			    		<td width=\"40\"><center>11:00</center></td>
			    		<td width=\"40\"><center>12:00</center></td>
			    		<td width=\"40\"><center>13:00</center></td>
			    		<td width=\"40\"><center>14:00</center></td>
			    		<td width=\"40\"><center>15:00</center></td>
			    		<td width=\"40\"><center>16:00</center></td>
			    		<td width=\"40\"><center>17:00</center></td>
			    		<td width=\"40\"><center>18:00</center></td>
			    		<td width=\"40\"><center>19:00</center></td>
			    		<td width=\"40\"><center>20:00</center></td>
			    		<td width=\"40\"><center>21:00</center></td>
			    		<td width=\"40\"><center>22:00</center></td>
			    		<td width=\"40\"><center>23:00</center></td>
			    	</tr>"; 
			    while($record = MySQL_Fetch_Array($result))
			    {
			       	$posun = $record['Cas'];
			       	$delka = $record['Delka'];
			       	$predmet = $record['Zkratka'];
			       	$RC = $record['Rodne_cislo'];
			       	$mistnost = $record['Oznaceni'];
			       	$typ = $record['Typ'];
			       	$ress = mysql_query("SELECT * from predmet where Zkratka ='".$predmet."' ");
			       	while($recc = MySQL_Fetch_Array($ress))
			       	{
			       		$rocnik = $recc['Rocnik'];
			       	}
			    	$res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$RC."' ");
			    	while($rec = MySQL_Fetch_Array($res))
			    	{
			    		$jmeno = $rec['Jmeno'];
			    		$prijmeni = $rec['Prijmeni'];
			    	}
			    	echo "<tr>";
			    	$prom = false;
			    	for ($i = 0; $i < 25; $i++)
			    	{
			    		if ($i == $posun)
			    		{
			    			if (strcmp($typ,"Přednáška") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaPrednaska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Demonstrační cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaDemoCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			else
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaZkouska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			$i = $i + $delka;
			    			continue;
			    		}
			    		echo "<td></td>";
			    	}
			    	echo "</tr>";
			    }
			    echo "</table></center></br>";
			}
    		//////////////////////////
    		$sql = "SELECT predmet.*, rezervace.* FROM predmet, rezervace WHERE predmet.Rocnik ='2BIT' AND predmet.Zkratka = rezervace.Zkratka AND rezervace.Datum ='$vybraneDatum'";
			//$sql="SELECT * FROM rezervace WHERE Zkratka ='$vybranyPredmet' AND Datum ='$vybraneDatum'";
      		$result=mysql_query($sql);
      		if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace ročníku 2BIT dne " . $vybraneDatum . "!</h3></center>";
		    }
		    else
			{
				echo "<center><h2>Rozvrh pro ročník 2BIT dne ". $vybraneDatum ."</h2></center>";
			    $barvaPrednaska = "#99FF99";
			    $barvaCviceni = "FFE8B4";
			    $barvaDemoCviceni = "CCFFFF";
			    $barvaZkouska = "FFFFCC";
			    echo " <center>
			    <table border=\"1\" class=\"test\">
			    	<tr>
			    		<td width=\"40\"><center>0:00</center></td>
			    		<td width=\"40\"><center>1:00</center></td>
			    		<td width=\"40\"><center>2:00</center></td>
			    		<td width=\"40\"><center>3:00</center></td>
			    		<td width=\"40\"><center>4:00</center></td>
			    		<td width=\"40\"><center>5:00</center></td>
			    		<td width=\"40\"><center>6:00</center></td>
			    		<td width=\"40\"><center>7:00</center></td>
			    		<td width=\"40\"><center>8:00</center></td>
			    		<td width=\"40\"><center>9:00</center></td>
			    		<td width=\"40\"><center>10:00</center></td>
			    		<td width=\"40\"><center>11:00</center></td>
			    		<td width=\"40\"><center>12:00</center></td>
			    		<td width=\"40\"><center>13:00</center></td>
			    		<td width=\"40\"><center>14:00</center></td>
			    		<td width=\"40\"><center>15:00</center></td>
			    		<td width=\"40\"><center>16:00</center></td>
			    		<td width=\"40\"><center>17:00</center></td>
			    		<td width=\"40\"><center>18:00</center></td>
			    		<td width=\"40\"><center>19:00</center></td>
			    		<td width=\"40\"><center>20:00</center></td>
			    		<td width=\"40\"><center>21:00</center></td>
			    		<td width=\"40\"><center>22:00</center></td>
			    		<td width=\"40\"><center>23:00</center></td>
			    	</tr>"; 
			    while($record = MySQL_Fetch_Array($result))
			    {
			       	$posun = $record['Cas'];
			       	$delka = $record['Delka'];
			       	$predmet = $record['Zkratka'];
			       	$RC = $record['Rodne_cislo'];
			       	$mistnost = $record['Oznaceni'];
			       	$typ = $record['Typ'];
			       	$ress = mysql_query("SELECT * from predmet where Zkratka ='".$predmet."' ");
			       	while($recc = MySQL_Fetch_Array($ress))
			       	{
			       		$rocnik = $recc['Rocnik'];
			       	}
			    	$res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$RC."' ");
			    	while($rec = MySQL_Fetch_Array($res))
			    	{
			    		$jmeno = $rec['Jmeno'];
			    		$prijmeni = $rec['Prijmeni'];
			    	}
			    	echo "<tr>";
			    	$prom = false;
			    	for ($i = 0; $i < 25; $i++)
			    	{
			    		if ($i == $posun)
			    		{
			    			if (strcmp($typ,"Přednáška") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaPrednaska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Demonstrační cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaDemoCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			else
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaZkouska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			$i = $i + $delka;
			    			continue;
			    		}
			    		echo "<td></td>";
			    	}
			    	echo "</tr>";
			    }
			    echo "</table></center></br>";
			}
////////////////////////

	    	$sql = "SELECT predmet.*, rezervace.* FROM predmet, rezervace WHERE predmet.Rocnik ='3BIT' AND predmet.Zkratka = rezervace.Zkratka AND rezervace.Datum ='$vybraneDatum'";
			//$sql="SELECT * FROM rezervace WHERE Zkratka ='$vybranyPredmet' AND Datum ='$vybraneDatum'";
      		$result=mysql_query($sql);
      		if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace ročníku 3BIT dne " . $vybraneDatum . "!</h3></center>";
		    }
		    else
			{
				echo "<center><h2>Rozvrh pro ročník 3BIT dne ". $vybraneDatum ."</h2></center>";
			    $barvaPrednaska = "#99FF99";
			    $barvaCviceni = "FFE8B4";
			    $barvaDemoCviceni = "CCFFFF";
			    $barvaZkouska = "FFFFCC";
			    echo " <center>
			    <table border=\"1\" class=\"test\">
			    	<tr>
			    		<td width=\"40\"><center>0:00</center></td>
			    		<td width=\"40\"><center>1:00</center></td>
			    		<td width=\"40\"><center>2:00</center></td>
			    		<td width=\"40\"><center>3:00</center></td>
			    		<td width=\"40\"><center>4:00</center></td>
			    		<td width=\"40\"><center>5:00</center></td>
			    		<td width=\"40\"><center>6:00</center></td>
			    		<td width=\"40\"><center>7:00</center></td>
			    		<td width=\"40\"><center>8:00</center></td>
			    		<td width=\"40\"><center>9:00</center></td>
			    		<td width=\"40\"><center>10:00</center></td>
			    		<td width=\"40\"><center>11:00</center></td>
			    		<td width=\"40\"><center>12:00</center></td>
			    		<td width=\"40\"><center>13:00</center></td>
			    		<td width=\"40\"><center>14:00</center></td>
			    		<td width=\"40\"><center>15:00</center></td>
			    		<td width=\"40\"><center>16:00</center></td>
			    		<td width=\"40\"><center>17:00</center></td>
			    		<td width=\"40\"><center>18:00</center></td>
			    		<td width=\"40\"><center>19:00</center></td>
			    		<td width=\"40\"><center>20:00</center></td>
			    		<td width=\"40\"><center>21:00</center></td>
			    		<td width=\"40\"><center>22:00</center></td>
			    		<td width=\"40\"><center>23:00</center></td>
			    	</tr>"; 
			    while($record = MySQL_Fetch_Array($result))
			    {
			       	$posun = $record['Cas'];
			       	$delka = $record['Delka'];
			       	$predmet = $record['Zkratka'];
			       	$RC = $record['Rodne_cislo'];
			       	$mistnost = $record['Oznaceni'];
			       	$typ = $record['Typ'];
			       	$ress = mysql_query("SELECT * from predmet where Zkratka ='".$predmet."' ");
			       	while($recc = MySQL_Fetch_Array($ress))
			       	{
			       		$rocnik = $recc['Rocnik'];
			       	}
			    	$res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$RC."' ");
			    	while($rec = MySQL_Fetch_Array($res))
			    	{
			    		$jmeno = $rec['Jmeno'];
			    		$prijmeni = $rec['Prijmeni'];
			    	}
			    	echo "<tr>";
			    	$prom = false;
			    	for ($i = 0; $i < 25; $i++)
			    	{
			    		if ($i == $posun)
			    		{
			    			if (strcmp($typ,"Přednáška") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaPrednaska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Demonstrační cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaDemoCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			else
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaZkouska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			$i = $i + $delka;
			    			continue;
			    		}
			    		echo "<td></td>";
			    	}
			    	echo "</tr>";
			    }
			    echo "</table></center></br>";
			}
		}
		else
		{
			
    		$sql = "SELECT predmet.*, rezervace.* FROM predmet, rezervace WHERE predmet.Rocnik ='1MIT' AND predmet.Zkratka = rezervace.Zkratka AND rezervace.Datum ='$vybraneDatum'";
			//$sql="SELECT * FROM rezervace WHERE Zkratka ='$vybranyPredmet' AND Datum ='$vybraneDatum'";
      		$result=mysql_query($sql);
      		if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace ročníku 1MIT dne " . $vybraneDatum . "!</h3></center>";
		    }
		    else
			{
				echo "<center><h2>Rozvrh pro ročník 1MIT dne ". $vybraneDatum ."</h2></center>";
			    $barvaPrednaska = "#99FF99";
			    $barvaCviceni = "FFE8B4";
			    $barvaDemoCviceni = "CCFFFF";
			    $barvaZkouska = "FFFFCC";
			    echo " <center>
			    <table border=\"1\" class=\"test\">
			    	<tr>
			    		<td width=\"40\"><center>0:00</center></td>
			    		<td width=\"40\"><center>1:00</center></td>
			    		<td width=\"40\"><center>2:00</center></td>
			    		<td width=\"40\"><center>3:00</center></td>
			    		<td width=\"40\"><center>4:00</center></td>
			    		<td width=\"40\"><center>5:00</center></td>
			    		<td width=\"40\"><center>6:00</center></td>
			    		<td width=\"40\"><center>7:00</center></td>
			    		<td width=\"40\"><center>8:00</center></td>
			    		<td width=\"40\"><center>9:00</center></td>
			    		<td width=\"40\"><center>10:00</center></td>
			    		<td width=\"40\"><center>11:00</center></td>
			    		<td width=\"40\"><center>12:00</center></td>
			    		<td width=\"40\"><center>13:00</center></td>
			    		<td width=\"40\"><center>14:00</center></td>
			    		<td width=\"40\"><center>15:00</center></td>
			    		<td width=\"40\"><center>16:00</center></td>
			    		<td width=\"40\"><center>17:00</center></td>
			    		<td width=\"40\"><center>18:00</center></td>
			    		<td width=\"40\"><center>19:00</center></td>
			    		<td width=\"40\"><center>20:00</center></td>
			    		<td width=\"40\"><center>21:00</center></td>
			    		<td width=\"40\"><center>22:00</center></td>
			    		<td width=\"40\"><center>23:00</center></td>
			    	</tr>"; 
			    while($record = MySQL_Fetch_Array($result))
			    {
			       	$posun = $record['Cas'];
			       	$delka = $record['Delka'];
			       	$predmet = $record['Zkratka'];
			       	$RC = $record['Rodne_cislo'];
			       	$mistnost = $record['Oznaceni'];
			       	$typ = $record['Typ'];
			       	$ress = mysql_query("SELECT * from predmet where Zkratka ='".$predmet."' ");
			       	while($recc = MySQL_Fetch_Array($ress))
			       	{
			       		$rocnik = $recc['Rocnik'];
			       	}
			    	$res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$RC."' ");
			    	while($rec = MySQL_Fetch_Array($res))
			    	{
			    		$jmeno = $rec['Jmeno'];
			    		$prijmeni = $rec['Prijmeni'];
			    	}
			    	echo "<tr>";
			    	$prom = false;
			    	for ($i = 0; $i < 25; $i++)
			    	{
			    		if ($i == $posun)
			    		{
			    			if (strcmp($typ,"Přednáška") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaPrednaska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Demonstrační cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaDemoCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			else
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaZkouska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			$i = $i + $delka;
			    			continue;
			    		}
			    		echo "<td></td>";
			    	}
			    	echo "</tr>";
			    }
			    echo "</table></center></br>";
			}
    		//////////////////////////
    		$sql = "SELECT predmet.*, rezervace.* FROM predmet, rezervace WHERE predmet.Rocnik ='2MIT' AND predmet.Zkratka = rezervace.Zkratka AND rezervace.Datum ='$vybraneDatum'";
			//$sql="SELECT * FROM rezervace WHERE Zkratka ='$vybranyPredmet' AND Datum ='$vybraneDatum'";
      		$result=mysql_query($sql);
      		if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace ročníku 2MIT dne " . $vybraneDatum . "!</h3></center>";
		    }
		    else
			{
				echo "<center><h2>Rozvrh pro ročník 2MIT dne ". $vybraneDatum ."</h2></center>";
			    $barvaPrednaska = "#99FF99";
			    $barvaCviceni = "FFE8B4";
			    $barvaDemoCviceni = "CCFFFF";
			    $barvaZkouska = "FFFFCC";
			    echo " <center>
			    <table border=\"1\" class=\"test\">
			    	<tr>
			    		<td width=\"40\"><center>0:00</center></td>
			    		<td width=\"40\"><center>1:00</center></td>
			    		<td width=\"40\"><center>2:00</center></td>
			    		<td width=\"40\"><center>3:00</center></td>
			    		<td width=\"40\"><center>4:00</center></td>
			    		<td width=\"40\"><center>5:00</center></td>
			    		<td width=\"40\"><center>6:00</center></td>
			    		<td width=\"40\"><center>7:00</center></td>
			    		<td width=\"40\"><center>8:00</center></td>
			    		<td width=\"40\"><center>9:00</center></td>
			    		<td width=\"40\"><center>10:00</center></td>
			    		<td width=\"40\"><center>11:00</center></td>
			    		<td width=\"40\"><center>12:00</center></td>
			    		<td width=\"40\"><center>13:00</center></td>
			    		<td width=\"40\"><center>14:00</center></td>
			    		<td width=\"40\"><center>15:00</center></td>
			    		<td width=\"40\"><center>16:00</center></td>
			    		<td width=\"40\"><center>17:00</center></td>
			    		<td width=\"40\"><center>18:00</center></td>
			    		<td width=\"40\"><center>19:00</center></td>
			    		<td width=\"40\"><center>20:00</center></td>
			    		<td width=\"40\"><center>21:00</center></td>
			    		<td width=\"40\"><center>22:00</center></td>
			    		<td width=\"40\"><center>23:00</center></td>
			    	</tr>"; 
			    while($record = MySQL_Fetch_Array($result))
			    {
			       	$posun = $record['Cas'];
			       	$delka = $record['Delka'];
			       	$predmet = $record['Zkratka'];
			       	$RC = $record['Rodne_cislo'];
			       	$mistnost = $record['Oznaceni'];
			       	$typ = $record['Typ'];
			       	$ress = mysql_query("SELECT * from predmet where Zkratka ='".$predmet."' ");
			       	while($recc = MySQL_Fetch_Array($ress))
			       	{
			       		$rocnik = $recc['Rocnik'];
			       	}
			    	$res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$RC."' ");
			    	while($rec = MySQL_Fetch_Array($res))
			    	{
			    		$jmeno = $rec['Jmeno'];
			    		$prijmeni = $rec['Prijmeni'];
			    	}
			    	echo "<tr>";
			    	$prom = false;
			    	for ($i = 0; $i < 25; $i++)
			    	{
			    		if ($i == $posun)
			    		{
			    			if (strcmp($typ,"Přednáška") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaPrednaska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			if (strcmp($typ,"Demonstrační cvičení") == 0)
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaDemoCviceni\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			else
			    			{
			    			    echo "<td colspan=\"$delka\" bgcolor=\"$barvaZkouska\">";
			    			    echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
			    			    $i = $i + $delka;
			    			    continue;
			    			}
			    			$i = $i + $delka;
			    			continue;
			    		}
			    		echo "<td></td>";
			    	}
			    	echo "</tr>";
			    }
			    echo "</table></center></br>";
			}
		}
		?>  
   		</div>
   		<div id="footer">
   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
		</div>
   	</div>
  	</body>
</html>