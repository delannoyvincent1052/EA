//*******************************************************************************************
// Display Invoices
//*******************************************************************************************

function DisplayInvoicesFunction(){

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
		DisplayProfile.style.display="none";
		DisplayQuotationModification.style.display="none";
		DisplayInvoices.style.display="block";


		if(res.Success==0){

			DisplayExistingInvoices.innerHTML="Aucune facture éditée à ce jour";

		}
		
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetMyInvoices.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
}