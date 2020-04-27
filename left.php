<!DOCTYPE html>
<html>
<head>
	<title>Web GIS simple</title>

	<script src="js/jquery.min.js"></script>
	<meta http-equiv="refresh" content="" >
	<style type="text/css">
		.container {
			height: 400px;
		}
		#map {
			width: 100%;
			height: 100%;
			border: 1px solid blue;
		}
		#data, #allData {
			display: none;
		}
	
		h4 {
			  text-align: center;
			  //text-transform: uppercase;
			 
			  
			}
		
		
      }
	</style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; background-color: #000; color: #ffff00;">
 ID 
 <strong><p id="id" color="red"></p></strong>
 Kapal
 <strong><p id="name" color="red"></p></strong>
 Jenis
 <strong><p id="type" color="red"></p></strong>
 Coordinate
 <strong><p id="coordinate"></p></strong>
 Information
 <strong><p id="info"></p>	</strong>	
 Direction
 <strong><p id="dir"></p>	</strong>	

 
</body>

<script type="text/javascript">
								var id=2;
								$(document).ready(function()
													 {
														 setInterval(ajaxcall, 2000);
													 });
								function ajaxcall()
										 {   
											 $.ajax
											 ({ 
												 url: 'database.php',
												 success: function(data) 
												 { //////////////////////////////////////
												   
													    var locations=JSON.parse(data);
														//info terbaru
														document.getElementById("id").innerHTML = locations[id-1].id;   
														document.getElementById("name").innerHTML = locations[id-1].name; 
														document.getElementById("type").innerHTML = locations[id-1].type; 
														document.getElementById("coordinate").innerHTML = locations[id-1].lat + "," + locations[id-1].lon; 
														document.getElementById("info").innerHTML = locations[id-1].msg;  
														document.getElementById("dir").innerHTML = locations[id-1].x;  
														 

													/////////////////////////////////////////////////	   
												 }
											 });
										 }
								

						
		 


   
</script>



  
</html>
