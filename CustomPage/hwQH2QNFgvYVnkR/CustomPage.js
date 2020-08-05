function LoadCustomPage(){

	var UserEmail="jde@devmail.com";
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	
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

					RealisationList+="<tr><td><h3>"+res.RealisationList[Counter][0]+"</h3><p>"+res.RealisationList[Counter][1]+"</p></td><td><img src='../../realisation/RSZ-"+res.RealisationList[Counter][2]+"' class='LogoLogin'></td></tr>";
					
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

	xhr.open("POST", "GetDataCustomPage.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(formData);

	return false;

}