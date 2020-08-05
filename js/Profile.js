//*******************************************************************************************
// Display Profile
//*******************************************************************************************

function DisplayProfileFunction(){

	DisplayProfileField();
	document.getElementById("ProfileError").innerHTML="";
	document.getElementById("NewPassword1Error").innerHTML="";
	
	DisplayActualLogo();
	document.getElementById("WorkerLogoError").innerHTML="";

	DisplayActivityDescription();
	document.getElementById("ActivityError").innerHTML="";

	DisplayRealization();
	document.getElementById("RealisationError").innerHTML="";

	DisplayCustomPage();
	document.getElementById("CustomPageError").innerHTML="";

	DisplayActivityCategory();
	RefreshAddedCategory();
	document.getElementById("ActivityCategoryError").innerHTML="";

	RefreshActualRIB();

	DisplayActualSubscription();
	DisplayPaymentSelection("Advanced");
	
	
}

//*******************************************************************************************
// Cette fonction va permettre d'afficher le profil du worker loggué
//*******************************************************************************************

function DisplayProfileField(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		
		console.log(this.response);
		var res = this.response;
		DisplayQuotations.style.display="none";
		DisplayCustomers.style.display="none";
		DisplayCatalog.style.display="none";
		DisplayProfile.style.display="";
		DisplayQuotationModification.style.display="none";
		DisplayInvoices.style.display="none";
		QuotationDetail_ExistingItems.style.display="none";
		DisplayHome.style.display="none";
		
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
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//-------------------------------------------------------------------------------------------
// Script Modification de profil
//-------------------------------------------------------------------------------------------

function ModifyProfile(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var FirstName=document.getElementById("LoadProfileFirstName").value;
	var LastName=document.getElementById("LoadProfileLastName").value;
	var CompanyName=document.getElementById("LoadProfileCompanyName").value;
	var SocialName=document.getElementById("LoadProfileSocialName").value;
	var RCSNumber=document.getElementById("LoadProfileRCSNumber").value;
	var Address1=document.getElementById("LoadProfileAddress1").value;
	var Address2=document.getElementById("LoadProfileAddress2").value;
	var CP=document.getElementById("LoadProfileCP").value;
	var City=document.getElementById("LoadProfileCity").value;
	var Tel1=document.getElementById("LoadProfileTel1").value;
	var Tel2=document.getElementById("LoadProfileTel2").value;
	var Email=document.getElementById("LoadProfileEmail").value;
	var ErrorField=0;

	// Contrôle initial des champs

	document.getElementById('ProfileError').innerHTML="";

	if(FirstName==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le prénom ne peut être vide !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Zéè\- ]/.test(FirstName)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le prénom ne peut contenir que des lettres !<h4>"
	    ErrorField=1;
	}
	if(LastName==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le nom ne peut être vide !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Zéè\- ]/.test(LastName)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le nom ne peut contenir que des lettres !<h4>"
	    ErrorField=1;
	}
	if(CompanyName==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le nom d'Entreprise ne peut être vide !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Z0-9éè\- ]/.test(CompanyName)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le nom d'Entreprise ne peut contenir que des lettres et des chiffres !<h4>"
	    ErrorField=1;
	}
	if(SocialName==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le rasion sociale ne peut être vide !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Z]/.test(SocialName)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le raison sociale ne peut contenir que des lettres !<h4>"
	    ErrorField=1;
	}
	if(Address1==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Une adresse doit être indiquée !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Z0-9éè\-,. ]/.test(Address1)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>L'adresse ne doit contenir que des lettres et des chiffres !<h4>"
	    ErrorField=1;
	}
	if(CP==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le code postal doit être indiquée !<h4>";
		ErrorField=1;
	}
	if (/[^0-9]/.test(CP)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le code postal ne doit contenir que des chiffres !<h4>"
	    ErrorField=1;
	}
	if(CP.length!=5){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Le code postal doit être composé de 5 chiffres !<h4>";
		ErrorField=1;
	}
	if(City==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>La ville doit être indiquée !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Zéè\-,. ]/.test(City)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>La ville ne doit contenir que des lettres !<h4>"
	    ErrorField=1;
	}
	if(Email==""){
		document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Une adresse email valide doit être indiquée !<h4>";
		ErrorField=1;
	}
	if (!/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})/.test(Email)) {
    	document.getElementById('ProfileError').innerHTML+="<h4 class='ko'>Ceci n'est pas une adresse email valide !<h4>";
	    ErrorField=1;
	}

	if(ErrorField==1){
		return false;
	}


	//fin du contrôle des champs

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
					
			if (res.Success==1) {
				MessageBox.value="Votre profil a bien été modifié !!!";
				DisplayProfileFunction;
				document.getElementById('ProfileError').innerHTML+="<h4 class='ok'>Votre profil a bien été modifié !<h4>";

			} 
			if (res.Success==0) {
				MessageBox.value="Une erreur est survenue pendant la modification du profil";
			} 
			 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/ModificationOfAWorker.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&FirstName="+FirstName+"&LastName="+LastName+"&CompanyName="+CompanyName+"&SocialName="+SocialName+"&RCSNumber="+RCSNumber+"&Address1="+Address1+"&Address2="+Address2+"&CP="+CP+"&City="+City+"&Tel1="+Tel1+"&Tel2="+Tel2+"&Email="+Email);


	return false;

}

