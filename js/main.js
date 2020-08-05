function LoginWorker(){


	var EmailLogin=document.getElementById("EmailLogin").value;
	var MdPLogin=document.getElementById("MdPLogin").value;
	var formData = new FormData();
	formData.append('EmailLogin',EmailLogin);
	formData.append('MdPLogin',MdPLogin);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {

		console.log(this.response);
		var res = this.response;
		
		if (res.Success=="NotValid") {
			document.location.href="NeedToValid.html";
		} 
	
		if (res.Success=="Valid") {
			document.location.href="Index.php?Session="+res.Session+"&Email="+res.Email;
		} 
		
		if (this.response=="KO") {
			alert("Login KO");
		} 
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/Login.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

// ***************************************************************************************************************
// Cette fonction va permettre de récupérer un mot de passe par email
// ***************************************************************************************************************

function IForgot(){

	var Email=document.getElementById("email").value;
	var formData = new FormData();
	formData.append('email',Email);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {

		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			
			if (this.response==0) {
				document.getElementById("result").innerHTML = "<br>L'adresse email entrée ne correspond à aucun compte.<br>";
				//document.location.href="Login.html"
			} 
			if (this.response==1) {
				document.getElementById("result").innerHTML = "<br>Le mot de passe a été transmis à l'adresse indiquée.<br>";
			} 
			if (this.response==2) {
				document.getElementById("result").innerHTML = "<br>Une erreur est survenue pendant le processus.<br>";
			} 
		} 
		else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
		}
	}

	xhr.open("POST", "/async/SendForgottenPassword.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);

	return false;
}


// ***************************************************************************************************************
// Cette fonction va permettre de récupérer les villes en fonctions du numéro de département choisi
// ***************************************************************************************************************

function InitializeFields(){

	GetWorkerActivity();
}

// ***************************************************************************************************************
// Cette fonction va permettre de récupérer les villes en fonctions du numéro de département choisi
// ***************************************************************************************************************

function GetCityList(){

	var xhr = new XMLHttpRequest();
	var DeptNumber=document.getElementById("SelectedDepartment").value;
	var formData = new FormData();
	formData.append('DeptNumber',DeptNumber);
	
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {

		console.log(this.response);
		var res = this.response;
		var SelectedCity="";
		
		if (res.Success==1) {

			for(Counter=0;Counter<res.NbOfCities;Counter++){

				SelectedCity+="<option value='"+res.CityList[Counter]+"'>"+res.CityList[Counter]+"</option>";

			}
			
			document.getElementById("SelectedCity").innerHTML=SelectedCity;
			
		} 

		if (res.Success==0) {

			document.getElementById("SelectedCity").innerHTML="option value='0'>Aucune ville</option";
		} 
	
		
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetCityList.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}

// ***************************************************************************************************************
// Cette fonction va permettre de récupérer la liste des activité enregistrées
// ***************************************************************************************************************


function GetWorkerActivity(){

	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('WorkerActivity','WorkerActivity');
	
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {

		console.log(this.response);
		var res = this.response;
		var SelectedActivity="";
		
		if (res.Success==1) {

			for(Counter=0;Counter<res.NbOfActivities;Counter++){

				SelectedActivity+="<option value='"+res.ActivityList[Counter][0]+"'>"+res.ActivityList[Counter][1]+"</option>";

			}
			
			document.getElementById("SelectedWorkerActivity").innerHTML=SelectedActivity;
			
		} 

		if (res.Success==0) {

			document.getElementById("SelectedWorkerActivity").innerHTML="option value='0'>Aucune activité</option";
		} 
	
		
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetWorkerActivity.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}