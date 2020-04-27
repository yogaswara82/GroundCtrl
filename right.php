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
		
		
      }
	</style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; background-color: #000; color: #ffff00;">
 <strong> ATC Info</strong>
   <p id="nama"></p>	

<strong> Message</strong>
   <p id="pesan"></p>	
 
<strong>Cuaca</strong>
   <p id="cuaca"></p>	
 
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
														document.getElementById("nama").innerHTML = locations[0].name;   
														document.getElementById("pesan").innerHTML = locations[0].message;  //pesan dari ATC
														document.getElementById("cuaca").innerHTML = locations[0].cuaca;  //pesan dari ATC

													/////////////////////////////////////////////////	   
												 }
											 });
										 }
								

						
		 


   
</script>



  
</html>
