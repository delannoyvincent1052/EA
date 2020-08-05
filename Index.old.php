<?php
	session_start();
	if ($_GET['Session']!=session_id())
	{
			header("Location: Login.html");
	}

	$Email=$_GET['Email'];
	$Session=$_GET['Session'];
?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>E-Artisan</title>
			<LINK rel="stylesheet" type="text/css" href="style.css">
			<script type = "text/javascript" src = "/js/CatalogItems.js" ></script>
			<script type = "text/javascript" src = "/js/QuotationDetails.js" ></script>
			<script language="JavaScript">

				

				//**************************************************************************************************************
				// Fonction pour afficher le détail d'un utilisateur existant
				//**************************************************************************************************************

				function DisplayCurstomerDetail(counter){

					var xhr = new XMLHttpRequest();
					var UserEmail=document.getElementById("LoggedUser").innerHTML;

					xhr.onreadystatechange = function() {
					console.log(this);
					if (this.readyState == 4 && this.status == 200) {
						console.log(this.response);
							var res = this.response;
						
							if (res.Success) {
								console.log("success");
								console.log(res.Customers);	
								document.getElementById('LoadFirstName').value=res.Customers[counter][0];
								document.getElementById('LoadLastName').value=res.Customers[counter][1];	
								document.getElementById('LoadAddress1').value=res.Customers[counter][2];
								document.getElementById('LoadAddress2').value=res.Customers[counter][3];
								document.getElementById('LoadCP').value=res.Customers[counter][4];	
								document.getElementById('LoadCity').value=res.Customers[counter][5];	
								document.getElementById('LoadTel1').value=res.Customers[counter][6];
								document.getElementById('LoadTel2').value=res.Customers[counter][7];
								document.getElementById('LoadEmail').value=res.Customers[counter][8];
								document.getElementById('LoadID').value=res.Customers[counter][9];								
							} 
							//if (this.response=="KO") {
							//	alert("Login KO");
							//} 
					} else if (this.readyState == 4) {
							alert("Une erreur est survenue...");
						}
				//	};
					}

					xhr.open("POST", "/async/GetMyCustomerList.php", true);
					xhr.responseType = "json";
					xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					var Usermail="<?php echo $Email ?>";
					var UserSession="<?php echo $Session ?>";
					xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);
				}


			</script>
		</head>
	<body>

	<h1>Bienvenue sur E-Artisan</h1>

		<div id="LoggedUser"><?php echo $Email ?></div><br>
		<div id="UserSession"><?php echo $Session ?></div><br>
	
	<a href="#" id="Customers">Clients</a>
	<a href="#" id="Quotations">Devis</a>
	<a href="#" id="Invoices">Factures</a>
	<a href="#" id="Catalog" onclick="DisplayCatalog()">Catalogue</a>
	<a href="#" id="Profile">Profil</a>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage devis -->
	<!-- *********************************************************************************************************** -->

	<div id ="DisplayCatalog" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Mon Catalogue</h2>
		<br>
		<div id="DisplayCatalogItems"></div>
		<br>
		
		<form id="AddItemToCatalog">
			Nom : <input type="text" id="LoadItemName" name="ItemName"><br>
			Description : <input type="text" id="LoadItemDescription"name="ItemDescription"><br>
			Prix: <input type="text" id="LoadItemPrice"name="ItemPrice"><br>
			Unité : <input type="text" id="LoadItemUnit"name="ItemUnit"><br>
			<input type="hidden" id="LoadItemID" name="ItemID"><br>
			<input type="hidden" id="LoadProfileID" name="ID"><br>
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
			<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
			<input type="submit" value="Créer">
			<input type="button" value="Mettre à jour" onclick="UpdateSelectedItem()">
			<br>
			<h2>Mes catégories</h2>
			<br>
			<div id="ExistingCategories"></div>
			<br>
			Nom : <input type="text" id="LoadCategoryName" name="CategoryName"><br>
			<input type="button" value="Créer" onclick="CreateCategory()">
			<br>
			<div id="CategoryCreationStatus"></div>
			
		</div>
		</form>
		<div id="StatusNewElement"></div>
		<br>


	</div>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage devis -->
	<!-- *********************************************************************************************************** -->

	<div id ="DisplayQuotations" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Mes Devis</h2>
		<br>
		<div id="DisplayQuotationList"></div>
		<br>
		<!--<form id="NewQuotation" onload="GetQuotationCustomer()">-->
			Nom : <input type="text" id="LoadQuotationName" name="QuotationName"><br>
			<div id="LoadQuotationCustomer"></div><br>
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
			<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
		<!--</form>-->
			<input type="button" value="Créer" onclick="CreateQuotation()">
									
		</div>
		<div id="DisplayQuotationDetail"></div>
		<br>
		<div id="QuotationCreationMessage"></div>

	</div>

		<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage du détail d'un devis -->
	<!-- *********************************************************************************************************** -->

	<div id ="DisplayQuotationModification" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Détail d'un devis</h2>
		<br>
		<!--<form id="NewQuotation" onload="GetQuotationCustomer()">-->
			Nom du devis : <input type="text" id="LoadQuotationName" name="QuotationNameDetail"><br>
			Nom du client : <input type="text" id="LoadQuotationCustomerName" name="QuotationCustomerName"><br>
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
			<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
		<!--</form>-->
			<input type="button" value="Ajouter" onclick="AddToQuotation()">
			<br>
			<div id="Category"></div>
			<div id="AddedItem"></div>
									
		</div>
		
	</div>

		<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage facture -->
	<!-- *********************************************************************************************************** -->

	<div id ="DisplayInvoices" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Mes factures</h2>
		<br>

	</div>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage Profil -->
	<!-- *********************************************************************************************************** -->

	<div id ="DisplayProfile" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">

		<br>
		<h2>Mon profil</h2>
		<br>
		<form id="ModificationOfAWorker">
			Prénom : <input type="text" id="LoadProfileFirstName" name="FirstName"><br>
			Nom : <input type="text" id="LoadProfileLastName"name="LastName"><br>
			Société : <input type="text" id="LoadProfileCompanyName"name="CompanyName"><br>
			Raison Sociale : <input type="text" id="LoadProfileSocialName"name="SocialName"><br>
			SIRET : <input type="text" id="LoadProfileRCSNumber"name="RCSNumber"><br>
			Addresse 1 : <input type="text" id="LoadProfileAddress1" name="Address1"><br>
			Addresse 2 : <input type="text" id="LoadProfileAddress2" name="Address2"><br>
			CP : <input type="text" id="LoadProfileCP" name="CP"><br>
			Ville : <input type="text" id="LoadProfileCity" name="City"><br>
			Tel1 : <input type="text" id="LoadProfileTel1" name="Tel1"><br>
			Tel2 : <input type="text" id="LoadProfileTel2" name="Tel2"><br>
			Email : <input type="text" id="LoadProfileEmail" name="Email">
			<input type="hidden" id="LoadProfileID" name="ID"><br>
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
			<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
			<div id="ButtonCustomers"><br>
			<input type="submit" value="Modifier">
			
		</div>
		</form>
		<br>
		<div id="StatusProfileModification"></div><br>
		

	</div>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage client -->
	<!-- *********************************************************************************************************** -->

	<div id ="DisplayCustomers" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">
	
		<br>
		<h2>Mes Clients</h2>
		<br>
		<form id="ModificationOfACustomer">
			Prénom : <input type="text" id="LoadFirstName" name="FirstName"><br>
			Nom : <input type="text" id="LoadLastName"name="LastName"><br>
			Addresse 1 : <input type="text" id="LoadAddress1" name="Address1"><br>
			Addresse 2 : <input type="text" id="LoadAddress2" name="Address2"><br>
			CP : <input type="text" id="LoadCP" name="CP"><br>
			Ville : <input type="text" id="LoadCity" name="City"><br>
			Tel1 : <input type="text" id="LoadTel1" name="Tel1"><br>
			Tel2 : <input type="text" id="LoadTel2" name="Tel2"><br>
			Email : <input type="text" id="LoadEmail" name="Email">
			<input type="hidden" id="LoadID" name="ID"><br>
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
			<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
			<div id="ButtonCustomers"><br>
			<input type="submit" value="Modifier">
			<input type="button" name="CustomerNewQuotation" value="Devis">
		</div>
		</form>
		
				<div id="DisplayCustomersList"></div>
		<div id="NewCustomer"><a href="#">Nouveau Client</a></div>
		<br>

	</div>

	<div id ="DisplayNewCustomer" style="width:300; height:700; overflow:auto; border:solid 1px black; display:none">
	
		<br>
		<h2>Nouveau client</h2>
		<br>
		<form id="CreationOfNewCustomer">
			<input type="text" placeholder="Prénom" name="FirstName"><br>
			<input type="text" placeholder="Nom" name="LastName"><br>
			<input type="text" placeholder="Addresse 1" name="Address1"><br>
			<input type="text" placeholder="Addresse 2" name="Address2"><br>
			<input type="text" placeholder="CP" name="CP"><br>
			<input type="text" placeholder="Ville" name="City"><br>
			<input type="text" placeholder="Téléphone 1" name="Tel1"><br>
			<input type="text" placeholder="Téléphone 2" name="Tel2"><br>
			<input type="email" placeholder="Email" name="CustomerEmail"><br>
			<input type="email" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
			
			<input type="submit" value="Création">
		</form>

		<br>
		<div id="StatusNewCustomer"></div><br>
		<div id="BackToCustomerList"><a href="#">Retour à la liste des clients</a>
		

	</div>

	<br>
	<a href="Disconnect.php">Deconnexion</a">

