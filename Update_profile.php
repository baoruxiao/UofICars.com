<?php session_start(); ?>

<html>
    <style type="text/css">
    .inputarea{
        width: 250px;
        clear: both;
    }
    .inputarea input {
        width: 100%;
        clear: both;
    }
    .back input{
        width: 250px;
        clear: both;
    }
    </style>
<body>
<h1>Update Profile</h1>

<p>Update the following for your user account information. Netid: <?php echo $_SESSION["nid"]; ?> </p>
<div class="inputarea">

<form method="post" action="http://uoficarstore.web.engr.illinois.edu/update.php">
User ID:<input type="text" name="uid" minlength="5" maxlength="20"><br>
First name: <input type="text" name="fname" required><br>
Last name: <input type="text" name="lname" required><br>
Phone:<input type="number" name="phone" required><br>
  <input type="submit" value="Submit">
</form>
</div>

<div class="back">
<form action="http://uoficarstore.web.engr.illinois.edu/temp_update_sign_in.php" method="get">
    <input type="submit" value="back to homepage" 
         name="Submit" id="frm1_submit" />
</form>
</div>

</body>
</html>

<?php
$servername = "uoficarstore.web.engr.illinois.edu";
$username = "uoficars_rbao2";
$password = "56897528";
$dbname = "uoficars_usedcars";

// Start connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (mysqli_connect_errno()) {
      die("Could not connect: ". mysqli_connect_error());
}

// Connect to database
mysqli_select_db($con, $dbname);
$nid = $_SESSION["nid"];
$sql = "SELECT * FROM carsinfo WHERE sellerName = '$nid'";
$result = mysqli_query($con, $sql);
echo "Following are the existed posts of this user:" . "</p>";
if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
          echo "vin: " . $row["vin"] . "<br>";
    }
}
?>

<html>
    <style type="text/css">
    .inputarea{
        width: 250px;
        clear: both;
    }
    .inputarea input {
        width: 100%;
        clear: both;
    }
    .back input{
        width: 250px;
        clear: both;
    }
    </style>
<body>
<div class="inputarea">
<p></p>
<form method="post" action="http://uoficarstore.web.engr.illinois.edu/delete_post.php">
Enter the vin of the posted car that you want to delete:<input type="text" name="vin" minlength="5" maxlength="20"><br>
  <input type="submit" value="Delete">
</form>
</div>

</body>
</html>