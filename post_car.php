<?php session_start(); ?>
<html>
<body>

<?php

$servername = "uoficarstore.web.engr.illinois.edu";
$username = "uoficars_rbao2";
$password = "56897528";
$dbname = "uoficars_usedcars";

$identity = $_POST['identity'];
$sellerName = $_POST['sellerName'];
$miles = $_POST['miles'];
$vin = $_POST['vin'];
$makeName = $_POST['makeName'];
$modelName = $_POST['modelName'];
$makeYear = $_POST['makeYear'];
$drivetrain = $_POST['drivetrain'];
$transmission = $_POST['transmission'];
$exteriorColor = $_POST['exteriorColor'];
$price = $_POST['price'];
$photoUrlsSmall = $_POST['photoUrlsSmall'];
$_SESSION['uid'] = $sellerName; 
// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);

$sql = "INSERT INTO carsinfo (sellerName, identity, modelName, miles, vin, makeName, makeYear, drivetrain, transmission, exteriorColor, price, photoUrlsSmall) VALUES ('$sellerName', '$identity','$modelName','$miles', '$vin', '$makeName', '$makeYear', '$drivetrain', '$transmission', '$exteriorColor', '$price', '$photoUrlsSmall')";
$result =mysqli_query($con, $sql);

if($result){
echo "New sale has been posted! " . "<br>";
echo "Redirect to homepage....";
}
// Close connection
mysqli_close($con);

?>

<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu/temp_update_sign_in.php" />
</body>
</html>
