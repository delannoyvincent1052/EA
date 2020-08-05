//**************************************************************************************************************
// Fonction pour ajouter un élément dans le catalogue
//**************************************************************************************************************

function CreateNewCatalogElement(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var ItemName=document.getElementById("LoadItemName").value;
	var ItemDescription=document.getElementById("LoadItemDescription").value;
	var ItemPrice=document.getElementById("LoadItemPrice").value;
	var ItemUnit=document.getElementById("LoadItemUnit").value;
	var ItemBuyingPrice=document.getElementById("LoadItemBuyingPrice").value;

	alert (ItemBuyingPrice);

	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('ItemName',ItemName);
	formData.append('ItemDescription',ItemDescription);
	formData.append('ItemPrice',ItemPrice);
	formData.append('ItemUnit',ItemUnit);
	formData.append('ItemBuyingPrice',ItemBuyingPrice);
	
	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
		if(res.Success==1){
			
		}
		if(res.Success==2){
			
			ResetFormItem();
			DisplayCatalogFunction();
		}
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
			MessageBox.value=("Une erreur est survenue. Veuillez recommencer l'opération");
		}
//	};
	}

	xhr.open("POST", "/async/CreationOfNewCatalogElement.php", true);
	xhr.responseType = "json";
	/*xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");*/
	xhr.send(formData);

}

//**************************************************************************************************************
// Fonction pour mettre à jour le formulaire d'entrée des nouveaux éléments
//**************************************************************************************************************

function ResetFormItem(){

	LoadItemName.value="";
	LoadItemDescription.value="";
	LoadItemPrice.value="";
	LoadItemUnit.value="";
	LoadItemBuyingPrice.value="";

}

//**************************************************************************************************************
// Fonction pour supprimer un item existant dans le catalogue
//**************************************************************************************************************

function DeleteItem(counter){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
			var res = this.response;
			console.log(res.Success);
			DisplayCatalogFunction();

			if(res.Success==1){
				
			}
			if(res.Success==0){
				
			}
			
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue. Veuillez recommencer l'opération");
		}
//	};
	}

	xhr.open("POST", "/async/DeleteSelectedCatalogItem.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&ItemID="+counter);
	
}

//**************************************************************************************************************
// Fonction pour modifier un item existant dans le catalogue
//**************************************************************************************************************

function ModifyItem(counter){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
		
		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
				var res = this.response;
				console.log(res);
				document.getElementById("LoadItemName").value=res.ItemName;
				document.getElementById("LoadItemDescription").value=res.ItemDescription;
				document.getElementById("LoadItemPrice").value=res.ItemPrice;
				document.getElementById("LoadItemUnit").value=res.ItemUnit;
				document.getElementById("LoadItemID").value=res.ItemID;
				document.getElementById("LoadItemBuyingPrice").value=res.ItemBuyingPrice;
				DisplayCatalogFunction();
				

		} 
		else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
				
		}
	
	}

	xhr.open("POST", "/async/GetCatalogItemToModify.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&ItemID="+counter);
	
}

//**************************************************************************************************************
// Fonction qui permet de mettre à jour un item existant dans le catalogue
//**************************************************************************************************************

function UpdateSelectedItem(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var ItemID=document.getElementById("LoadItemID").value;
	var ItemName=document.getElementById("LoadItemName").value;
	var ItemDescription=document.getElementById("LoadItemDescription").value;
	var ItemPrice=document.getElementById("LoadItemPrice").value;
	var ItemUnit=document.getElementById("LoadItemUnit").value;
	var ItemBuyingPrice=document.getElementById("LoadItemBuyingPrice").value;

	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('ItemID',ItemID);
	formData.append('ItemName',ItemName);
	formData.append('ItemDescription',ItemDescription);
	formData.append('ItemPrice',ItemPrice);
	formData.append('ItemUnit',ItemUnit);
	formData.append('ItemBuyingPrice',ItemBuyingPrice);

	xhr.onreadystatechange = function() {
		
		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;
			console.log(res.Success);
			if(res.Success==1){
				
			}
			if(res.Success==0){
				
			}
			DisplayCatalogFunction();

		} 
		else if (this.readyState == 4) {
				alert("Une erreur est survenue. Veuillez recommencer l'opération");
		}
	
	}

	xhr.open("POST", "/async/UpdateSelectedItem.php", true);
	xhr.responseType = "json";
	/*xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");*/
	xhr.send(formData);
	
}

//**************************************************************************************************************
// Fonction qui permet d'ajouter une catégorie
//**************************************************************************************************************

