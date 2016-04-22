<?php
    session_start();
    $man = $_SESSION['man'];
    $mon = $_SESSION['mon'];
    $yr = $_SESSION['yr'];
    $nid = $_SESSION['netid'];
    if(isset($_POST['limit'])){
            echo $nid;
    }

    $carid = $_POST['carid'];
    //echo $carid;
    //$tstamp = $_POST['clickdate'];
    //echo $tstamp;
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

    $sqlString = "INSERT INTO UserClick(netid, carid) VALUE ('$nid', $carid)";
    $result=mysqli_query($con, $sqlString);
    if(!$result){ 
        $sqlString = "INSERT INTO UserClick(netid, carid) VALUE (12345, 12345)";
        $result=mysqli_query($con, $sqlString);
    }
        // Close connection
        mysqli_close($con);

    $dbname = "uoficars_usedcars";

    // Start connection
    $con = mysqli_connect($servername, $username, $password);

    // Check connection
    if (mysqli_connect_errno()) {
         die("Could not connect: ". mysqli_connect_error());
    }

    // Connect to database
    mysqli_select_db($con, $dbname);

    $sqlString = "INSERT INTO UserClick(netid, carid) VALUE ('$nid', $carid)";
    $result=mysqli_query($con, $sqlString);
    if(!$result){ 
        $sqlString = "INSERT INTO UserClick(netid, carid) VALUE (12345, 12345)";
        $result=mysqli_query($con, $sqlString);
    }
        // Close connection
        mysqli_close($con);

?>