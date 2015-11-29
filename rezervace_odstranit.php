<?php
header('Content-type: text/html; charset=utf-8');
  function smazRezervaci($id, $RC)
  {
    if ($_SESSION['Zarazeni'] != "Administrator")
    {
    	$req = "SELECT Rodne_cislo FROM rezervace WHERE ID ='".$id."' ";
        $res = mysql_query($req);
        echo $res;
        while($rec = MySQL_Fetch_Array($res))
    	{
    	   	$ID_RC = $rec['Rodne_cislo'];
    	}
    	if ($ID_RC != $RC)
    	{
    		echo "Nemáte dostatečná oprávnění pro smazání této rezervace.";
    		return false;
    	}
    }

    $request = "DELETE FROM rezervace WHERE id = $id";
    if(!mysql_query($request))
    {
      echo mysql_error();
      return false;
    }
    else
    {
    	echo "Smazání proběhlo úspěšně.";
    	return true;
    }
    
    $request = "select * from rezervace";// where Oznaceni='$name'";
                  
    return true;
  }
?>