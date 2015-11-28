<?php
  function showMenu()
  {
    if ($_SESSION['Zarazeni'] == "Administrator")
    {
      echo '<table width=100%>
        <td><center><a href="index.php">Úvodní stránka</a></center></td>
        <td><center><a href="rezervace.php">Rezervace</a></center></td>
        <td><center><a href="spravauzivatelu.php">Správa uživatelů</a></center></td>
        <td><center><a href="spravapredmetu.php">Správa předmětů</a></center></td>
        <td><center><a href="spravauceben.php">Správa učeben</a></center></td>
        <td><center><a href="logoff.php">Odhlásit</a></center></td>
        </table>';
    }
    elseif ($_SESSION['Zarazeni'] == "Akademicky pracovnik")
    {
      echo '<table width=100%>
        <td><center><a href="index.php">Úvodní stránka</a></center></td>
        <td><center><a href="rezervace.php">Rezervace</a></center></td>
        <td><center><a href="nastaveni.php">Nastavení</a></center></td>
        <td><center><a href="logoff.php">Odhlásit</a></center></td>
        </table>';
    }
    else
    {
      echo '<table width=100%>
        <td><center><a href="index.php">Úvodní stránka</a></center></td>
        <td><center><a href="prihlaseni.php">Přihlášení</a></center></td>
        </table>';
    }
  }

  function rezervaceMenu()
  {
    echo '<center><table width=50%>
      <td><center><a href="rezervace_pridat.php">Přidat rezervaci</a></center></td>
      <td><center><a href="rezervace_upravit.php">Upravit rezervaci</a></center></td>
      <td><center><a href="rezervace_odstranit.php">Odstranit rezervaci</a></center></td>
      </table></center>';
  }

?>