<?php

include "credentials.php";
$connection = new mysqli('localhost',$user,$pw,$db);
$Records = $connection->prepare("select * from kenworth");
$Records->execute();
$Result = $Records->get_result();
?>