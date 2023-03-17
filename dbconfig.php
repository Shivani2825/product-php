<?php  
$dbhostname="imc.kean.edu";
$dbusername="atpatel";
$dbpassword="1164516";
$dbname="dreamhome";

$con = mysqli_connect($dbhostname,$dbusername,$dbpassword,$dbname);


if (!$con)
    die ("Connection Failed".mysqli_connect_error());
?>