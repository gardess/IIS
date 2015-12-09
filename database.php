<?php
header('Content-type: text/html; charset=utf-8');
  define("DBHOST", "localhost:/var/run/mysql/mysql.sock");
  define("DBLOGIN", "xgarda04");
  define("DBPASSWD", "n5adohum");
  define("DBNAME", "xgarda04");
  
  function connectDB()
  {
    mysql_connect(DBHOST, DBLOGIN, DBPASSWD) or die("Nelze se připojit k databázi: ").mysql_error();
    mysql_select_db(DBNAME) or die("Nelze se připojit k databázi: ").mysql_error();
    mysql_query("SET NAMES 'utf8' COLLATE 'utf8_czech_ci'");
  }

?>