<script>

//*******************************************************************************************
// Affichage de la liste des clients
//*******************************************************************************************
	
	document.getElementById("Customers").addEventListener("click", function(e) {
	e.preventDefault();

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
			var res = this.response;
		
			if (res.Success) {
				console.log("success");
				console.log(res.NumberOfCustomer);
				DisplayNewCustomer.style.display="none";
				DisplayQuotations.style.display="none";
				DisplayCatalog.style.display="none";
				DisplayProfile.style.display="none";
				DisplayQuotationModification.style.display="none";
				DisplayCustomers.style.display="block";
				var CustomerList="<table><thead><tr><th colspan='4'>Mes clients</th></tr>";
				var Parameter="";

				for(counter=0;counter<res.NumberOfCustomer;counter++){

					CustomerList+="<tr><td>"+res.Customers[counter][1]+"</td><td>"+res.Customers[counter][0]+"</td><td>"+res.Customers[counter][5]+"</td><td><div id='CustomerDetail'><a href='javascript:DisplayCurstomerDetail("+counter+")'>Détails</a></div></td></tr>";	
				}
				CustomerList+="</table>";
				
				DisplayCustomersList.innerHTML=CustomerList;
									
			} 
			//if (this.response=="KO") {
			//	alert("Login KO");
			//} 
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetMyCustomerList.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var Usermail="<?php echo $Email ?>";
	var UserSession="<?php echo $Session ?>";
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
});