/***********************************************************************************/
/* Cette fonction va permettre à l'utilisateur de changer son mot de passe         */
/***********************************************************************************/

function ChangePassword(){
	
	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var Password1=document.getElementById("NewPassword1").value;
	var Password2=document.getElementById("NewPassword2").value;
	var ErrorField=0;

	// Contrôle initial des champs

	if(Password1==""){
		document.getElementById('NewPassword1Error').innerHTML="<h4 class='ko'>Le mot de passe ne peut être vide !<h4>";
		ErrorField=1;
	}
	if(Password2==""){
		document.getElementById('NewPassword1Error').innerHTML="<h4 class='ko'>Le mot de passe ne peut être vide !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Z0-9]/.test(Password1)) {
    	document.getElementById('NewPassword1Error').innerHTML="<h4 class='ko'>Le mot de passe ne peut contenir que des lettres et des chiffres !<h4>"
	    ErrorField=1;
	}
	if (/[^a-zA-Z0-9]/.test(Password2)) {
    	document.getElementById('NewPassword1Error').innerHTML="<h4 class='ko'>Le mot de passe ne peut contenir que des lettres et des chiffres !<h4>"
	    ErrorField=1;
	}
	if(Password1.length<8){
		document.getElementById('NewPassword1Error').innerHTML="<h4 class='ko'>Le mot de passe doit être au minimum de 8 caractères !<h4>"
	    ErrorField=1;
	}
	if(Password2.length<8){
		document.getElementById('NewPassword1Error').innerHTML="<h4 class='ko'>Le mot de passe doit être au minimum de 8 caractères !<h4>"
	    ErrorField=1;
	}
	if(Password1!=Password2){
		document.getElementById('NewPassword1Error').innerHTML="<h4 class='ko'>Les mots de passe entrés ne correspondent pas !<h4>";
		ErrorField=1;
	}
	if(ErrorField==1){
		return false;
	}

	// Fin du contrôle des champs


	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
					
			if (res.Success==1) {
				MessageBox.value="Votre mot de passe a bien été modifié !!!";
				DisplayProfileFunction();
				document.getElementById('NewPassword1Error').innerHTML="<h4 class='ok'>Le mot de passe a bien été modifié<h4>";
			} 
			if (res.Success==0) {
				MessageBox.value="Une erreur est survenue pendant la modification du profil";
			} 
			if (res.Success==2) {
				MessageBox.value="Les mots de passe entrés ne correspondent pas";
			} 
			 
	} else if (this.readyState == 4) {
			Messagebox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/ChangePassword.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&Password1="+Password1+"&Password2="+Password2);


	return false;
}


