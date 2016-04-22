<?php session_start();
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
$_SESSION['userid']=$_id;
$_SESSION['netid'] = $_nid;
$_nationality = $_POST['nationality'];
$_sex= $_POST['sex'];
$_degree = $_POST['degree'];
// $_lp = intval($_POST['lprice']);
// $_hp = intval($_POST['hprice']);
$_lp = $_POST['lprice'];
$_hp = $_POST['hprice'];
$_bodystle = $_POST['bodystyle'];

?>
<html>
<body>

<?php




// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);



// echo "netid: " . $_nid;
// echo "password: " . $_pw;
// // echo "name: " . $_ln . $_fn;
// echo "phone number: " . $_pn;
// echo "user name: " . $_id;
// echo "lowprice:" . $_lp;
$name = $_fn.' '.$_ln;
// echo "name" . $name;
// sleep(10);

$sql = "INSERT INTO User (netid, password, name, phone, userid,nationality,sex,degree,lprice,hprice,bodystyle) VALUES ('$_nid', '$_pw', '$name', '$_pn', '$_id','$_nationality','$_sex','$_degree','$_lp','$_hp','$_bodystle')";
$result=mysqli_query($con, $sql);
mysqli_close($con);


?>

<?php if($result):
	echo "Welcomes to UofICars.com, " . $_SESSION['userid'] . "<br>";
	echo "Redirect to homepage....</br>";?>
<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu/temp_update_sign_in.php" />

<?php else:
	echo "Your netid has already been used. You need to register again.</br>";
?>
<meta http-equiv="refresh", content="3;url=http://uoficarstore.web.engr.illinois.edu/Register_page.html" />

<?php endif ?>
</body>
</html>