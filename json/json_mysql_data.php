<?php
header("Content-Type: application/json");
        $servername = "uoficarstore.web.engr.illinois.edu";
        $username = "uoficars_rbao2";
        $password = "56897528";
        $dbname = "uoficars_usedcars";
        $man = $_COOKIE['man'];
        $mon = $_COOKIE['mon'];
        $yr = $_COOKIE['yr'];
if(isset($_POST['limit'])){
	$limit = preg_replace('#[^0-9]#', '', $_POST['limit']);

        // Start connection
        $con = mysqli_connect($servername, $username, $password);

        // Check connection
        if (mysqli_connect_errno()) {
             die("Could not connect: ". mysqli_connect_error());
        }

        // Connect to database
        mysqli_select_db($con, $dbname);

	$i = 0;
	$jsonData = '{';
	$sqlString = "SELECT * FROM carsinfo ORDER BY RAND() LIMIT $limit";
        $query = mysqli_query($con, $sqlString);
	while ($row = mysqli_fetch_array($query)) {
		$i++;
    	$vin = $row["vin"]; 
    	$makeName = $row["makeName"];
        $makeYear = $row["makeYear"];
    	$miles = $row["miles"]; 
    	$drivetrain = $row["drivetrain"]; 
    	$transmission = $row["transmission"]; 
    	$price = $row["price"]; 
    	$engineDescription = $row["engineDescription"]; 
    	$exteriorColor = $row["exteriorColor"]; 
        $img = $row["photoUrlsSmall"];
        $img1 = spliti ('"', $img, 3);
	$jsonData .= '"num'.$i.'":{ "vin":"'.$vin.'","makeName":"'.$makeName.'", "makeYear":"'.$makeYear.'", "miles":"'.$miles.'","drivetrain":"'.$drivetrain.'","transmission":"'.$transmission.'","price":"'.$price.'","engineDescription":"'.$engineDescription.'","exteriorColor":"'.$exteriorColor.'","photoUrlsSmall":"'.$img1[1].'" },';
	}
	$jsonData = chop($jsonData, ",");
	$jsonData .= '}';
        echo $jsonData;

        // Close connection
        mysqli_close($con);
}
?>