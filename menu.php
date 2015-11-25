<?php
  function showMenu()
  {
    if ($_SESSION['Zarazeni'] == "Administrator")
    {
      echo '<table width=100%>
        <td><a href="index.php">Úvodní stránka</a></td>
        <td><a href="rezervace.php">Rezervace</a></td>
        <td><a href="spravauzivatelu.php">Správa uživatelů</a></td>
        <td><a href="spravapredmetu.php">Správa předmětů</a></td>
        <td><a href="spravauceben.php">Správa učeben</a></td>
        <td><a href="logoff.php">Odhlásit</a></td>
      </table>';
    }
    elseif ($_SESSION['Zarazeni'] == "Akademicky pracovnik")
    {
      echo '<table width=100%>
        <td><a href="index.php">Úvodní stránka</a></td>
        <td><a href="rezervace.php">Rezervace</a></td>
        <td><a href="nastaveni.php">Nastavení</a></td>
        <td><a href="logoff.php">Odhlásit</a></td>
      </table>';
    }
    else
    {
      echo '<table width=100%>
        <td><a href="index.php">Úvodní stránka</a></td>
        <td><a href="prihlaseni.php">Přihlášení</a></td>
      </table>';
    }
  }


?>