function CreateCategory(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var CategoryName=document.getElementById("LoadCategoryName").value;

	xhr.onreadystatechange = function() {
		
		console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
				var res = this.response;
				console.log(res.Success);

				if (res.Success==0) {
					
				}
				if (res.Success==1) {
					
				}
				if (res.Success==2) {
					/*var CategoryName=document.getElementById("LoadCategoryName").value;
					MessageBox.value="La catégorie - "+CategoryName+" - a bien été créee.";*/
					DisplayCatalogFunction();
					/*LoadCategoryName.value="";*/
				}
				if (res.Success==3) {
					alert("La création de la catégorie a échoué. Veuillez recommencer.");
				}
							

		} 
		else if (this.readyState == 4) {
				MessageBox.value="Une erreur est survenue. Veuillez recommencer l'opération";
		}
	
	}

	xhr.open("POST", "/async/CreateCategory.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("CategoryName="+CategoryName+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);
}

//**************************************************************************************************
// Cette fonction va permettre d'afficher le catalogue
//**************************************************************************************************

function DisplayCatalogFunction(){



	DisplayCatalogItem();
	DisplayCategories();

}

//**************************************************************************************************
// Cette fonction va permettre d'afficher le catalogue des éléments connus
//**************************************************************************************************

function DisplayCatalogItem(){

	var xhr = new XMLHttpRequest();
	UserEmail=document.getElementById("LoggedUser").innerHTML;
	UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
			var res = this.response;
		
			if (res.Success) {
				console.log("success");
				
				DisplayQuotations.style.display="none";
				DisplayProfile.style.display="none";
				DisplayCustomers.style.display="none";
				DisplayQuotationModification.style.display="none";
				DisplayCatalog.style.display="block";
				QuotationDetail_ExistingItems.style.display="none";
				DisplayInvoices.style.display="none";

				var ItemList="";
				ItemList+="<center><table><thead>";
				ItemList+="<tr><th>Nom</th><th>Description</th><th>Prix</th><th>Unité</th><th></th><th></th></td>";
				var Parameter="";

				for(counter=0;counter<res.NumberOfItems;counter++){

					ItemList+="<tr><td>"+res.Items[counter][1]+"</td><td>"+res.Items[counter][2]+"</td><td>"+res.Items[counter][3]+"€</td><td>"+res.Items[counter][4]+"</td><td><input type='button' name='DeleteItem' value='Supprimer' onclick='DeleteItem("+res.Items[counter][0]+")'></td><td><input type='button' name='ModifyItem' value='Modifier' onclick='ModifyItem("+res.Items[counter][0]+")'></td></div></tr>";	
				}

				ItemList+="</table></center>";

				DisplayCatalogItems.innerHTML=ItemList;
													
			} 

	} else if (this.readyState == 4) {
			MessageBox.value="Une erreur est survenue. Veuillez recommencer l'opération";
		}
//	};
	}

	xhr.open("POST", "/async/GetCatalogItem.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//**************************************************************************************************
// Cette fonction va permettre d'afficher les catégories créées
//**************************************************************************************************

function DisplayCategories(){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
			var res = this.response;
		
			if (res.Success) {
				console.log("success");
				

				var CategoryList="<center><table><thead><tr><th colspan='6'>Mes catégories</th></tr>";
				var Parameter="";

				for(counter=0;counter<res.NumberOfCategories;counter++){

					CategoryList+="<tr><td><div style='text-align: center'>"+res.Categories[counter][1]+"</div></td><td><div style='text-align: center'><input type='button' name='DeleteItem' value='Supprimer' onclick='DeleteCategory("+res.Categories[counter][0]+")'></div></td></tr>";	
				}

				CategoryList+="</table></center>";

				DisplayExistingCategories.innerHTML=CategoryList;
													
			} 

	} else if (this.readyState == 4) {
			MessageBox.value="Une erreur est survenue. Veuillez recommencer l'opération";
		}
//	};
	}

	xhr.open("POST", "/async/GetCategoriesList.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

/********************************************************************************************/
/* Cette fonction va permettre de supprimer une categorie                                   */
/********************************************************************************************/

function DeleteCategory(CategoryID){

	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		console.log(this.response);
		var res = this.response;
	
		if (res.Success==1){
			
			DisplayCatalogFunction();
															
		} 
		if (res.Success==0){
			
			DisplayCatalogFunction();
																
		} 

	} else if (this.readyState == 4) {
			alert("Une erreur est survenue. Veuillez recommencer l'opération.");
		}
//	};
	}

	xhr.open("POST", "/async/DeleteCategory.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession+"&CategoryID="+CategoryID);

	return false;


}
