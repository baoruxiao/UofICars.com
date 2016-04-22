<?php session_start();
$tmp_nid = $_SESSION['netid'];?>
<?php
//only for test!!!!! Delete next line!!!!!!!!!!
// $tmp_nid = "xmeng16";

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

$sql = "SELECT * FROM User WHERE netid = '$tmp_nid'";
$result = mysqli_query($con,$sql);
if(!$result)
{
	echo "Don't have your netid in the database!!!!!";
}
else{
	$user=mysqli_fetch_array($result);
	$distance_nationality = array('North'=>array('North'=>0,'Rock'=>3,'Stormlands'=>10),
									'Rock'=>array('North'=>2,'Rock'=>0,'Stormlands'=>10),
									'Stormlands'=>array('North'=>8,'Rock'=>10,'Stormlands'=>0));
	$distance_degree = array('bachelor'=>0,'master'=>7,'phd'=>10);
	$distance_sex = array('male'=>0,'female'=>10);

	$sql = "SELECT * FROM User WHERE netid <>'$tmp_nid'";
	$result = mysqli_query($con,$sql);
	$distance_array = array();


	while($tmp=mysqli_fetch_array($result))
	{
		$diff_nationality = $distance_nationality[$user['nationality']][$tmp['nationality']];
		$diff_sex = abs($distance_sex[$user['sex']]-$distance_sex[$tmp['sex']]);
		$diff_degree = abs($distance_degree[$user['degree']]-$distance_degree[$tmp['degree']]);
		$diff_price = 0.5*abs($user['lprice']+$user['hprice']-$tmp['lprice']-$tmp['hprice']);
		$diff = 300*$diff_nationality+100*$diff_sex+100*$diff_degree+0.5*$diff_price;
		// this is the distance array 
		// you can find out the distance between the current user and recorded user
		// in the database by typing :
		// $distance_array[useruser's netid]
		$distance_array[$tmp['netid']]=$diff;

	}
	asort($distance_array);
	$idx=0;
	$similar_user = array();
	foreach($distance_array as $x=>$x_value)
    {
    	if($idx<4&&$x_value<7000){
    		$tmp_arr=array();
    		$sql = "SELECT * FROM User WHERE netid='$x'";
    		$result = mysqli_query($con,$sql);
    		$tmp = mysqli_fetch_array($result);
    		$tmp_arr['netid']=$tmp['netid'];
    		$tmp_arr['distance']=$x_value;
    		$tmp_arr['degree']=$tmp['degree'];
    		$tmp_arr['nationality']=$tmp['nationality'];
    		$tmp_arr['sex']=$tmp['sex'];
    		$tmp_arr['price_range']=array('lprice'=>$tmp['lprice'],'hprice'=>$tmp['hprice']);
			array_push($similar_user,$tmp_arr);
			$idx+=1;
		}
		else
			break;
	}


	$dbname = "uoficars_usedcars";

	// Start connection
	$con_car = mysqli_connect($servername, $username, $password);

	// Check connection
	if (mysqli_connect_errno()) {
	      die("Could not connect: ". mysqli_connect_error());
	}

	// Connect to database
	mysqli_select_db($con_car, $dbname);

	$data = array();
	// $topclick = array();//similar user's top five recent click
	foreach($similar_user as $each_similar)
	{
		$topclick=array();
		$x = $each_similar['netid'];
		//return carid and count
		$sql = "SELECT carid,count(*) AS count
		FROM 
		(SELECT * FROM UserClick WHERE netid='$x'AND clickdate>=DATE_SUB(now(),INTERVAL 2 DAY)) as U
		GROUP BY carid
		ORDER BY COUNT(carid) desc
		LIMIT 3";
		$result = mysqli_query($con,$sql);
		while($tmp=mysqli_fetch_array($result))
		{
			$tmp_carid = $tmp['carid'];
			$sql = "SELECT * FROM cars WHERE identity = '$tmp_carid'";
			$result_per_car = mysqli_query($con_car,$sql);
			$tmp_per_car = mysqli_fetch_array($result_per_car);
			// array_push($topclick[$x],array($tmp['carid']=>(int)$tmp['count']));
			array_push($topclick,array('carid'=>$tmp['carid'],'make'=>$tmp_per_car['makeName'],'model'=>$tmp_per_car['modelName'],'bodystyleName'=>$tmp_per_car['bodystyleName'],'year'=>$tmp_per_car['makeYear'],'price'=>$tmp_per_car['price'],'miles'=>str_replace(',','',$tmp_per_car['miles']),'count'=>(int)$tmp['count']));
			//var_dump($each_similar);
			// array_push($topclick[$x],$tmp['carid']);
		}
		$each_similar['topclick']=$topclick;
		array_push($data,$each_similar);
		// var_dump($each_similar);

	}
	// var_dump($topclick);
	$finaldata = array('netid'=>$tmp_nid,'nationality'=>$user['nationality'],'sex'=>$user['sex'],'price_range'=>array('lprice'=>$user['lprice'],'hprice'=>$user['hprice']),'degree'=>$user['degree'],'similar'=>$data);
	$json = json_encode($finaldata);
	echo $json;
	// var_dump($similar_user);
	mysqli_close($con);
	mysqli_close($con_car);

}
?>