/************************************************************************************/
/* Cette fonction va permettre d'uploader le logo du worker en question             */
/************************************************************************************/

function UploadLogo(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	var fileInput = document.getElementById('WorkerLogo');
	var file = fileInput.files[0];
	var formData = new FormData();
	formData.append('file', file);
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);


	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		var res=this.response;
		console.log(this.response);
		
		if(res.Success==1){
			MessageBox.value="Votre logo a bien été téléchargé sur le serveur.";
			DisplayProfileFunction();
			document.getElementById("WorkerLogoError").innerHTML="<h4 class='ok'>Votre logo a bien été chargé sur le serveur.</h4>";

		}
		if(res.Success==0){
			MessageBox.value="Une erreur est survenue pendant l'upload de votre logo. Veuillez recommencer.";
			document.getElementById("WorkerLogoError").innerHTML="<h4 class='ko'>Une erreur est survenue, veuillez recommencer.</h4>";

		}
			 
	} 
	else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}
	xhr.open("POST", "/async/UploadLogo.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "multipart/form-data");
	xhr.send(formData);

}

/**************************************************************************************/
/* Cette fonction va permettre d'uploader la description de l'activité sur le serveur */
/**************************************************************************************/

function DisplayActivityDescription(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
					
			if (res.Description!="") {
				var ActivityDescription=res.Description.replace("-APO-","'");
				ActivityDescription=ActivityDescription.replace("-APOO-",'"');
				document.getElementById("MyActivity").value=ActivityDescription;
			} 
						 
	} else if (this.readyState == 4) {
			Messagebox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetActivityDescription", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
	
}

//*****************************************************************************************
//* Cette fonction va permettre de faire apparaitre le logo actuellement uploadé
//*****************************************************************************************

function DisplayActualLogo(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				if(res.LogoName!="") {
					var LogoImage="logoRD-"+UserEmail+".jpg";
					document.getElementById("ActualLogo").innerHTML="<img src='logos/"+LogoImage+"' class='LogoLogin' />";
				} 

				if(res.LogoName==""){
					document.getElementById("ActualLogo").innerHTML="Aucun logo actuellement chargé";
				}

			}
			
						 
	} else if (this.readyState == 4) {
			Messagebox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetActualLogo.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//*****************************************************************************************
//* Cette fonction va permettre d'afficher les réalisations uploadées
//*****************************************************************************************

function DisplayRealization(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var ActivityDescription=

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				document.getElementById("RealisationList").innerHTML="";
				var CodeRealisation="<center><table><thead><tr><th width='200'>Titre</th><th width='300'>Description</th>";
				var Counter=0;

				for(Counter=0;Counter<res.NbOfRealisation;Counter++){

					CodeRealisation+="<tr><td>"+res.Realisation[Counter][1]+"</td><td>"+res.Realisation[Counter][2]+"</td><td><center><input type='button' value='Visualiser' onclick='ViewRealisation("+res.Realisation[Counter][0]+")'</center></td><td><center><input type='button' value='Supprimer' onclick='DeleteRealisation("+res.Realisation[Counter][0]+")'</center></td></tr>";

				}

				CodeRealisation+="<thead></table></center>";
				document.getElementById("RealisationList").innerHTML=CodeRealisation;

			}
			
						 
	} else if (this.readyState == 4) {
			Messagebox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetRealisation.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
}

//*****************************************************************************************
//* Cette fonction va permettre d'enregistrer le texte de la description d'activité
//*****************************************************************************************

