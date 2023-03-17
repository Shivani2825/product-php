<?php
 echo "<HTML>\n";
# keep the sensitive information in a separated PHP file.
include "dbconfig.php";

$con=mysqli_connect($dbhostname,$dbusername,$dbpassword,$dbname)
or die("<br>Cannot connect to DB\n");

 $query = "SELECT * from TECH3740.EMPLOYEE";
 $result = mysqli_query($con,$query);

$eid=$elogin=$epass=$ename=$erole=$esal=$egender=$eaddress = "";

if($result)
 { echo "<p>There are " . mysqli_num_rows($result) . " employee(s) in the database.</p>";

   if (mysqli_num_rows($result)>0) 
   {
      echo "<TABLE border=1>\n";
      echo "<TR><TH>Employee ID <TH>Login <TH>Password<TH>Name<TH>Role <TH>Salary <TH>Gender<TH>Address</TH>\n";
      $total_sal = 0;
      $count_sal = 0;
      while($row = mysqli_fetch_array($result))
      { 
	  $eid=$row['employee_id'];
	  $elogin= $row['login'];
	  $epass= $row['password'];
	  $ename= $row['name'];
	  $erole= $row['role'];
	  $esal= $row['salary'];
	  $egender= $row['gender'];
	  $eaddress= $row['Address'];	
       
          if(is_null($esal)) {
           $esal = "<span style='color:red;'>NULL</span>";
          } else {
           $total_sal += $esal;
           $count_sal++;
          }

          if($egender == 'M') {
            $egender = "<span style='color:blue;'>$egender</span>";
          } else if($egender == 'F') {
            $egender = "<span style='color:red;'>$egender</span>";
          }
          
       

            echo "<TR>
            <TD>$eid</TD>
            <TD>$elogin</TD>
            <TD>$epass</TD>
            <TD>$ename</TD>
            <TD>$erole</TD>
            <TD>$esal</TD>
            <TD>$egender</TD>
            <TD>$eaddress</TD>
            </TR>";
            
        }
	if($count_sal > 0) {
         $avg_sal = $total_sal / $count_sal;
         echo "Average Salary: $avg_sal";
        }
echo "</TABLE>\n";
 
    }

else
{

 echo "<br>Something wrong with query.\n";

}
 }
else 
{
echo "<br>Something wrong with query.\n";
}


?>
