<?php

$host = "localhost";
$dbname = "automax";
$username = "root";
$password = "sucesso";

try {
   $conn = new PDO("mysql: host=$host; dbname=$dbname",$username, $password);
   $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOexception $error) {
  ECHO"error" . $error->getMessage();
}

?>