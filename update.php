<?php session_start(); ?>
<html>
<body>

<?php
$servername = "uoficarstore.web.engr.illinois.edu";
$username = "uoficars_rbao2";
$password = "56897528";
$dbname = "uoficars_user_info";
$_id = $_POST['uid'];
$_fn = $_POST['fname'];
$_ln = $_POST['lname'];
$_pn = $_POST['phone'];
$nid = $_SESSION["nid"];


// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);

$sql = "UPDATE User SET userid = '$_id', name = '$_fn $_ln', phone = '$_pn' WHERE netid = '$nid'";
mysqli_query($con, $sql);
$_SESSION["userid"] = $_id;

echo "Redirect to homepage....";

// Close connection
mysqli_close($con);

?>

<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu/temp_update_sign_in.php" />
</body>
</html>
