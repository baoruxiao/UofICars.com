<?php
session_start();
$servername = "uoficarstore.web.engr.illinois.edu";
$username = "uoficars_rbao2";
$password = "56897528";
$dbname = "uoficars_usedcars";
$vin = $_POST['vin'];

// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);

// Select data from the database
$sql = "DELETE FROM carsinfo WHERE vin = '$vin'";
mysqli_query($con, $sql);

echo "Records has been deleted." . "<br>";
echo "Redirect to update profile...";

// Close connection
mysqli_close($con);

?>

<html>
<body>
<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu/Update_profile.php" />
</body>
</html>
