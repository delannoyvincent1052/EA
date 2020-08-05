
//*******************************************************************************************
// Affichage de la liste des clients
//*******************************************************************************************
	
function DisplayCustomersFunction(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
			var res = this.response;
		
			if (res.Success) {
				console.log("success");
				console.log(res.NumberOfCustomer);
				DisplayInvoices.style.display="none";
				DisplayQuotations.style.display="none";
				DisplayCatalog.style.display="none";
				DisplayProfile.style.display="none";
				DisplayQuotationModification.style.display="none";
				QuotationDetail_ExistingItems.style.display="none";
				DisplayHome.style.display="none";
				DisplayCustomers.style.display="block";

				var CustomerList="<h2>Mes clients</h2>";
				CustomerList+="<center><table><thead>";
				CustomerList+="<tr><th>Nom</th><th>Prénom</th><th>Ville</th><th></th><th></th></tr>";
				var Parameter="";
				var LastName="";
				var FirstName="";
				var City="";


				for(counter=0;counter<res.NumberOfCustomer;counter++){

					LastName=res.Customers[counter][1];
					LastName=LastName.replace("-APO-","'");
					FirstName=res.Customers[counter][0];
					FirstName=FirstName.replace("-APO-","'");
					City=res.Customers[counter][5];
					City=City.replace("-APO-","'");

					CustomerList+="<tr><td><center>"+LastName+"</center></td><td><center>"+FirstName+"</center></td><td><center>"+City+"</center></td><td class=><center><div id='CustomerDetail'><input type='button' name='CustomerDetail' value='Modifier' onclick=DisplaySelectedCustomer("+res.Customers[counter][9]+")></div></center></td><td><div id='CustomerDelete'><input type='button' name='CustomerDetail' value='Supprimer' onclick=DeleteCustomer("+res.Customers[counter][9]+")></div></td></tr>";	
				}

				CustomerList+="</thead>";
				CustomerList+="<tr><td><div id='CustomerListMessage'></div></td></tr>"
				CustomerList+="</table></center>";
				
				DisplayCustomersList.innerHTML=CustomerList;
				ResetFormCustomer();
									
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
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
}

//*******************************************************************************************
// Fonction qui va permettre d'ajouter un nouveau client
//*******************************************************************************************

function CreateANewCustomer(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var FirstName=document.getElementById("LoadFirstName").value;
	var LastName=document.getElementById("LoadLastName").value;
	LastName=LastName.replace("'","-APO-");
	var Address1=document.getElementById("LoadAddress1").value;
	Address1=Address1.replace("'","-APO-");
	var Address2=document.getElementById("LoadAddress2").value;
	Address2=Address2.replace("'","-APO-");
	var CP=document.getElementById("LoadCP").value;
	var City=document.getElementById("LoadCity").value;
	City=City.replace("'","-APO-");
	var Tel1=document.getElementById("LoadTel1").value;
	var Tel2=document.getElementById("LoadTel2").value;
	var Email=document.getElementById("LoadEmail").value;
	
	var Mandatory=1;
	var Syntax=0;

	/* Contrôle des champs */

	/* Champs obligatoires */

	if (FirstName=='') {
    	Mandatory=0;
	}
	
	if (LastName=='') {
    	Mandatory=0;
	}

	if (Email==''){
		Mandatory=0;
	}

	if(Mandatory==0){
		MessageBox.value="Veuillez renseigner les champs obligatoires ";
		return false;
	}

	/* Fin des champs obligatoires */

	/* Contrôle de la syntaxe des champs */

	if (/[a-zA-Zéè]/.test(FirstName)) {
		document.getElementById("CustomerFirstNameError").innerHTML="*"
    	return false;
	}

	if (!/[a-zA-Zéè']/.test(LastName)) {
    	MessageBox.value="Le nom ne doit contenir que des lettres !!!";
	    return false;
	}
	
	if (!/[a-zA-Z0-9éè']/.test(Address1)) {
    	MessageBox.value="L'adresse ne doit contenir que des lettres et des chiffres !!!";
	    return false;
	}
	
	if (!/[a-zA-Z0-9éè']/.test(Address1)) {
    	MessageBox.value="L'adresse ne doit contenir que des lettres et des chiffres !!!";
	    return false;
	}
	
	if (!/[0-9]/.test(CP)) {
    	MessageBox.value="Le code postal ne doit contenir que des chiffres !!!";
	    return false;
	}

	/* Fin du contrôle de syntaxe */
	

	if (!/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})/.test(Email)) {
    	MessageBox.value="L'adresse Email n'a pas la bonne forme !!!";
	    return false;
	}

	/* Fin de contrôle des champs */
	
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
		if(res.Success==1){
			document.getElementById("CustomerCreationUpdateMessage").innerHTML="Ce client est déjà enregistré !!!";
		}
		if(res.Success==2){
			document.getElementById("CustomerCreationUpdateMessage").innerHTML="Client - '"+FirstName+" "+LastName+"' - créé.";
			ResetFormCustomer();
			DisplayCustomersFunction();
		}
		if(res.Success==3){
			
			document.getElementById("CustomerCreationUpdateMessage").innerHTML="Une erreur est survenue. Veuillez recommencer.";

			ResetFormCustomer();
			DisplayCustomersFunction();
		}
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/CreationOfNewCustomer.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&FirstName="+FirstName+"&LastName="+LastName+"&Address1="+Address1+"&Address2="+Address2+"&CP="+CP+"&City="+City+"&Tel1="+Tel1+"&Tel2="+Tel2+"&Email="+Email);
}

//*******************************************************************************************
// Fonction qui va permettre d'initialiser le formulaire d'ajout d'un nouveau client
//*******************************************************************************************

function ResetFormCustomer(){

	LoadFirstName.value='';
	LoadLastName.value='';
	LoadAddress1.value='';
	LoadAddress2.value='';
	LoadCP.value='';
	LoadCity.value='';
	LoadTel1.value='';
	LoadTel2.value='';
	LoadEmail.value='';

}

//**************************************************************************************************************
// Fonction pour afficher le détail d'un utilisateur existant
//**************************************************************************************************************

function DisplaySelectedCustomer(counter){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
			var res = this.response;
		
			if (res.Success) {
				console.log("success");
				console.log(res.Customers);	
				LoadID.value=res.CustomerDetail[0];
				LoadFirstName.value=res.CustomerDetail[1];
				LoadLastName.value=res.CustomerDetail[2];	
				LoadAddress1.value=res.CustomerDetail[3];
				LoadAddress2.value=res.CustomerDetail[4];
				LoadCP.value=res.CustomerDetail[5];	
				LoadCity.value=res.CustomerDetail[6];	
				LoadTel1.value=res.CustomerDetail[7];
				LoadTel2.value=res.CustomerDetail[8];
				LoadEmail.value=res.CustomerDetail[9];
											
			} 
			//if (this.response=="KO") {
			//	alert("Login KO");
			//} 
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetSelectedCustomer.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&CustomerID="+counter);
}

//**************************************************************************************************************
// Fonction pour permet de mettre à jour le client final affiché
//**************************************************************************************************************

function UpdateSelectedCustomer(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var CustomerID=document.getElementById("LoadID").value;
	var FirstName=document.getElementById("LoadFirstName").value;
	var LastName=document.getElementById("LoadLastName").value;
	var Address1=document.getElementById("LoadAddress1").value;
	var Address2=document.getElementById("LoadAddress2").value;
	var CP=document.getElementById("LoadCP").value;
	var City=document.getElementById("LoadCity").value;
	var Tel1=document.getElementById("LoadTel1").value;
	var Tel2=document.getElementById("LoadTel2").value;
	var Email=document.getElementById("LoadEmail").value;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
		CreationCustomerMessage.innerHTML="Ce client a bien été mis à jour.";
		DisplayCustomersFunction();
			
	} else if (this.readyState == 4) {
			CreationCustomerMessage.innerHTML="Une erreur est survenue pendant la mise à jour.";
		}

	}

	xhr.open("POST", "/async/UpdateCustomer.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&CustomerID="+CustomerID+"&FirstName="+FirstName+"&LastName="+LastName+"&Address1="+Address1+"&Address2="+Address2+"&CP="+CP+"&City="+City+"&Tel1="+Tel1+"&Tel2="+Tel2+"&Email="+Email);

	return false;
}

//**************************************************************************************************************
// Fonction pour permet de mettre à jour le client final affiché
//**************************************************************************************************************

function DeleteCustomer(CustomerID){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

		if(res.Success==1){
			DisplayCustomersFunction();
		}
		if(res.Success==0){
			CustomerListMessage.innerHTML="Erreur lors de la suppression du compte.";
		}
		if(res.Success==2){
			CustomerListMessage.innerHTML="Supprimez d'abord les devis de ce client avant de supprimer ce compte.";
		}
					
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue.");
		}

	}

	xhr.open("POST", "/async/DeleteCustomer.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&CustomerID="+CustomerID);

	return false;


}
