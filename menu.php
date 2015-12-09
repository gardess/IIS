<?php
header('Content-type: text/html; charset=utf-8');
  function showMenu()
  {
    if ($_SESSION['Zarazeni'] == "Administrator")
    {
      echo '<div id="menu">
        <a href="index.php">Rozvrh</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="rezervace.php">Rezervace</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="nastaveni.php">Profil</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="administrace.php">Administrace</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="logoff.php">Odhlásit</a>
        </div>';
    }
    elseif ($_SESSION['Zarazeni'] == "Akademicky pracovnik")
    {
      echo '<div id="menu">
        <a href="index.php">Rozvrh</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="rezervace.php">Rezervace</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="nastaveni.php">Profil</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="logoff.php">Odhlásit</a>
        </div>';
    }
    else
    {
      echo '<div id="menu">
        <a href="index.php">Rozvrh</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="prihlaseni.php">Přihlášení</a>
        </div>';
    }
  }

  function administraceMenu()
  {
    echo '<div id="menuRezervace">
      <a href="spravauzivatelu.php">Správa uživatelů</a>&nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="spravapredmetu.php">Správa předmětů</a>&nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="spravauceben.php">Správa učeben</a>&nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="spravaprislusenstvi.php">Správa příslušenství</a>
      </div>';
  }

  function rozvrhMenu()
  {
    echo '<div id="menuRezervace">
      <a href="index.php">Rozvrh učeben</a>&nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="rozvrh_predmety.php">Rozvrh předmětů</a>&nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="rozvrh_rocniky.php">Rozvrh ročníků</a>&nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="rozvrh_obory.php">Rozvrh oborů</a>
      </div>';
  }

?>