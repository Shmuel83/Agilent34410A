<!DOCTYPE HTML>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <meta charset=utf-8><meta http-equiv=X-UA-Compatible content="IE=edge"><meta name=description content="A front-end template that helps you build fast, modern mobile web apps."><meta name=viewport content="width=device-width, initial-scale=1">
 <meta name=mobile-web-app-capable content=yes><meta name=application-name content="Agilent"><link rel=icon sizes=192x192 href=images/touch/chrome-touch-icon-192x192.png>
 <meta name=apple-mobile-web-app-capable content=yes><meta name=apple-mobile-web-app-status-bar-style content=black><meta name=apple-mobile-web-app-title content="Agilent"><link rel=apple-touch-icon href=images/touch/apple-touch-icon.png><meta name=msapplication-TileImage content=images/touch/ms-touch-icon-144x144-precomposed.png><meta name=msapplication-TileColor content=#3372DF><meta name=theme-color content=#3372DF><link rel=stylesheet href=styles/main.css>
 <link rel="stylesheet" type="text/css" href="animate.css">
<link rel="import" href="bower_components/core-field/core-field.html">
<link rel="import" href="bower_components/core-icon/core-icon.html">
<link rel="import" href="bower_components/core-icons/core-icons.html">
<link rel="import" href="bower_components/core-icon-button/core-icon-button.html">
<link rel="import" href="bower_components/paper-input/paper-input.html">
 
 <script type="text/javascript" src="canvasjs-1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="canvasjs-1.6.2/jquery.canvasjs.min.js"></script>
<script type="text/javascript" src="noty-2.3.5/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
//<![CDATA[
function push_noty() {
	noty({
		text:"Alert Mesure Agilent",
		layout:"top",
		type:"error",
		animation:{
			open:"animated wobble",
			close:"animated flipOutX",
			speed:500
		},
		timeout:false,
		closeButton:true,
		closeOnSelfClick:true,
		closeOnSelfOver:false,
		modal:false
	});
}
//]]>
</script>
<?php
//Default input
$address = "169.254.102.195";
$port = "5025";
$request = "MEAS:VOLT:DC?";
$texteSubmit = "Lancer la mesure";
$date = date('ymd_his');
$save = $date."_monlog.txt";

//After submit user, Go to mesure
if(isset($_POST["submit"])) {
	$address = $_POST["address"];
	$port = $_POST["port"];
	$request = $_POST["requete"];
	$texteSubmit = "Mesure en cours";
	$save = $_POST["save"];
	echo"<title>$save $request</title>";
}
else {
	echo "<title>Mesure Agilent 34410A</title>";
}
?>
<style>
core-field {
      border: 1px solid #ddd;
      margin: 10px;
      height: 40px;
    }
</style>
</head>
<body>
<header class="app-bar promote-layer"><div class=app-bar-container><button class=menu><img src=images/hamburger.svg alt=Menu></button><h1 class=logo>Application Agilent  <strong>34440A</strong></h1><section class=app-bar-actions></section></div></header>
<nav class="navdrawer-container promote-layer"><h4>Navigation</h4><ul><li><a href=#hello>Mesure</a></li><li><a href="README.md">Read Me</a></li><li><a href="34410A_Quick_Reference.pdf">Commands</a></li></ul></nav>
<main>

<?php
//Settings
echo "<form method='post' id='ask' >
<core-field><core-icon icon='settings-input-hdmi'></core-icon><label>Adresse</label><input type='text' name='address' id='address' value='$address' flex></core-field>
<core-field><core-icon icon='input'></core-icon><label>port</label><input type='number' name='port' id='port' value=$port flex></core-field> 
<core-field><core-icon icon='assignment'></core-icon><label for='mesure'>Mesure </label> <select name='requete' id='requete' style='border:none' flex><option value='$request'> $request</option><option value='MEAS:CAP?'>MEAS:CAP?</option><option value='MEAS:CONT?'>MEAS:CONT?</option><option value='MEAS:CAP?'>MEAS:CAP?</option><option value='MEAS:CURR:AC?'>MEAS:CURR:AC?</option><option value='MEAS:CURR:DC?'>MEAS:CURR:DC?</option><option value='MEAS:DIOD?'>MEAS:DIOD?</option><option value='MEAS:FREQ?'>MEAS:FREQ?</option><option value='MEAS:FRES?'>MEAS:FRES?</option><option value='MEAS:PER?'>MEAS:PER?</option><option value='MEAS:RES?'>MEAS:RES?</option><option value='MEAS:TEMP?'>MEAS:TEMP?</option><option value='MEAS:VOLT:AC?'>MEAS:VOLT:AC?</option><option value='MEAS:VOLT:DC?'>MEAS:VOLT:DC?</option></select></core-field>
<core-field><core-icon icon='save'></core-icon><label for='save'>Save</label><input type='text' name='save' id='save' value='$save' flex></core-field>
<paper-input-decorator label='myPaper'><input name='submit' id='submit' type='submit' value='$texteSubmit' is='core-input'/></paper-input-decorator>";
if($texteSubmit == "Mesure en cours") {
	echo"<paper-input-decorator label='myPaper2'><input type='button' id='stop' name='stop' value='Stop' is='core-input'/></paper-input-decorator>";
}
echo"</form>";

?>

<script type="text/javascript">
window.onload = function () {

		var dps = []; // dataPoints
		var interval = null;

		var chart = new CanvasJS.Chart("chartContainer",{
			title :{
				text: "Mesure multimètre"
			},			
			data: [{
				type: "line",
				dataPoints: dps 
			}]
		});

		var xVal = 0;
		var yVal = 50;	
		var updateInterval = 1000;
		var dataLength = 50; // number of dataPoints visible at any point

		var updateChart = function () {
							
				//Envoie une requête au multimètre
				 $.ajax({
					method : 'POST',
					url : 'ajax.php', // La ressource ciblée
					data: { address : "<?php echo $address ?>", port : "<?php echo $port ?>", request : "<?php echo $request ?>", save :  "<?php echo $save ?>" },
					dataType: "html"
				})
				.done(function( yVal ) {
					yVal = parseFloat(yVal);
					
						dps.push({
							x: xVal,
							y: yVal
						});
						xVal++;
						
						//Alert if mesure <0.001
						//Well, alert with notify on head website and push for Chrome>v42 only
						if(yVal<=0.001) {
							console.log("yVal<=0.001");
							push_noty();
							$.ajax({
							method : 'POST',
							url : 'push.php', // La ressource ciblée
							data: { message :  "Ceci est un test" },
							dataType: "html"
							});
						}
					});

			if (dps.length > dataLength)
			{
				dps.shift();				
			}
			
			chart.render();		

		};
		 if(document.getElementById("submit").value=="Mesure en cours"){
			 $("#stop").show();
			// generates first set of dataPoints
			updateChart(); 

			// update chart after specified time. 
			interval = setInterval(function(){updateChart()}, updateInterval); 
			
		 }
		 $("#stop").click(function(){
			 clearInterval(interval);
			 document.getElementById("submit").value="Lancer la mesure";
			 document.getElementById("stop").value="Sauvegarde de la mesure sous <?php echo $save; ?>";
		 });
		 
	}
</script>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="demo.js"></script>
<script src="main.js"></script>
</main><script src=scripts/main.min.js></script>
</body>
</html>