<?php
  define("DBHOST", "localhost");
  define("DBLOGIN", "root");
  define("DBPASSWD", "");
  define("DBNAME", "xgarda04");
  
  function connectDB()
  {
    mysql_connect(DBHOST, DBLOGIN, DBPASSWD) or die("Nelze se připojit k databázi: ").mysql_error();
    mysql_select_db(DBNAME) or die("Nelze se připojit k databázi: ").mysql_error();
    mysql_query("SET NAMES 'utf8' COLLATE 'utf8_czech_ci'");
  }


?>