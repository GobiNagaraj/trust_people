<?php
   $host        = "host = 127.0.0.1";
   $port        = "port = 5432";
   $dbname      = "dbname = trustPeople_db";
   $credentials = "user = postgres password=steven1234";

   $conn = pg_connect( "$host $port $dbname $credentials"  );
   // if(!$db) {
   //    echo "Error : Unable to open database<br>";
   // } else {
   //    echo "Opened database successfully<br>";
   // }
?>