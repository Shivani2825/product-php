<?php
echo "<HTML>\n";
# username, password from html form
$busername=$_POST["username"];
$bpassword=$_POST["password"];

## (1) refer slide to get ip address
if (!empty($_SERVER['HTTP_CLIENT_IP']))
   {   $ip = $_SERVER['HTTP_CLIENT_IP'];  }
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
   {   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  }
else {     $ip = $_SERVER['REMOTE_ADDR'];   }

   echo "Your IP: $ip\n";
   $IPv4= explode(".",$ip);
   if (($IPv4[0] == 10) or ($IPv4[0] . "." . $IPv4[1] == "131.125") )
             { echo "<br>You are from Kean Unversity.\n"; }
   else      { echo "<br>You are NOT from Kean Unversity.\n"; }
# connect DB
include "dbconfig.php";

$con=mysqli_connect($dbhostname,$dbusername,$dbpassword,$dbname)
        or die("<br>Cannot connect to DB\n");

$query = "SELECT employee_id,login, password, role, name,salary, gender,address FROM TECH3740.EMPLOYEE where login='$busername'";

#echo "<br>query: $query\n";

$result = mysqli_query($con,$query);

if($result) {
  ## (1) Need to handle all columns
  if (mysqli_num_rows($result)>0) {
    while($row = mysqli_fetch_array($result)){
        $login_id = $row['login'];
        $employee_id = $row['employee_id'];
        $epassword = $row['password'];
        $role = $row['role'];
        $ename =$row['name']; 
        $address = $row['address'];
        $gender = $row['gender'];
        $salary = $row['salary'];
    }
    if ($epassword==$bpassword) {
	display_welcome($busername,$ip,$ename,$role,$address,$salary,$gender,$employee_id);
    }
    else {
       echo "<br>User $busername is in the database, but wrong password was entered.\n";
	return_to_main_page();	
    }
  }
  else {
    echo "<br>User $busername is not in the database.\n";
     return_to_main_page();
  }
}
else {
    echo "<br>Error!\n" . mysqli_error($con);
}

mysqli_free_result($result);
mysqli_close($con);


function display_welcome($username,$ip,$ename,$role,$address,$salary,$gender,$employee_id) {

   #echo "</HTML>\n";
   echo <<< DISPLAY_Welcome
   <br><a href='logout.php'>Logout</a>
   <br>Welcome user: $ename
   <br>Role: $role
   <br>Address: $address
   <br>Gender: $gender
   <br>Salary: $salary
  
   <br><br><a href='add_product.php?employee_id=$employee_id'>Add products</a>
   <FORM action='search_product.php' method='GET'>
   Search product (name, description):
   <br> <INPUT type='text' name='keyword'>
   <INPUT type='submit' value='Search'>
   </FORM>
   </HTML>
DISPLAY_Welcome;
}

function return_to_main_page() {
  echo '<a href="index.html">Back to Main page</a>';
  echo "</HTML>\n";
  die();
}

?>
