<html>
<?php
# (1)dbconfig.php: Central file to keep global information
#    Your dbconfig.php should be in the same directory
include "dbconfig.php";

## Check IP if it is inside Kean domain
if (!empty($_SERVER['HTTP_CLIENT_IP']))
   {   $ip = $_SERVER['HTTP_CLIENT_IP'];  }
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
   {   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  }
else {     $ip = $_SERVER['REMOTE_ADDR'];   }

#   echo "Your IP: $ip\n";
   $IPv4= explode(".",$ip);
   if (($IPv4[0] == 10) or ($IPv4[0] . "." . $IPv4[1] == "131.125") )
             { echo "<br>You are from Kean Unversity.\n"; }
   else      { echo "<br>You are NOT from Kean Unversity.\n"; }

echo "<br>\n";

## (2) partial search function: 
## unfinished part: search keyword *  
$keyword = $_GET["keyword"];

# DB connection
$con = mysqli_connect($dbhostname,$dbusername,$dbpassword,$dbname)
or die (" Cannot Connect to the Database. \n");

if ($keyword == "*") {
    $query = "SELECT employee_id, login, password, name, role, salary, gender, Address FROM TECH3740.EMPLOYEE";
} else {
$query = " SELECT employee_id,login,password,name,role,salary,gender,Address from TECH3740.EMPLOYEE where Address like '%$keyword%'" ;}
$result = mysqli_query($con,$query);

if($result) {
       # (3) Need to handle average salary

       $avg_salary=0;
       $sum_salary=0;
       $total_employee=mysqli_num_rows($result);

	if ( $total_employee >0) {

	echo "There are <b>". $total_employee ."</b> employee(s) in the database that the address contains search keyword: <b>" .$keyword."</b>";
	echo "<TABLE BORDER=\n";
	echo "<TR><TD>ID<TD>Login<TD>Password<TD>Name<TD>Role<TD>Salary<TD>Gender<TD>Address</TR>";
   $total_sal = 0;
   $count_sal = 0;
	while($row=mysqli_fetch_array($result)) {
             
            $employee_id = $row["employee_id"];
            $login = $row["login"];
            $password = $row["password"];
            $name = $row["name"];
            $role = $row["role"];
            $salary = $row["salary"];
            $gender = $row["gender"];
            $Address = $row["Address"];

            if(is_null($salary)) {
             $salary = "<span style='color:red;'>NULL</span>";
             } else {
            $total_sal += $salary;
            $count_sal++;}

            # display blue for male, red for female
            if($gender == 'M') {
            $gender = "<span style='color:blue;'>$gender</span>";
            } else if($gender == 'F') {
            $gender = "<span style='color:red;'>$gender</span>";
            }


            echo "<TR><TD>$employee_id</TD><TD>$login</TD><TD>$password</TD><TD>$name</TD><TD>$role</TD><TD>$salary</TD><TD>$gender </TD><TD>$Address</TD></TR>";
          }

          echo "</TABLE>\n";
          # calculate & display average salary
          if($count_sal > 0) {
            $avg_sal = $total_sal / $count_sal;
            echo "Average Salary: $avg_sal ";
          }
        }
	# if no records were found 
	else {
	    echo "<br> No Records were found in the Database with the keyword ". $keyword ."\n".
	    mysqli_free_result($result);
	}
  }
  else {
       echo "<br />Something Went Wrong with the SQL Query.\n";
  }
  mysqli_close($con);
?>

</html>