//*******************************************************************************************
// Détection du click sur New Customer
//*******************************************************************************************

document.getElementById("NewCustomer").addEventListener("click", function(e) {
		
	DisplayQuotations.style.display="none";
	DisplayCustomers.style.display="none";
	DisplayNewCustomer.style.display="";
	DisplayCatalog.style.display="none";
	DisplayQuotationModification.style.display="none";

	return false;
});


//-------------------------------------------------------------------------------------------
// Script Creation of a New Customer
//-------------------------------------------------------------------------------------------

	document.getElementById("CreationOfNewCustomer").addEventListener("submit", function(e) {
	e.preventDefault();

	var data = new FormData(this);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
					
			if (res.Success==1) {
				StatusNewCustomer.innerHTML="Ce client existe déjà !";
			} 
			if (res.Success==2) {
				StatusNewCustomer.innerHTML="Le nouveau client a bien été créé.";
			} 
			if (res.Success==3) {
				StatusNewCustomer.innerHTML="Erreur lors de la création du nouveau client";
			} 
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/CreationOfNewCustomer.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);

	return false;
});

//*******************************************************************************************
// Détection du click sur Retour Liste Customer
//*******************************************************************************************

document.getElementById("BackToCustomerList").addEventListener("click", function(e) {
		
	DisplayQuotations.style.display="none";
	DisplayNewCustomer.style.display="none";
	DisplayCustomers.style.display="";
	DisplayCatalog.style.display="none";
	DisplayQuotationModification.style.display="none";
	
	return false;
});

