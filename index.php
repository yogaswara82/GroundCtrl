<!DOCTYPE html>
<html>
<head>
	<title>Web GIS simple</title>

	<!--<script type="text/javascript" src="source/indonesia.mbtiles"></script>-->
	<script src="js/jquery.min.js"></script>
	<meta http-equiv="refresh" content="" >
	<style type="text/css">
	 #left{
							float: left;
							width: 120px
							height: 560px; /* only for demonstration, should be removed */
							background: #111;
							color: #fff;
						
							padding: 0px;
						}
	 #center{
						    float: left;
							width: 500px
							height:padding: 0px; 500px; /* only for demonstration, should be removed */
							background: #aaa;
							padding: 0px;
						}
     #right{
						    float: left;
							width: 120px
							height: 560px; /* only for demonstration, should be removed */
							background: #ccc;
							padding: 0px;
							color: white;
						}	
		
	</style>
</head>

	
<body  scroll="no" style="overflow: hidden; background-color: #000;" >
		<div id="left">
			
			<iframe width="150" height="500" src="left.php"  scrolling="no" frameborder="0" allowfullscreen></iframe>
		   
		</div>

		<div id="center">
			
			<iframe width="480" height="565" src="main.php"  scrolling="no" frameborder="0" allowfullscreen></iframe>
		   
		</div>

		<div id="right">
			
			<iframe width="150" height="500" src="right.php"  scrolling="no" frameborder="0" allowfullscreen></iframe>
		   
		</div>

</body>

</html>