function SetActivityDescription(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var ActivityDescription=document.getElementById("MyActivity").value;
	ActivityDescription=ActivityDescription.replace("'","-APO-");
	ActivityDescription=ActivityDescription.replace('"',"-APOO-");
	var ErrorField=0;

		// Traintement des champs Input
	
	if(ActivityDescription==""){
		document.getElementById('ActivityError').innerHTML="<h4 class='ko'>Le texte de description ne peut être vide !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Z0-9_:.éèêàïîëùâ\- ]/.test(ActivityDescription)) {
    	document.getElementById('ActivityError').innerHTML="<h4 class='ko'>Votre texte ne peut contenir que des lettres et des chiffres !<h4>"
	    ErrorField=1;
	}
	
	if(ErrorField==1){
		return false;
	}

	// fin de traitement des champs Input

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				MessageBox.value="La description d'activité a bien été enregistrée."
				DisplayProfileFunction();
				document.getElementById("ActivityError").innerHTML="<h4 class='ok'>Modifications enregistrées.</h4>"

			}
			if(res.Success==0){

				MessageBox.value="Une erreur est survenue pendant l'enregistrement de la description d'activité."

			}
			
						 
	} else if (this.readyState == 4) {
			Messagebox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/SetActivityDescription.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&ActivityDescription="+ActivityDescription);

	return false;

}

// ****************************************************************************************
// * Cette fonction va permettre d'ajouter une réalisation
// ****************************************************************************************

function AddRealisation(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var RealisationTitle=document.getElementById("RealisationTitle").value;
	RealisationTitle=RealisationTitle.replace("-APO-","'");
	RealisationTitle=RealisationTitle.replace("-APOO-",'"');
	var RealisationDescription=document.getElementById("RealisationDescription").value;
	RealisationDescription=RealisationDescription.replace("-APO-","'");
	RealisationDescription=RealisationDescription.replace("-APOO-",'"');
	var fileInput = document.getElementById('RealisationPicture');
	var ErrorField=0;

	// Traintement des champs Input

	document.getElementById('RealisationError').innerHTML="";
	
	if(RealisationTitle==""){
		document.getElementById('RealisationError').innerHTML+="<h4 class='ko'>Le titre de la réalisation ne peut être vide !<h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Z0-9_:.-éèêàïîëùâ ]/.test(RealisationTitle)) {
    	document.getElementById('RealisationError').innerHTML+="<h4 class='ko'>Le titre ne peut contenir que des lettres et des chiffres !<h4>"
	    ErrorField=1;
	}
	alert(RealisationDescription);
	if(RealisationDescription==""){
		document.getElementById('RealisationError').innerHTML+="<h4 class='ko'>La description de la réalisation ne peut être vide !</h4>";
		ErrorField=1;
	}
	if (/[^a-zA-Z0-9_:.-éèêàïîëùâû, ]/.test(RealisationDescription)) {
    	document.getElementById('RealisationError').innerHTML+="<h4 class='ko'>La description ne peut contenir que des lettres et des chiffres !<h4>"
	    ErrorField=1;
	}
	if(!fileInput.files[0]){
		document.getElementById('RealisationError').innerHTML+="<h4 class='ko'>Une photo doit être sélectionnée !</h4>";
		ErrorField=1;
	}
	if(ErrorField==1){
		return false;
	}

	// fin de traitement des champs Input
	

	var file = fileInput.files[0];
	var formData = new FormData();
	formData.append('file', file);
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('RealisationTitle',RealisationTitle);
	formData.append('RealisationDescription',RealisationDescription);


	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				MessageBox.value="La réalisation a bien été enregistrée."
				DisplayProfileFunction();
				document.getElementById('RealisationError').innerHTML="<h4 class='ok'>Réalisation enregistrée.</h4>";


			}
			if(res.Success==0){

				MessageBox.value="Une erreur est survenue pendant l'enregistrement de la réalisation."

			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/AddRealisation.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}

/***************************************************************************************/
/* Fonction qui permet de visualiser une réalisation */
/***************************************************************************************/

