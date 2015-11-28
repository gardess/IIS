<?php
session_start();
   //include("config.php");
   include("database.php");
   
   $error = "";
   connectDB();
   if($_SERVER["REQUEST_METHOD"] == "POST")
   {
      // username and password sent from form 
      
      $myusername=mysql_real_escape_string($_POST['username']);
      $mypassword=mysql_real_escape_string($_POST['password']); 
      
      $sql="SELECT * FROM akademicky_pracovnik WHERE Login='$myusername' and Heslo='$mypassword'";
      $result=mysql_query($sql);
      echo "result: " . $result;
      while($row = mysql_fetch_array($result))
      {
      	$_SESSION['Jmeno'] = $row['Jmeno'];
        $_SESSION['Prijmeni'] = $row['Prijmeni'];
        $_SESSION['Rodne_cislo'] = $row['Rodne_cislo'];
        $_SESSION['Zarazeni'] = $row['Zarazeni'];	
      }
      echo "TEST";

      $active=$row['active'];
      
      $count=mysql_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count==1)
      {
         //session_register("myusername");
         $_SESSION['login_user']=$myusername;
         
         header("location: index.php");
      }
      else 
      {
         $error="Your Login Name or Password is invalid";
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
      
      <style type="text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body>
	<h1>Přihlášení</h1>
	<?php
        
        //echo $_SERVER['PHP_SELF'];
        //$typUzivatele = prihlaseni();
        include "menu.php";
      showMenu();
    ?>
    
      <div align="center">
         <div style="width:300px; border: solid 1px #333333; " align="left">
            <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style="margin:30px">
               
               <form action="" method="post">
                  <label>UserName  :</label><input type="text" name="username" class="box"/><br /><br />
                  <label>Password  :</label><input type="password" name="password" class="box" /><br/><br />
                  <input type="submit" value=" Submit "/><br />
               </form>
               
               <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>