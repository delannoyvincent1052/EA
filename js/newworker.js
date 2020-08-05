
		 
function InitializeFields(){

	GetDepartementList();

}

/* Cette fonction va permettre de charger le champ Departement avec la liste des Departement */

function GetDepartementList(){

	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('Fonction','GetDepartementList');
	xhr.onreadystatechange = function() {
		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;

			if(res.Success==1){

				var DepartementList="";

				for(Counter=0;Counter<res.NbOfDepartement;Counter++){

					DepartementList+="<option value='"+res.DepartementList[Counter][0]+"'>"+ res.DepartementList[Counter][0] + "-" + res.DepartementList[Counter][1]+"</option>";
				}

				Departement.innerHTML=DepartementList;
							
			}
			if(res.Success==0){
				
			}
											 
		} 
		else if (this.readyState == 4) {
				MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/NewWorker/GetDepartementList.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

/* Cette fonction va permettre de charger le champ City avec la liste des villes */

function GetCityList(){

	var xhr = new XMLHttpRequest();
	var SelectedDepartement=document.getElementById("Departement").value;
	var formData = new FormData();
	formData.append('SelectedDepartement',SelectedDepartement);
	xhr.onreadystatechange = function() {
		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;

				if(res.Success==1){

					var CityList="";
					for(Counter=0;Counter<res.NbOfCities;Counter++){

						CityList+="<option value='"+res.CityList[Counter]+"'>"+ res.CityList[Counter]+"</option>";

					}
					City.innerHTML=CityList;

				}
				if(res.Success==0){

					
				}
											 
		} 
		else if (this.readyState == 4) {
				MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/NewWorker/GetCityList.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

/* Cette fonction va permettre de récupérer le copde postal de la ville sélectionnée */

function GetCityCP(){

	var xhr = new XMLHttpRequest();
	var SelectedCity=document.getElementById("City").value;
	var formData = new FormData();
	formData.append('SelectedCity',SelectedCity);
	xhr.onreadystatechange = function() {
		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;

			if(res.Success==1){

				document.getElementById('CP').value=res.CPOfCity;
				
			}
			if(res.Success==0){

				
			}
							 
		}
		else if (this.readyState == 4) {
				MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/NewWorker/GetCityCP.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

/* Cette fonction va permettre de créer un nouveau worker */

function NewWorker(){

	var xhr = new XMLHttpRequest();
	var formData = new FormData();

	/* Reset champ erreurs */

	document.getElementById("FirstNameError").innerHTML="";
	document.getElementById("LastNameError").innerHTML="";
	document.getElementById("CompanyNameError").innerHTML="";
	document.getElementById("RCSNumberError").innerHTML="";
	document.getElementById("Address1Error").innerHTML="";
	document.getElementById("Address2Error").innerHTML="";
	document.getElementById("CPError").innerHTML="";
	document.getElementById("CityError").innerHTML="";
	document.getElementById("Tel1Error").innerHTML="";
	document.getElementById("Tel2Error").innerHTML="";
	document.getElementById("EmailError").innerHTML="";

	var Mandatory=1;
	var ErrorField=0;

	var FirstName=document.getElementById("FirstName").value;
	var LastName=document.getElementById("LastName").value;
	var CompanyName=document.getElementById("CompanyName").value;
	var SocialName=document.getElementById("SocialName").value;
	var RCSNumber=document.getElementById("RCSNumber").value;
	var Address1=document.getElementById("Address1").value;
	var Address2=document.getElementById("Address2").value;
	var CP=document.getElementById("CP").value;
	var City=document.getElementById("City").value;
	var Tel1=document.getElementById("Tel1").value;
	var Tel2=document.getElementById("Tel2").value;
	var Email=document.getElementById("Email").value;

	
/* Contrôle des champs */

	/* Champ FirstName */

	if (FirstName=='') {
    	Mandatory=0;
    	document.getElementById("FirstNameError").innerHTML+="<h4 class='ko'>*<h4>";
	}
	if (/[^a-zA-Zéè\- ]/.test(FirstName)) {
    	document.getElementById('FirstNameError').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}

	/* Champ LastName */

	if (LastName=='') {
    	Mandatory=0;
    	document.getElementById("LastNameError").innerHTML+="<h4 class='ko'>*<h4>";
	}
	if (/[^a-zA-Zéè\- ]/.test(LastName)) {
    	document.getElementById('LastNameError').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}

	/* Champ CompanyName */

	if (CompanyName==''){
		Mandatory=0;
		document.getElementById("CompanyNameError").innerHTML+="<h4 class='ko'>*<h4>";
	}
	if (/[^a-zA-Zéè\- ]/.test(CompanyName)) {
    	document.getElementById('CompanyNameError').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}

	/* Champ RCSNumber */

	if (RCSNumber==''){
		Mandatory=0;
		document.getElementById('RCSNumberError').innerHTML+="<h4 class='ko'>*<h4>";
	}
	if (/[^0-9]/.test(RCSNumber)) {
    	document.getElementById('RCSNumberError').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}

	/* Champ Address1 */

	if(Address1==''){
		Mandatory=0;
		document.getElementById("Address1Error").innerHTML+="<h4 class='ko'>*<h4>";
	}
	if (/[^0-9a-zA-Zéè\-, ]/.test(Address1)) {
    	document.getElementById('Address1Error').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}

	/* Champ Address2 */

	if (/[^0-9a-zA-Zéè\-, ]/.test(Address1)) {
    	document.getElementById('Address2Error').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}

	/* Champ CP */

	if(CP==''){
		Mandatory=0;
		document.getElementById("CPError").innerHTML+="<h4 class='ko'>*<h4>";
	}

	/* Champ City */

	if(City==''){
		Mandatory=0;
		document.getElementById("CityError").innerHTML+="<h4 class='ko'>*<h4>";
	}

	/* Champ Tel1 */

	if((Tel1=='')||(/[^0-9]/.test(Tel1))||(Tel1.length<10)){
		
    	document.getElementById('Tel1Error').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}
	

	/* Champ Tel2 - non obligatoire */

	if(Tel2!=""){

		if ((/[^0-9]/.test(Tel2))||(Tel2.length<10)) {
	    	document.getElementById('Tel2Error').innerHTML+="<h4 class='ko'>*<h4>";
		    ErrorField=1;
		}
		
	}

	/* Champ Email */

	if(Email==''){
		Mandatory=0;
		document.getElementById("EmailError").innerHTML+="<h4 class='ko'>*<h4>";
	}
	if (!/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})/.test(Email)&&(Email!="")) {
    	document.getElementById('EmailError').innerHTML+="<h4 class='ko'>*<h4>";
	    ErrorField=1;
	}

	if(Mandatory==0){
		return false;
	}

	if(ErrorField==1){
		return false;
	}

	/* Fin de contrôle des champs */
	
	formData.append('FirstName',FirstName);
	formData.append('LastName',LastName);
	formData.append('CompanyName',CompanyName);
	formData.append('SocialName',SocialName);
	formData.append('RCSNumber',RCSNumber);
	formData.append('Address1',Address1);
	formData.append('Address2',Address2);
	formData.append('CP',CP);
	formData.append('City',City);
	formData.append('Tel1',Tel1);
	formData.append('Tel2',Tel2);
	formData.append('Email',Email);
	
	xhr.onreadystatechange = function() {

		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;

			if(res.Success==0){

				document.getElementById("AccountCreationResult").innerHTML = "";
				document.getElementById("AccountCreationResult").innerHTML = "Le compte est déjà existant";
			}

			if(res.Success==1){

				document.getElementById("AccountCreationResult").innerHTML = "";
				document.getElementById("AccountCreationResult").innerHTML = "Votre compte a bien été créé. Un email avec un lien d'activation vous a été transmis. Merci de cliquer sur ce lien pour activer votre compte";
			}

			if(res.Success==2){

				document.getElementById("AccountCreationResult").innerHTML = "";
				document.getElementById("AccountCreationResult").innerHTML = "Une erreur est survenue pendant la création du compte.";
			}
						 
		} 
		else if (this.readyState == 4) {
				MessageBox.value=("Une erreur est survenue...");
		}
	}

	xhr.open("POST", "/async/NewWorker/CreateWorker.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
	
}