//*******************************************************************************************
// Display Quotations
//*******************************************************************************************

document.getElementById("Quotations").addEventListener("click", function(e) {
	e.preventDefault();

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		
		console.log(this.response);
		var res = this.response;
		DisplayQuotations.style.display="";
		DisplayNewCustomer.style.display="none";
		DisplayCustomers.style.display="none";
		DisplayCatalog.style.display="none";
		DisplayQuotationModification.style.display="none";
		
		
		console.log(res.Success);
		var QuotationList="<table><thead><tr><th colspan='4'>Mes devis</th></tr>";
				var Parameter="";

				for(counter=0;counter<res.NumberOfQuotations;counter++){

					QuotationList+="<tr><td>"+res.Quotations[counter][1]+"</td><td>"+res.Quotations[counter][0]+"</td><td>"+res.Quotations[counter][2]+"</td><td><input type='button' value='Supprimer' onclick='DeleteSelectedQuotation("+res.Quotations[counter][4]+")'></td><td><input type='button' value='Mettre à jour' onclick='UpdateSelectedQuotation("+res.Quotations[counter][4]+")''></td><td><input type='button' value='Détails' onclick='DisplayQuotationDetail("+res.Quotations[counter][4]+")''></td></tr>";	

				}
				QuotationList+="</table>";
				DisplayQuotationList.innerHTML=QuotationList;

				var CustomerList="Client : <select name='QuotationCustomerList' id='QuotationCustomerList'>";
				for(counter=0;counter<res.NumberOfCustomers;counter++){
					CustomerList+="<option value="+res.CustomerList[counter][0]+">"+res.CustomerList[counter][1]+" - "+res.CustomerList[counter][2]+" - "+res.CustomerList[counter][3]+" - "+res.CustomerList[counter][4]+"</option>"
				}
				CustomerList+="</select>";
				LoadQuotationCustomer.innerHTML=CustomerList; 
  

				
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetMyQuotationList.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var Usermail="<?php echo $Email ?>";
	var UserSession="<?php echo $Session ?>";
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
});

//**************************************************************************************************************
// Fonction pour mettre à jour un client existant
//**************************************************************************************************************

	document.getElementById("ModificationOfACustomer").addEventListener("submit", function(e) {
	e.preventDefault();

	var data = new FormData(this);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/UpdateCustomer.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);

	return false;
});

//*******************************************************************************************
// Display Profile
//*******************************************************************************************

