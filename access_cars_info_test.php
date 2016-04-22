<!DOCTYPE html>
<!-- saved from url=(0053)file:///C:/Users/John%20Tao/Desktop/learn_json_5.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=gbk">
<style>
body { margin:0px; background:#000; color:#CCC; }
div#pagetop { position:fixed; background: #333; padding:20px; font-size:36px; width:100%; border-bottom:#000 1px solid; }
div#thumbnailbox { float:left; margin-top:82px; width:120px; background:#292929; }
div#thumbnailbox > div { width:100px; height:80px; overflow:hidden; margin:10px; cursor:pointer; }
div#thumbnailbox > div > img { width:100px; }
div#pictureframe > img {max-width: 700px; position: fixed; top: 100px;}
div#albummenubox { position: fixed; left: 856px; top: 100px; width: 200px; background: black; padding: 12px; color: whitesmoke; border-radius: 10px; }
div#detailbox { position: fixed; left: 125px; top: 575px; width: 671px; background: #CCC; padding: 12px; color: #000; border-radius: 10px; }

</style>
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
$limit = 20;
      	if($man != '' && $mon == '' && $yr == ''){
	$sqlString = "SELECT * FROM carsinfo WHERE makeName = '$man' LIMIT $limit";
        } elseif($man == '' && $mon != '' && $yr == '') {
	$sqlString = "SELECT * FROM carsinfo WHERE modelName = '$mon' LIMIT $limit";        
        } elseif($man == '' && $mon == '' && $yr != '') {
	$sqlString = "SELECT * FROM carsinfo WHERE makeYear = '$yr' LIMIT $limit";        
        } elseif($man != '' && $mon != '' && $yr == '') {
	$sqlString = "SELECT * FROM carsinfo WHERE makeName = '$man' AND modelName = '$mon' LIMIT $limit";        
        } elseif($man == '' && $mon != '' && $yr != '') {
	$sqlString = "SELECT * FROM carsinfo WHERE makeYear = '$yr' AND modelName = '$mon' LIMIT $limit";        
        } elseif($man != '' && $mon == '' && $yr != '') {
	$sqlString = "SELECT * FROM carsinfo WHERE makeYear = '$yr' AND makeName = '$man' LIMIT $limit";        
        } elseif($man != '' && $mon != '' && $yr != '') {
	$sqlString = "SELECT * FROM carsinfo WHERE makeYear = '$yr' AND makeName = '$man' AND modelName = '$mon' LIMIT $limit";        
        } elseif($man == '' && $mon == '' && $yr == '') {
	$sqlString = "SELECT * FROM carsinfo ORDER BY RAND() LIMIT $limit";        
        }
        $sqlString = "SELECT * FROM carsinfo WHERE makeName = 'Mercedes-Benz' LIMIT $limit";
$result = mysqli_query($con, $sqlString);
        

// Print out the data returned from the databae
if (mysqli_num_rows($result)) {
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

<script>
function ajax_json_gallery(folder){
	document.getElementById("pagetop").innerHTML = "Top rating cars this week";
	var thumbnailbox = document.getElementById("thumbnailbox");
	var pictureframe = document.getElementById("pictureframe");
    var hr = new XMLHttpRequest();
    hr.open("POST", "json/json_gallery_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var d = JSON.parse(hr.responseText);
			pictureframe.innerHTML = "<img src='"+d.img1.src+"'>";
			thumbnailbox.innerHTML = "";
			for(var o in d){
				if(d[o].src){
				    thumbnailbox.innerHTML += '<div onclick="putinframe(\''+d[o].src+'\')"><img src="'+d[o].src+'"></div>';
				}
			}
	    }
    }
    hr.send("folder="+folder);
    thumbnailbox.innerHTML = "requesting...";
}
function putinframe(src){
	var pictureframe = document.getElementById("pictureframe");
	pictureframe.innerHTML = '<img src="'+src+'">';
}
</script>
</head>
<body>

<div id="pagetop">Top rating cars</div>
<div id="thumbnailbox">requesting...</div>
<div id="pictureframe"><img src="./json/gallery1/car3.jpg"></div>
<div id="albummenubox">
  <h3>Attributes details</h3>
<table style="width:100%">
  <tbody><tr>
    <td>Miles</td>		
    <td>50</td>
  </tr>
  <tr>
    <td>Condition</td>		
    <td>94</td>
  </tr>
  <tr>
    <td>Drive</td>		
    <td>80</td>
  </tr>
  <tr>
    <td>Makes and Model</td>		
    <td>80</td>
  </tr>
  <tr>
    <td>Year</td>		
    <td>80</td>
  </tr>
  <tr>
    <td>Interior Color</td>		
    <td>80</td>
  </tr>
  <tr>
    <td>Exterior Color</td>		
    <td>80</td>
  </tr>
  <tr>
    <td>Transmission</td>		
    <td>80</td>
  </tr>
  <tr>
    <td>Drive-Train</td>		
    <td>80</td>
  </tr>
  <tr>
    <td>Cylinder</td>		
    <td>80</td>
  </tr>

</tbody></table>

</div>
<div id="detailbox">
<h3>Car Description</h3>
Car...
</div>
<script>ajax_json_gallery('/json/gallery1');</script>

</body></html>