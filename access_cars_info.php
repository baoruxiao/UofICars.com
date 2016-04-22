<?php
    session_start();
    $man = $_POST['search_make'];
    $mon = $_POST['search_model'];
    $yr = $_POST['search_year'];
    $_SESSION['man'] = $man;
    $_SESSION['mon'] = $mon;
    $_SESSION['yr'] = $yr;
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

// Select data from the database
$sql = "SELECT * FROM carsinfo";
$result = mysqli_query($con, $sql);
        

// Print out the data returned from the databae
if (mysqli_num_rows($result) > 5000) {
     while($row = mysqli_fetch_assoc($result)) {
          $img = $row["photoUrlsSmall"];
          $img1 = spliti ('"', $img, 3);
          //$prnt_im = $img1[1];
          //echo $prnt_im;
          echo "vin: " . $row["vin"] . " model name: " . $row["modelName"] . " make year: " . $row["makeYear"] . " photo: " ."<img src='".$img1[1]."' /><br />" . "<br />";
    }
}else{
          echo "no user info found";
}



// Close connection
mysqli_close($con);

?>