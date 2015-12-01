<?php
session_start();
header('Content-type: text/html; charset=utf-8');
   include("database.php");
   
   $error = "";
   connectDB();
   if($_SERVER["REQUEST_METHOD"] == "POST")
   {
      $myusername=mysql_real_escape_string($_POST['username']);
      $mypassword=mysql_real_escape_string($_POST['password']); 
      $mypassword1 = sha1($mypassword);
      $sql="SELECT * FROM akademicky_pracovnik WHERE Login='$myusername' and Heslo='$mypassword1'";
      $result=mysql_query($sql);
      
      while($row = mysql_fetch_array($result))
      {
        $_SESSION['Jmeno'] = $row['Jmeno'];
        $_SESSION['Prijmeni'] = $row['Prijmeni'];
        $_SESSION['Rodne_cislo'] = $row['Rodne_cislo'];
        $_SESSION['Zarazeni'] = $row['Zarazeni'];	
      }

      $active=$row['active'];
      
      $count=mysql_num_rows($result);
      

		
      if($count==1)
      {

         $_SESSION['login_user']=$myusername;
         header("location: index.php");
      }
      else 
      {
         echo "Zadal jsi nesprávný login nebo heslo.";
      }
   }
?>
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
         include "menu.php";
         showMenu();
         ?>
      <div id="telo">   
      <h2 class="nadpis">Přihlášení</h2>
      <center>
         <form action="" method="post">
            <table>
               <tr>
                  <td>Login:</td>
                  <td>
                     <input type="text" name="username"/>
                  </td>
               </tr>
               <tr>
                  <td>Heslo:</td>
                  <td>
                     <input type="password" name="password"/>
                  </td>
               </tr>
            </table>
            <br>
            <input type="submit" value="Přihlásit"/>
         </form>
      </center>       
		</div>		
      <div id="footer">
         Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
      </div>
      </div>     
				
         
			
      

   </body>
</html>