document.getElementById("Profile").addEventListener("click", function(e) {
	e.preventDefault();

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		
		console.log(this.response);
		var res = this.response;
		DisplayQuotations.style.display="none";
		DisplayNewCustomer.style.display="none";
		DisplayCustomers.style.display="none";
		DisplayCatalog.style.display="none";
		DisplayProfile.style.display="";
		DisplayQuotationModification.style.display="none";

		document.getElementById('LoadProfileFirstName').value=res.Worker[1];
		document.getElementById('LoadProfileLastName').value=res.Worker[2];
		document.getElementById('LoadProfileCompanyName').value=res.Worker[3];
		document.getElementById('LoadProfileSocialName').value=res.Worker[4];
		document.getElementById('LoadProfileRCSNumber').value=res.Worker[5];
		document.getElementById('LoadProfileAddress1').value=res.Worker[6];
		document.getElementById('LoadProfileAddress2').value=res.Worker[7];
		document.getElementById('LoadProfileCP').value=res.Worker[8];
		document.getElementById('LoadProfileCity').value=res.Worker[9];
		document.getElementById('LoadProfileTel1').value=res.Worker[10];
		document.getElementById('LoadProfileTel2').value=res.Worker[11];
		document.getElementById('LoadProfileEmail').value=res.Worker[12];
		document.getElementById('LoadProfileID').value=res.Worker[0];		
		
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetMyProfile.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var Usermail="<?php echo $Email ?>";
	var UserSession="<?php echo $Session ?>";
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
});

//-------------------------------------------------------------------------------------------
// Script Modification de profil
//-------------------------------------------------------------------------------------------

	document.getElementById("ModificationOfAWorker").addEventListener("submit", function(e) {
	e.preventDefault();

	var data = new FormData(this);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
					
			if (res.Success==1) {
				StatusProfileModification.innerHTML="Votre profil a bien été modifié !";
			} 
			if (res.Success==2) {
				StatusNewCustomer.innerHTML="Une erreur est survenue pendant la modification du profil";
			} 
			 
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/ModificationOfAWorker.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);

	return false;
});

//*******************************************************************************************
// Affichage du catalog
//*******************************************************************************************
	
	document.getElementById("Catalog").addEventListener("click", function(e) {
	e.preventDefault();

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
			var res = this.response;
		
			if (res.Success) {
				console.log("success");
				
				DisplayNewCustomer.style.display="none";
				DisplayQuotations.style.display="none";
				DisplayProfile.style.display="none";
				DisplayCustomers.style.display="none";
				DisplayQuotationModification.style.display="none";
				DisplayCatalog.style.display="block";

				var ItemList="<table><thead><tr><th colspan='4'>Mes éléments de devis</th></tr>";
				var Parameter="";

				for(counter=0;counter<res.NumberOfItems;counter++){

					ItemList+="<tr><td>"+res.Items[counter][1]+"</td><td>"+res.Items[counter][2]+"</td><td>"+res.Items[counter][3]+"€</td><td>"+res.Items[counter][4]+"</td><td><input type='button' name='DeleteItem' value='Supprimer' onclick='DeleteItem("+res.Items[counter][0]+")'></td><td><input type='button' name='ModifyItem' value='Modifier' onclick='ModifyItem("+res.Items[counter][0]+")'></td></div></tr>";	
				}

				ItemList+="</table>";

				DisplayCatalogItems.innerHTML=ItemList;
													
			} 

	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetCatalogItem.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var Usermail="<?php echo $Email ?>";
	var UserSession="<?php echo $Session ?>";
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
});

//-------------------------------------------------------------------------------------------
// Script Creation of a new Catalog Element
//-------------------------------------------------------------------------------------------

	document.getElementById("AddItemToCatalog").addEventListener("submit", function(e) {
	e.preventDefault();

	var data = new FormData(this);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
					
			if (res.Success==1) {
				StatusNewElement.innerHTML="Ce élément existe déjà !";
			} 
			if (res.Success==2) {
				StatusNewElement.innerHTML="Le nouvel élément de devis a bien été créé.";
			} 
			if (res.Success==3) {
				StatusNewElement.innerHTML="Erreur lors de la création du nouvel élément.";
			} 
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/CreationOfNewCatalogElement.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);

	return false;
});

</script>

	</body>
</html>
