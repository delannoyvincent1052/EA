// fonction qui va permettre le logging des actions utilisateurs

function LogAction(Category, Action, Result){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
		
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
		if(res.Success==1){
			MessageBox.value+="Cet élément existe déjà dans le catalogue !!!";
		}
		if(res.Success==2){
			MessageBox.value="Element - '"+ItemName+"' - créé dans le catalogue\r\n";
			ResetFormItem();
			DisplayCatalogFunction();
		}
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
			MessageBox.value=("Une erreur est survenue. Veuillez recommencer l'opération");
		}
//	};
	}

	xhr.open("POST", "/async/LogAction.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	alert("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&Category="+Category+"&Action="+Action+"&Result="+Result);
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&Category="+Category+"&Action="+Action+"&Result="+Result);

}