<?php session_start(); ?>
<html>
<?php 
$_nid = $_POST['netid'];
$_pw = $_POST['password'];
?>
<body>

<?php
$servername = "uoficarstore.web.engr.illinois.edu";
$username = "uoficars_rbao2";
$password = "56897528";
$dbname = "uoficars_user_info";


// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);

$sql = "SELECT * FROM User WHERE netid = '$_nid'";
$result = mysqli_query($con, $sql);

// Print out the data returned from the databae
if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
          $pwd = $row["password"];
          $uid = $row["userid"];
    }
}
$_SESSION['userid'] = $uid;
$_SESSION["netid"] = $_nid;
// Close connection
mysqli_close($con);

?>
<?php if ($_pw == $pwd): 
echo "Welcomes to UofICars.com, " . $uid . "<br>";
echo "Redirect to homepage....";?>

<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu/temp_update_sign_in.php" />

<?php else: 
echo "Netid or Password is incorrect, please login again " . "<br>";
echo "Redirect to homepage....";?>
?>

<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu" />

<?php endif ?>


</body>
</html>
