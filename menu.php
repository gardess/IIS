<?php
  function showMenu()
  {
    if ($_SESSION['Zarazeni'] == "Administrator")
    {
      echo '<table width=100%>
        <td><center><a href="index.php">Úvodní stránka</a></center></td>
        <td><center><a href="rezervace.php">Rezervace</a></center></td>
        <td><center><a href="nastaveni.php">Profil</a></center></td>
        <td><center><a href="administrace.php">Administrace</a></center></td>
        <td><center><a href="logoff.php">Odhlásit</a></center></td>
        </table>';
    }
    elseif ($_SESSION['Zarazeni'] == "Akademicky pracovnik")
    {
      echo '<table width=100%>
        <td><center><a href="index.php">Úvodní stránka</a></center></td>
        <td><center><a href="rezervace.php">Rezervace</a></center></td>
        <td><center><a href="nastaveni.php">Profil</a></center></td>
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

  function administraceMenu()
  {
    echo '<center><table width=50%>
      <td><a href="spravauzivatelu.php">Správa uživatelů</a></td>
      <td><a href="spravapredmetu.php">Správa předmětů</a></td>
      <td><a href="spravauceben.php">Správa učeben</a></td>
      <td><a href="spravaprislusenstvi.php">Správa příslušenství</a></td>
      </table></center>';
  }

?>