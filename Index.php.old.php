<?php
	session_start();
	if ($_GET['Session']!=session_id())
	{
			header("Location: Login.html");
	}

	$Email=$_GET['Email'];
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Login E-Artisan</title>
		</head>
	<body>

	<h1>Bienvenue sur E-Artisan</h1>

	<div id="User"><?php echo $Email ?><br></div>
	
	<a href="#" onclick="javascript:changeVisibilite('Customers'); return true;" >Clients</a>
	<a href="#" onclick="javascript:changeVisibilite('Quotations'); return true;" >Devis</a>
	<a href="#" onclick="javascript:changeVisibilite('Invoices'); return true;" >Factures</a>
	<a href="#" onclick="javascript:changeVisibilite('Profile'); return true;" >Profil</a>

	<div id ="Customers" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">
	
		<br>
		<h2>Mes Clients</h2>
		<a href='GetMyCustomerList()'></a>
		<br>

	</div>

	<div id ="Quotations" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Mes Devis</h2>
		<br>

	</div>

	<div id ="Invoices" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Mes factures</h2>
		<br>

	</div>

	<div id ="Profile" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Mon profil</h2>
		<br>

	</div>


	<br>
	<a href="Disconnect.php">Deconnexion</a">

	<script>
		
		function changeVisibilite(thingId)

		{
			if(thingId=="Customers")
			{
				var Quotations=document.getElementById("Quotations");
				Quotations.style.display = "none";
				var Invoices=document.getElementById("Invoices");
				Invoices.style.display = "none";
				var Profile=document.getElementById("Profile");
				Profile.style.display = "none";

			}

			if(thingId=="Quotations")
			{
				var Customers=document.getElementById("Customers");
				Customers.style.display = "none";
				var Invoices=document.getElementById("Invoices");
				Invoices.style.display = "none";
				var Profile=document.getElementById("Profile");
				Profile.style.display = "none";

			}

			if(thingId=="Invoices")
			{
				var Customers=document.getElementById("Customers");
				Customers.style.display = "none";
				var Quotations=document.getElementById("Quotations");
				Quotations.style.display = "none";
				var Profile=document.getElementById("Profile");
				Profile.style.display = "none";

			}

			if(thingId=="Profile")
			{
				var Customers=document.getElementById("Customers");
				Customers.style.display = "none";
				var Quotations=document.getElementById("Quotations");
				Quotations.style.display = "none";
				var Invoices=document.getElementById("Invoices");
				Invoices.style.display = "none";

			}
				

			targetElement = document.getElementById(thingId);

			if(targetElement.style.display == "none")
			{
				targetElement.style.display = "" ;
			} 
			GetMyCustomerList();

		}


	</script>



	</body>
</html>
