<HTML>

<?php
echo"<br><a href='logout.php'>Logout</a><br>";

$employee_id=$_GET["employee_id"];

echo <<< ADD_PRODUCT
   <font size=4><b>Add product</b></font>
   <form name="input" action="insert_product.php" method="get" required="required">
   Product Name: <input type="text" name="product_name"required="required">
   <input type='hidden' name='employee_id' value='$employee_id'>
   <br> description: <input type="text" name="description"required="required">
   <br><input type='radio' name='product_type' value='electronics'>electronics
   <input type='radio' name='product_type' value='furniture'>furniture
   <input type='radio' name='product_type' value='kitchen'>kitchen
   <br> Cost: <input type="text" name="cost"required="required">
   <br> Sell Price: <input type="text" name="sell_price"required="required">
   <br> Quantity: <input type="text" name="quantity"required="required">
ADD_PRODUCT;


# dbconfig.php: Central file to keep global information
include 'dbconfig.php';

# DB connection
$con=mysqli_connect($dbhostname,$dbusername, $dbpassword,$dbname)
        or die("<br>Cannot connect to DB\n");


$query = 'SELECT distinct vendor_id, name FROM TECH3740.VENDOR';

#echo "query: $query " . "<br>";
echo "<br>Select a vendor: <SELECT name='vendor_id'>\n";
$result = mysqli_query($con,$query);
if($result) {
    while($row = mysqli_fetch_array($result)){
        $vendor_id = $row['vendor_id'];
        $vendor_name = $row['name'];

        if ($vendor_name <>"")
        echo "<option value=$vendor_id> $vendor_name </option>\n";
    }
    mysqli_free_result($result);
}
else {
    print "No vendor Found ";
}

echo "</SELECT>\n";
mysqli_close($con);

echo "<input type='submit' value='Submit'>\n";

?>

</form>
</HTML>
