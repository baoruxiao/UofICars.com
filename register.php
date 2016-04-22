<html>
<body>

<?php

$servername = "uoficarstore.web.engr.illinois.edu";
$username = "uoficars_rbao2";
$password = "56897528";
$dbname = "uoficars_user_info";
$_id = $_POST['uid'];
$_pw = $_POST['pwd'];
$_fn = $_POST['fname'];
$_ln = $_POST['lname'];
$_pn = $_POST['phone'];
$_nid = $_POST['netid'];


// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);

echo "netid: " . $_nid;
echo "password: " . $_pw;
echo "name: " . $_ln . $_fn;
echo "phone number: " . $_pn;
echo "user name: " . $_id;

$sql = "INSERT INTO User (netid, password, name, phone, userid) VALUES ('$_nid', '$_pw', '$_ln . $_fn', '$_pn', '$_id')";
mysqli_query($con, $sql);

echo "Welcomes to UofICars.com, " . $row["userid"] . "<br>";
echo "Redirect to homepage....";

// Close connection
mysqli_close($con);

?>

<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu/temp_update_sign_in.php" />
</body>
</html>

