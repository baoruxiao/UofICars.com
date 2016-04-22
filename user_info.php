<?php
session_start();
$servername = "uoficarstore.web.engr.illinois.edu";
$username = "uoficars_rbao2";
$password = "56897528";
$dbname = "uoficars_user_info";
$loginid = $_POST['netid'];
$loginpw = $_POST['password'];
$make = $_POST['search_make'];
echo $make;

// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);

// Select data from the database
$sql = "SELECT * FROM User";
$result = mysqli_query($con, $sql);

// Print out the data returned from the databae
if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
          echo "netid: " . $row["netid"] . "<br>";
    }
}else{
          echo "no user info found";
}

echo "loginnetid: " . $loginid;
echo "loginpassword: " . $loginpw;

// Close connection
mysqli_close($con);

?>

