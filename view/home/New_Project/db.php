<?php
   $host        = "host = 127.0.0.1";
   $port        = "port = 5432";
   $dbname      = "dbname = trustPeople_db";
   $credentials = "user = postgres password=password";
   //connection variable
   $conn = pg_connect( "$host $port $dbname $credentials"  );
?>