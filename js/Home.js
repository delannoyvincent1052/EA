function DisplayHomeFunction(){

	DisplayInvoices.style.display="none";
	DisplayQuotations.style.display="none";
	DisplayCatalog.style.display="none";
	DisplayProfile.style.display="none";
	DisplayQuotationModification.style.display="none";
	QuotationDetail_ExistingItems.style.display="none";
	DisplayCustomers.style.display="none";
	DisplayHome.style.display="block";
	alert("coucou2");
	RefreshEartInvoice();
	RefreshServiceCost();
	RefreshQuotationNumber();
	
}

function RefreshEartInvoice(){

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

				var CreationYear=res.CreationYear;
				var CreationMonth=res.CreationMonth;
				var CreationDay=res.CreationDay;
				document.getElementById("ServiceActivationDate").innerHTML="Compte actif depuis le : "+CreationDay+"-"+CreationMonth+"-"+CreationYear;
							
			}
			if(res.Success==0){

				
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/home/RefreshEartInvoice.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

/*****************************************************************************************************************/
/* Cette fonction va permettre de raffraichir le champ ServiceCost (coût du service EART) */
/*****************************************************************************************************************/

function RefreshServiceCost(){

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

											
			}
			if(res.Success==0){

				
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/home/RefreshServiceCost.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}

/*****************************************************************************************************************/
/* Cette fonction va permettre de raffraichir le champ QuotationNumber (Nombre de devis en cours)                */
/*****************************************************************************************************************/

function RefreshQuotationNumber(){

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

				document.getElementById("NbOfOpenQuotations").innerHTML="Nb de devis ouverts : "+res.NbOfOpenQuotations;
											
			}
			if(res.Success==0){

				
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/home/RefreshQuotationNumber.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;
}