function ViewRealisation(ID){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('IDRealisation', ID);
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				document.getElementById("RealisationDetail").innerHTML="";
				var RealisationDetail="";
				RealisationDetail="<br><center><table class='TableListe'>";
				RealisationDetail+="<tr class='THListe'><td width='150' style='text-align: right' class='TDListe'>Titre : </td><td>"+res.Title+"</td></tr>";
				RealisationDetail+="<tr class='THListe'><td width='150' style='text-align: right' class='TDListe'>Description : </td><td>"+res.Description+"</td></tr>";
				RealisationDetail+="<tr class='THListe'><td width='150' style='text-align: right' class='TDListe'>Photo : </td><td><img src='realisation/"+res.Picture+"' class='LogoLogin' /></td></tr>";
				RealisationDetail+="</table></center>";
				document.getElementById("RealisationDetail").innerHTML=RealisationDetail;
				
			}
			if(res.Success==0){

				
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/ViewRealisation.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

/***************************************************************************************/
/* Cette fonction va permettre de supprimer une réalisation précédemment enregistrée   */
/***************************************************************************************/

function DeleteRealisation(ID){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('IDRealisation', ID);
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				MessageBox.value="La réalisation a bien été supprimée.";
				DisplayRealization();
				
			}
			if(res.Success==0){

				MessageBox.value="Une erreur est survenue pendant la suppression de la réalisation.";
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/DeleteRealisation.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;


}

//*********************************************************************************
// Cette fonction va permettre d'afficher le lien de la page perso par défaut
//*********************************************************************************

function DisplayCustomPage(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				document.getElementById("ActualCustomPage").innerHTML="<a href='http://eartisan/CustomPage/"+res.CustomPageDir+"/index.php' target='blanck'>http://eartisan/CustomPage/"+res.CustomPageDir+"/index.php</a>";
				
			}
			if(res.Success==0){

				document.getElementById("ActualCustomPage").innerHTML="La page perso n'a pas encore été définie.";
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetCustomPageLink.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}

//******************************************************************************************
// Cette fonction va permettre d'afficher la liste des catégories d'activité pour un worker
//******************************************************************************************

function DisplayActivityCategory(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
	
		var SelectActivityCategoryList="";

			if(res.Success==1){

				var counter=0;

				SelectActivityCategoryList="<select id='SelectActivityCategoryList'>";
				for(counter=0;counter<res.NbOfActivityCategory;counter++){


					SelectActivityCategoryList+="<option value='"+res.ActivityCategoryList[counter][0]+"'>"+res.ActivityCategoryList[counter][1]+"</option>";
					
				}
					
				SelectActivityCategoryList+="</select>";
				document.getElementById('ActivityCategoryList').innerHTML=SelectActivityCategoryList;
				
			}
			if(res.Success==0){

			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetActivityCategoryList.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

// Cette fonction va permettre d'ajouter une catégorie

function AddActivityCategory(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var SelectedActivityCategory=document.getElementById("SelectActivityCategoryList").value;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('ActivityCategory', SelectedActivityCategory);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
	
		var SelectActivityCategoryList="";

			if(res.Success==0){

				document.getElementById("ActivityCategoryError").innerHTML="<h4 class='ko'>Une erreur est survenue pendant l'ajout de l'activité<h4>";
			
			}
			if(res.Success==1){

				document.getElementById("ActivityCategoryError").innerHTML="<h4 class='ok'>L'activité a bien été associée !<h4>";
				RefreshAddedCategory();
			
			}
			if(res.Success==2){

				document.getElementById("ActivityCategoryError").innerHTML="<h4 class='ko'>L'activité pointée est déjà associée au profil ! <h4>";
			
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/AddActivityToProfile.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

// Cette fonction va permettre de raffraichir la liste des catégories ajoutées

function RefreshAddedCategory(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
	
		var SelectActivityCategoryList="";

			if(res.Success==0){
				document.getElementById("ActualActivityCategory").innerHTML="<h4 class='ko'>Actuellement aucune activité associée.<h4>";
		
			}
			if(res.Success==1){

				for(Counter=0;Counter<res.NbOfActivityAssociated;Counter++){

					SelectActivityCategoryList+="<div id='"+res.ActivityList[Counter+1][0]+"' style='color: #005497'>"+res.ActivityList[Counter+1][1]+" - <a href='#' onclick=DeleteAssociatedActivityCaterogy("+res.ActivityList[Counter+1][0]+")>Supprimer</a></div>";
				}
				document.getElementById("ActualActivityCategory").innerHTML=SelectActivityCategoryList;
							
			}
						
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetActivityToProfile.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

// Cette fonction va permettre de supprimer un type d'activité associé au profil du worker

function DeleteAssociatedActivityCaterogy(ActivityCategoryID){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('ActivityCategoryID', ActivityCategoryID);

	xhr.onreadystatechange = function() {
	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;
		
			var SelectActivityCategoryList="";

			if(res.Success==0){
				
				document.getElementById("ActivityCategoryError").innerHTML="<h4 class='ko'>Une erreur est survenue pendant la suppression.<h4>";
			}
			if(res.Success==1){

				RefreshAddedCategory();
				document.getElementById("ActivityCategoryError").innerHTML="<h4 class='ok'>La suppression a été effectuée.<h4>";
				
			}
											 
		} 
		else if (this.readyState == 4) {
				MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/DeleteActivityToProfile.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

// Cette fonction va permettre d'enregistrer les données sur un RIB

function RIBRegistration(){

	var RIBName=document.getElementById("RIBName").value;
	var RIBFirstName=document.getElementById("RIBFirstName").value;
	var RIBLastName=document.getElementById("RIBLastName").value;
	var RIBBankName=document.getElementById("RIBBankName").value;
	var RIBBankCode=document.getElementById("RIBBankCode").value;
	var RIBGuichetCode=document.getElementById("RIBGuichetCode").value;
	var RIBAccountNumber=document.getElementById("RIBAccountNumber").value;
	var RIBAccountKey=document.getElementById("RIBAccountKey").value;
	var RIBIBAN=document.getElementById("RIBIBAN").value;
	var RIBSWIFT=document.getElementById("RIBSWIFT").value;

	var ErrorField=0;

	// Contrôle des champs

	if((RIBName=="")||(/[^a-zA-Z0-9_:.-éèêàïîëùâ ]/.test(RIBName))){
		document.getElementById('RIBNameError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBFirstName=="")||(/[^a-zA-Z0-9-éèêàïîëùâ ]/.test(RIBFirstName))){
		document.getElementById('RIBFirstNameError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBLastName=="")||(/[^a-zA-Z0-9-éèêàïîëùâ ]/.test(RIBLastName))){
		document.getElementById('RIBLastNameError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBBankCode=="")||(/[^0-9]/.test(RIBBankCode))){
		document.getElementById('RIBBanckCodeError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBGuichetCode=="")||(/[^0-9]/.test(RIBGuichetCode))){
		document.getElementById('RIBGuichetCodeError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBAccountNumber=="")||(/[^0-9]/.test(RIBAccountNumber))){
		document.getElementById('RIBAccountNumberError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBAccountKey=="")||(/[^0-9]/.test(RIBAccountKey))){
		document.getElementById('RIBAccountKeyError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBIBAN=="")||(/[^0-9]/.test(RIBIBAN))){
		document.getElementById('RIBIBANError').innerHTML+="*";
		ErrorField=1;
	}
	if((RIBSWIFT=="")||(/[^0-9]/.test(RIBSWIFT))){
		document.getElementById('RIBSWIFTError').innerHTML+="*";
		ErrorField=1;
	}

	if(ErrorField==1){

		return false;

	}

	// Fin de contrôle des champs

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('RIBName', RIBName);
	formData.append('RIBFirstName',RIBFirstName);
	formData.append('RIBLastName',RIBLastName);
	formData.append('RIBBankName',RIBBankName);
	formData.append('RIBBankCode',RIBBankCode);
	formData.append('RIBGuichetCode',RIBGuichetCode);
	formData.append('RIBAccountNumber',RIBAccountNumber);
	formData.append('RIBAccountKey',RIBAccountKey);
	formData.append('RIBIBAN',RIBIBAN);
	formData.append('RIBSWIFT',RIBSWIFT);

	xhr.onreadystatechange = function() {
	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;
		
			if(res.Success==0){
				
			}
			if(res.Success==1){

			}
											 
		} 
		else if (this.readyState == 4) {
				MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/UpdateRIB.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;


}

// Cette fonction va permettre d'afficher le RIB actuellement enregistré dans la div ACTUALRIB

function RefreshActualRIB(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				document.getElementById("RIBName").value=res.RIBName;
				document.getElementById("RIBFirstName").value=res.RIBFirstName;
				document.getElementById("RIBLastName").value=res.RIBLastName;
				document.getElementById("RIBBankName").value=res.RIBBankName;
				document.getElementById("RIBBankCode").value=res.RIBBankCode;
				document.getElementById("RIBGuichetCode").value=res.RIBGuichetCode;
				document.getElementById('RIBAccountNumber').value=res.RIBAccountNumber;
				document.getElementById("RIBAccountKey").value=res.RIBAccountKey;
				document.getElementById("RIBIBAN").value=res.RIBIBAN;
				document.getElementById("RIBSWIFT").value=res.RIBSWIFT;
				
			}
			if(res.Success==0){

				document.getElementById("ActualRIB").innerHTML="Aucun RIB enregistré";
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetActualRIB.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}

function SubscriptionValidation(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var SubscriptionType="";
	if(document.getElementById("Basic").checked){
		SubscriptionType=document.getElementById("Basic").value;
	}
	if(document.getElementById("Advanced").checked){
		SubscriptionType=document.getElementById("Advanced").value;
	}
	var PaymentPeriod=document.getElementById("PaymentPeriod").value

	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('SubscriptionType',SubscriptionType);
	formData.append('PaymentPeriod', PaymentPeriod);
	formData.append('PaymentDate',10);


	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				document.getElementById("ActualSubscription").innerHTML="Votre abonnement a bien été enregistré. Merci de votre confiance.";				
			}
			if(res.Success==0){

				document.getElementById("ActualSubscription").innerHTML="Une erreur est survenue pendant l'enregistrement de votre abonnement. Veuillez recommencer.";
				
			}
			if(res.Success==2){

				document.getElementById("ActualSubscription").innerHTML="Pour modifier un abonnement existant, veuillez cliquer ICI";
				
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/SubscriptionValidation.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}

/* Cette fonction va permettre d'afficher l'abonnement actuel */

function DisplayActualSubscription(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				document.getElementById("ActualSubscription").innerHTML="Abonnement en cours";
								
			}
			if(res.Success==0){

				document.getElementById("ActualSubscription").innerHTML="Vous n'avez pas encore validé votre abonnement.";

			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetActualSubscription.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}

/* Cette fonction va permettre de modifier la boite de sélection d'abonnement PaymentSelection */

function DisplayPaymentSelection(TypeSubscription){


	if (TypeSubscription=="Basic"){

		var PaymentPeriod="";
		PaymentPeriod+="<select id='PaymentPeriod'>";
		PaymentPeriod+="<option value='1'>Paiement 1 an : 40€ / Economisez 8 euros sur l'année !</option>";
		PaymentPeriod+="<option value='2'>Paiement mensuel : 4€ / Prélèvement de 10 du mois</option>";
		PaymentPeriod+="</select>";
		document.getElementById("PaymentSelection").innerHTML=PaymentPeriod;

	}

	if (TypeSubscription=="Advanced"){

		var PaymentPeriod="";
		PaymentPeriod+="<select id='PaymentPeriod'>";
		PaymentPeriod+="<option value='3'>Paiement 1 an : 100€ / Economisez 20 euros sur l'année !</option>";
		PaymentPeriod+="<option value='4'>Paiement mensuel : 10€ / Prélèvement de 10 du mois</option>";
		PaymentPeriod+="</select>";
		document.getElementById("PaymentSelection").innerHTML=PaymentPeriod;
									
		
	}

}