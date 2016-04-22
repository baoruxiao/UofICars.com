<html>
<head>
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
<script>
var myTimer;
function ajax_json_data(){
	//document.getElementById("pagetop").innerHTML = "Top rating cars this week";
	//var thumbnailbox = document.getElementById("thumbnailbox");
	//var pictureframe = document.getElementById("pictureframe");
    var hr = new XMLHttpRequest();
    hr.open("POST", "json/json_mysql_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var d = JSON.parse(hr.responseText);
            //arbitrarybox.innerHTML = d.arbitrary.returntime;
            databox.innerHTML = "";  
            for(var o in d){
                if(d[o].vin){
                    databox.innerHTML += '<p>'+d[o].makeName+'</a><br>';       
                    databox.innerHTML += 'Model: '+d[o].modelName+'<br>';
                    databox.innerHTML += 'Year: '+d[o].makeYear+'<br>';
                    databox.innerHTML += 'Drivetrain: '+d[o].drivetrain +'<br>';
                    databox.innerHTML += 'Transmission: '+d[o].transmission+'<br>';
                    databox.innerHTML += 'Exterior Color: '+d[o].exteriorColor +'<br>';
                    databox.innerHTML += 'Engine Description: '+d[o].engineDescription +'<br>';
                    databox.innerHTML += 'Price: '+d[o].price +'</p>';

                }
            }
        }
    }
    hr.send("limit=10");
    databox.innerHTML = "requesting...";
    //myTimer = setTimeout('ajax_json_data()',6000);
}
    
function ajax_json_gallery_test(folder){
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
<h2>Search Results</h2>
<div id="databox"></div>
<script>
ajax_json_data();
</script>

</body>
</html>