<?php

$connect = new PDO("mysql:host=localhost;dbname=attendance", "root", "");

$base_url = "http://localhost/Attendance/";

function get_total_records($connect,$table_name){
$query="SELECT * FROM $table_name";
$statement=$connect->prepare($query);
$statement->execute();
return $statement->rowCount(); 
}
?>