function HomeSearch(){

	var Department=document.getElementById("SelectedDepartment").value;
	var City=document.getElementById("SelectedCity").value;
	var Activity=document.getElementById("SelectedWorkerActivity").value;

	var formData = new FormData();
	formData.append('Department',Department);
	formData.append('City',City);
	formData.append('Activity',Activity);

	var xhr = new XMLHttpRequest();
	

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		var res=this.response;
		console.log(this.response);
		
		if(res.Success==1){
			
		}
		if(res.Success==0){
			
		}
			 
	} 
	else if (this.readyState == 4) {
			
		}

	}
	xhr.open("POST", "/async/Visitor/HomeSearch.php", true);
	xhr.responseType = "json";
	//xhr.setRequestHeader("Content-type", "multipart/form-data");
	xhr.send(formData);
	
}