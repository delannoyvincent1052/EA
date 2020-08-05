document.getElementById("Login").addEventListener("submit", function(e) {
	e.preventDefault();

	var data = new FormData(this);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		
			if (this.response=="OK") {
				alert("Login OK");
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
	xhr.send(data);

	return false;
});