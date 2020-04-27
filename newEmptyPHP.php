<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>load demo</title>
  <style>
  body {
    font-size: 12px;
    font-family: Arial;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="assets/ajax.js"></script>

</head>
<body>
 
<b>Projects:</b>
<pre id="result"></pre>
 
<script>
    function getBody(content) 
{
   test = content.toLowerCase();    // to eliminate case sensitivity
   var x = test.indexOf("<body");
   if(x == -1) return "";

   x = test.indexOf(">", x);
   if(x == -1) return "";

   var y = test.lastIndexOf("</body>");
   if(y == -1) y = test.lastIndexOf("</html>");
   if(y == -1) y = content.length;    // If no HTML then just grab everything till end

   return content.slice(x + 1, y);   
} 
 function loadHTML(url, fun, storage, param)
{
	var xhr = createXHR();
	xhr.onreadystatechange=function()
	{ 
		if(xhr.readyState == 4)
		{
			//if(xhr.status == 200)
			{
				storage.innerHTML = getBody(xhr.responseText);
				param = storage;
                                
			}
		} 
	}; 

	xhr.open("GET", url , true);
	xhr.send(null); 

} 
var responseHTML = document.getElementById("json"); 
var target = document.getElementById("result"); 
var url = "http://localhost/AzureLane/areaCode.php?lat=-10.104036&lon=113.073914";
loadHTML(url,  responseHTML, target);
</script>
 
</body>
</html>
