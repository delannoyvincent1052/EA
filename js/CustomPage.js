//*******************************************************************
// Cette fonction va permettre de visualiser un template de page perso
//*******************************************************************

function ViewTmplCustomPage(){

	var CustomPageSelection=document.getElementById("TmplCustomPageSelector").value;
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var CustomPageToLoad="TmplCustomPage/"+CustomPageSelection+".php?LoggedUser="+UserEmail+"&UserSession="+UserSession;
	alert(CustomPageToLoad);
	window.open(CustomPageToLoad,"Modèle");
}


function LoadCustomPage(){

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

				document.getElementById("TmplCompanyName").innerHTML=res.BaseInfo[3]+" - "+res.BaseInfo[2];
				document.getElementById("TmplCompanyDescription").innerHTML=res.ActivityDescription;
				document.getElementById("TmplFirstName").innerHTML=res.BaseInfo[0];
				document.getElementById("TmplLastName").innerHTML=res.BaseInfo[1];
				document.getElementById("TmplAddress1").innerHTML=res.BaseInfo[5];
				document.getElementById("TmplAddress2").innerHTML=res.BaseInfo[6];
				document.getElementById("TmplCP").innerHTML=res.BaseInfo[7];
				document.getElementById("TmplCity").innerHTML=res.BaseInfo[8];
				document.getElementById("TmplTel1").innerHTML=res.BaseInfo[10];
				document.getElementById("TmplEmail").innerHTML=res.BaseInfo[11];

				var RealisationList="";

				RealisationList+="<center><table width='1000'>";
				RealisationList+="<tr><td colspan='2'><center><h2>Réalisations</h2></center></td></tr>";

				for(Counter=0;Counter<res.NbOfRealisation;Counter++){

					RealisationList+="<tr><td><h3>"+res.RealisationList[Counter][0]+"</h3><p>"+res.RealisationList[Counter][1]+"</p></td><td><img src='../realisation/RSZ-"+res.RealisationList[Counter][2]+"' class='LogoLogin'></td></tr>";
					
				}				

				RealisationList+="</table></center>";

				document.getElementById("RealisationList").innerHTML=RealisationList;

			}
			if(res.Success==0){

				
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/GetDataCustomPage.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}

//*******************************************************************
// Cette fonction va permettre de générer une page perso
//*******************************************************************

function GenerateCustomPage(){

	var CustomPageTemplate=document.getElementById("TmplCustomPageSelector").value;
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('CustomPageTemplate',CustomPageTemplate)

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;

			if(res.Success==1){

				document.getElementById('CustomPageError').innerHTML+="<h4 class='ok'>Votre page perso a été générée !<h4>";

			}
			if(res.Success==0){

				document.getElementById('CustomPageError').innerHTML+="<h4 class='ko'>Une erreur est survenue pendant la création ou la modification de votre page perso.<h4>";
				
			}
			
						 
	} else if (this.readyState == 4) {
			MessageBox.value=("Une erreur est survenue...");
		}

	}

	xhr.open("POST", "/async/CreateCustomPage.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}