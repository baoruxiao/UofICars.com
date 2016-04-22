<?php
        session_start();

        $servername = "uoficarstore.web.engr.illinois.edu";
        $username = "uoficars_rbao2";
        $password = "56897528";
        $dbname = "uoficars_usedcars";
        $netid = $_SESSION["netid"];

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

    //$sqlString = "SELECT DISTINCT * FROM cars, UserClick WHERE  cars.identity = UserClick.carid AND netid <> '$netid'AND UserClick.clickdate>=DATE_SUB(now(),INTERVAL 2 DAY) GROUP BY carid order BY UserClick.clickdate desc LIMIT $limit";        
		$sqlString = "SELECT * from cars WHERE identity in 
(select distinct identity from (
SELECT identity,clickdate FROM 
 cars, UserClick WHERE  cars.identity = UserClick.carid AND netid<>'$netid' AND UserClick.clickdate>=DATE_SUB(now(),INTERVAL 2 DAY) ORDER BY  UserClick.clickdate desc) as A) LIMIT $limit";
        $query = mysqli_query($con, $sqlString);
        $data = array();
    while ($row = mysqli_fetch_array($query)) {
        $i++;
        $datacurrent = array();
        $datacurrent['carid'] = $row["identity"];
        $datacurrent['vin'] = $row["vin"]; 
        $datacurrent['makeName'] = $row["makeName"];
        $datacurrent['modelName'] = $row["modelName"];
        $datacurrent['makeYear'] = $row["makeYear"];
        $datacurrent['miles'] = $row["miles"]; 
        $datacurrent['drivetrain'] = $row["drivetrain"]; 
        $datacurrent['transmission'] = $row["transmission"]; 
        $datacurrent['price'] = $row["price"]; 
        $datacurrent['engineDescription'] = $row["engineDescription"]; 
        $datacurrent['exteriorColor'] = $row["exteriorColor"]; 
        $datacurrent['feature']=$row["standardFeatures1"];
        $datacurrent['note']=$row["sellerNotesPart1"];
        $datacurrent['dealer']=$row["privatePartyContactName"];
        $datacurrent['vin']=$row['vin'];
        $datacurrent['phoneNumber']=$row["phoneNumber"];
        $datacurrent['zipcode']=$row["zipcode"];
        $datacurrent['stock'] = $row[""];
        $img = $row["photoUrlsSmall"];
        $img1 = spliti ('"', $img, 3);
        $datacurrent['photoUrlsSmall']=$img1[1];
        array_push($data,$datacurrent);
    }
    $jsonData = json_encode($data);

        echo $jsonData;
        
        // Close connection
        mysqli_close($con);
}
?>