//*******************************************************************
// Cette fonction permet d'afficher les détails pour le devis pointé
//*******************************************************************

var IsQuotationRegistered=0;

function DisplayQuotationDetail(counter)
{
	DisplayQuotations.style.display="none";
	DisplayCatalog.style.display="none";
	DisplayProfile.style.display="none";
	DisplayCustomers.style.display="none";
	DisplayQuotationModification.style.display="block";

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {

	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;
			console.log(res.Success);


			LoadQuotationNameDetail.value=res.QuotationName;
			
			LoadQuotationCustomerName.value=res.CustomerName;

			var CategoryList='<select id=\'QuotationDetail_GlobalCategoryList\'>';

			for(Counter=0;Counter<res.TotalNumberOfCategories;Counter++){

				CategoryList+='<option value='+res.TotalCategoryList[Counter][0]+'>'+res.TotalCategoryList[Counter][1]+'</option>';

			}

			CategoryList+='</select>';

			var GlobalItemList='<select id=\'QuotationDetail_GlobalItemList\'>';

			for(Counter=0;Counter<res.GlobalItemList.length;Counter++){

				GlobalItemList+='<option value='+res.GlobalItemList[Counter][0]+'>'+res.GlobalItemList[Counter][1]+'</option>';

			}

			GlobalItemList+='</select>';			


			QuotationDetail_ListOfCategories.innerHTML=CategoryList;
			QuotationDetail_ListOfItems.innerHTML=GlobalItemList;

			// Affichage des différentes version d'une quotation

			LoadQuotationVersion(counter);

			RefreshQuotationDetail(counter)

								 
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
	}

	xhr.open("POST", "/async/GetQuotationDetail.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("QuotationID="+counter+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;


}



//*******************************************************************
// Cette fonction permet de supprimer le devis sélectionné
//*******************************************************************

function DeleteSelectedQuotation(counter)
{
 	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;
						
				if (res.Success==0) {
					alert("Une erreur est survenue pendant la suppression du devis.");
				}
				if (res.Success==1) {
					DisplayQuotationsFunction();
				}
				
				 
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/DeleteQuotation.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("QuotationID="+counter+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//*******************************************************************
// Fonction pour récupérer la liste des clients potentiels
//*******************************************************************

function CreateQuotation(){

	var QuotationName=document.getElementById("LoadQuotationName").value;
	var e = document.getElementById("QuotationCustomerList").selectedIndex;
	var SelectedValue=document.getElementById('QuotationCustomerList').options[e].value;
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var ErrorField=0;

		// Traintement des champs Input
	
	if(QuotationName==""){
		document.getElementById('QuotationNameError').innerHTML="<div style='text-align: left'>*</div>";
		ErrorField=1;
	}
	if (/[^a-zA-Z0-9 éèêàïîëùâ-]/.test(QuotationName)) {
    	document.getElementById('QuotationNameError').innerHTML="<div style='text-align: left'>*</div>"
	    ErrorField=1;
	}
	
	if(ErrorField==1){
		return false;
	}

	// fin de traitement des champs Input
	
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;
						
				if (res.ExistingQuotation==1) {
					document.getElementById("QuotationCreationResult").innerHTML="Le nom de devis est déjà utilisé. Veuillez en choisir un autre."
				}

				if (res.ExistingQuotation==0) {

					if(res.Success=1){
						document.getElementById("QuotationCreationResult").innerHTML="Le nouveau devis a bien été créé."
						DisplayQuotationsFunction();
					}

					if(res.Success=0){
					document.getElementById("QuotationCreationResult").innerHTML="Une erreur est survenue pendant la création du nouveau devis."
					}
				}
				
				 
		} else if (this.readyState == 4) {

			MessageBox.value="Une erreur est survenue...";

			}
		
		}

	xhr.open("POST", "/async/CreateQuotation.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("QuotationName="+QuotationName+"&CustomerID="+SelectedValue+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//*******************************************************************************************
// Display Quotations
//*******************************************************************************************

function DisplayQuotationsFunction(){


	var xhr = new XMLHttpRequest();
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	xhr.onreadystatechange = function() {
	console.log(this);
	if (this.readyState == 4 && this.status == 200) {
		
		console.log(this.response);
		var res = this.response;
		DisplayQuotations.style.display="block";
		DisplayCustomers.style.display="none";
		DisplayCatalog.style.display="none";
		DisplayInvoices.style.display="none";
		DisplayProfile.style.display="none";
		DisplayQuotationModification.style.display="none";
		QuotationDetail_ExistingItems.style.display="none";
		DisplayHome.style.display="none";
		document.getElementById("QuotationNameError").innerHTML="";
		document.getElementById("QuotationCreationResult").innerHTML="";

		
		console.log(res.Success);
		var QuotationList="<h2>Mes Devis</h2>"
		QuotationList+="<center><table><thead><tr><th>Destinataire</th><th>Titre</th><th>Date</th><th></th><th></th></tr>";
		var Parameter="";

		for(counter=0;counter<res.NumberOfQuotations;counter++){

			/*QuotationList+="<tr><td>"+res.Quotations[counter][1]+"</td><td>"+res.Quotations[counter][0]+"</td><td style='text-align: center'>"+res.Quotations[counter][2]+"</td><td><center><input type='button' value='Supprimer' onclick='DeleteSelectedQuotation("+res.Quotations[counter][4]+")'></center></td><td><input type='button' value='Détails' onclick='DisplayQuotationDetail("+res.Quotations[counter][4]+")''></td></tr>";	*/
			QuotationList+="<tr><td>"+res.Quotations[counter][1]+"</td><td>"+res.Quotations[counter][0]+"</td><td style='text-align: center'>"+res.Quotations[counter][2]+"</td><td><center><input type='button' value='Supprimer' onclick='DeleteSelectedQuotation("+res.Quotations[counter][4]+")'></center></td><td><input type='button' value='Détails' onclick='DisplayQuotationDetail2("+res.Quotations[counter][4]+")''></td></tr>";	


		}
		QuotationList+="</thead></table></center>";
		DisplayQuotationList.innerHTML=QuotationList;

		var CustomerList="<select name='QuotationCustomerList' id='QuotationCustomerList'>";
		for(counter=0;counter<res.NumberOfCustomers;counter++){
			CustomerList+="<option value="+res.CustomerList[counter][0]+">"+res.CustomerList[counter][1]+" - "+res.CustomerList[counter][2]+" - "+res.CustomerList[counter][3]+" - "+res.CustomerList[counter][4]+"</option>"
		}
		
		LoadQuotationCustomer.innerHTML=CustomerList; 
  

				
			
	} else if (this.readyState == 4) {
			alert("Une erreur est survenue...");
		}
//	};
	}

	xhr.open("POST", "/async/GetMyQuotationList.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;
}

//************************************************************************************************************
// Fonction pour ajouter un Item à la quotation
//************************************************************************************************************

function AddToQuotation(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	var SelectedCategory=document.getElementById('QuotationDetail_GlobalCategoryList');
	var choice=SelectedCategory.selectedIndex;
	var CategoryID=SelectedCategory.options[choice].value;
	

	var SelectedItem=document.getElementById('QuotationDetail_GlobalItemList');
	choice=SelectedItem.selectedIndex;
	var ItemID=SelectedItem.options[choice].value;
	

	var ItemProposedPrice=document.getElementById('CustomerPriceHT').value;
	var ItemProposedTVA=document.getElementById('TVASelector').value;
	var QuotationID=document.getElementById('QuotationNumber').innerHTML;
	var ItemQuantity=document.getElementById('ItemQuantity').value;


	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('SelectedCategory', CategoryID);
	formData.append('SelectedItem',ItemID);
	formData.append('ItemProposedPrice',ItemProposedPrice);
	formData.append('ItemProposedTVA',ItemProposedTVA);
	formData.append('ItemQuantity',ItemQuantity);
	formData.append('QuotationID',QuotationID);
	
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	
	console.log(this);

		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;

			if(res.Success==1){

				RefreshQuotationDetail(QuotationID);
											}

			if(res.Success==0){

				
			}
						
								
				 
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/AddItemToQuotation.php", true);
	xhr.responseType = "json";
	/*xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");*/
	xhr.send(formData);

	return false;


}

//************************************************************************************************************
//* Cette fonction va permettre lors d'une modification un refresh du div DisplayQuotationDetail
//************************************************************************************************************


function RefreshQuotationDetail(QuotationID)

{

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	// Par défaut, on affiche la dernière

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;

			if(res.Success==1){

				var NbOfLinkedItems=res.NumberOfLinkedItems;
				var ActualQuotationDetail="<table style='border-collapse: collapse;'>";
				ActualQuotationDetail+="<tr>";
				ActualQuotationDetail+="	<td style='border: 1px solid black;width: 30px'>Ligne</td><td style='border: 1px solid black'>Quantité</td><td style='border: 1px solid black'>Désignation </td><td style='border: 1px solid black'>Prix Unit. HT</td><td style='border: 1px solid black'>TVA</td><td style='border: 1px solid black'>Montant HT</td><td style='border: 1px solid black'>Montant TTC</td><td style='border: 1px solid black'></td>";
				ActualQuotationDetail+="</tr>";

				var CategoryName="";

				for(Counter=0;Counter<res.NumberOfLinkedItems;Counter++){

					var LineNumber=Counter+1;

					if (CategoryName!=res.ListOfItemsInQuotation[Counter][8]){

						CategoryName=res.ListOfItemsInQuotation[Counter][8];
						ActualQuotationDetail+="<th colspan='8'>"+res.ListOfItemsInQuotation[Counter][8]+"</th>";

					}

					ActualQuotationDetail+="<tr>";
					ActualQuotationDetail+="	<td style='border: 1px solid black;width: 30px'><div id='LineNumber"+LineNumber+"'>"+LineNumber+"</div></td>";
					ActualQuotationDetail+="	<td style='border: 1px solid black;width: 30px'><div id='Quantity"+LineNumber+"'>"+res.ListOfItemsInQuotation[Counter][3]+"</div></td>";
					ActualQuotationDetail+="	<td style='border: 1px solid black'>"+res.ListOfItemsInQuotation[Counter][6]+"</td>";
					ActualQuotationDetail+="	<td style='border: 1px solid black;width: 40px'><div id='PriceHT"+LineNumber+"'>"+(res.ListOfItemsInQuotation[Counter][4]/res.ListOfItemsInQuotation[Counter][3])+"</div></td>";
					ActualQuotationDetail+="	<td style='border: 1px solid black;width: 40px'><div id='TVA"+LineNumber+"'>"+res.ListOfItemsInQuotation[Counter][5]+"</div></td>"

					ActualQuotationDetail+="	<td style='border: 1px solid black;width: 40px'><div id='TotalItemHT"+LineNumber+"'></div></td>";
					ActualQuotationDetail+="	<td style='border: 1px solid black;width: 40px'><div id='TotalItemTTC"+LineNumber+"'></div></td>";
					ActualQuotationDetail+="	<td style='border: 1px solid black;width: 40px'><input type='button' value='Supprimer' onclick='DeleteSelectedQuotationItem("+res.ListOfItemsInQuotation[Counter][0]+","+QuotationID+")'></td>";
					ActualQuotationDetail+="</tr>";

				}
				
				ActualQuotationDetail+="</table>";
				
				QuotationDetail_ActualQuotation.innerHTML=ActualQuotationDetail;

				/* calcul des montants HT et TTC par item */

				for(Counter=0;Counter<res.NumberOfLinkedItems;Counter++){

					LineNumber=Counter+1;
					var QuantityforItem=document.getElementById('Quantity'+LineNumber).innerHTML;
					var PriceHTforItem=document.getElementById('PriceHT'+LineNumber).innerHTML;
					var TVAforItem=document.getElementById('TVA'+LineNumber).innerHTML;

					document.getElementById('TotalItemHT'+LineNumber).innerHTML=(QuantityforItem*PriceHTforItem);

					var TotalItemHT=document.getElementById('TotalItemHT'+LineNumber).innerHTML;

					var TVA=((TotalItemHT*TVAforItem)/100);

					var TotalItemTTC=(parseFloat(TotalItemHT) + TVA);
					var TotalItemTTCPrice="" + TotalItemTTC;
					
					document.getElementById('TotalItemTTC'+LineNumber).innerHTML=TotalItemTTCPrice;


				}

				/* calcul des montants HT et TTC globaux */

				var TotalHT=0;
				var TotalTTC=0;

				for(Counter=0;Counter<res.NumberOfLinkedItems;Counter++){

					LineNumber=Counter+1;

					TotalHT=TotalHT+parseFloat(document.getElementById('TotalItemHT'+LineNumber).innerHTML);

				}

				TotalHT=TotalHT.toFixed(2);
				document.getElementById('QuotationTotalHT').innerHTML="Total HT : "+TotalHT;



				for(Counter=0;Counter<res.NumberOfLinkedItems;Counter++){

					LineNumber=Counter+1;

					TotalTTC=TotalTTC+parseFloat(document.getElementById('TotalItemTTC'+LineNumber).innerHTML);

				}

				TotalTTC=TotalTTC.toFixed(2);
				document.getElementById('QuotationTotalTTC').innerHTML="Total TTC : "+TotalTTC;

															
			}
						
								
				 
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/GetQuotationItemLink.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("QuotationID="+QuotationID+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//******************************************************************************************************************
//*** Fonction pour effacer une ligne de devis
//******************************************************************************************************************


function DeleteSelectedQuotationItem(ItemInQuotationLinkedID, QuotationID)

{

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;


	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res = this.response;

			if(res.Success==1){
				
				RefreshQuotationDetail(QuotationID);
				
			}

			if(res.Success==0){
				
			
			}
						
								
				 
		} else if (this.readyState == 4) {
				MessageBox.value("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/DeleteQuotationItemLink.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("ItemQuotationLinkedID="+ItemInQuotationLinkedID+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//************************************************************************
// Fonction qui permet d'augementer le discount sur un élément
//************************************************************************

function AddDiscount(ItemNumber,NumberOfLinkedItems)

{
	var DiscountCell="DiscountCell"+ItemNumber;
	var Discount=Number(document.getElementById(DiscountCell).value);

	if(Discount>=0 && Discount<=100){

		if(Discount!=100){
			document.getElementById(DiscountCell).value=(Discount+1).toString();
		}
		
		RefreshLinePrice(ItemNumber,NumberOfLinkedItems);
	}

}

//************************************************************************
// Fonction qui permet de réduire le discount sur un élément
//************************************************************************

function RemoveDiscount(ItemNumber,NumberOfLinkedItems)

{
	var DiscountCell="DiscountCell"+ItemNumber;
	var Discount=Number(document.getElementById(DiscountCell).value);
	
	if(Discount>=0 && Discount<=100){

		if(Discount!=0){
			document.getElementById(DiscountCell).value=(Discount-1).toString();
		}
		
		RefreshLinePrice(ItemNumber,NumberOfLinkedItems);
	}

}

//************************************************************************
// Fonction qui permet d'augementer la quantité pour un élément
//************************************************************************

function AddQuantity(ItemNumber,NumberOfLinkedItems)

{

	var QuantityCell="QuantityCell"+ItemNumber;
	var QuantityItem=Number(document.getElementById(QuantityCell).value);
			
	if (QuantityItem>0){

		QuantityItem=QuantityItem+1;
		document.getElementById(QuantityCell).value=QuantityItem.toString();
		RefreshLinePrice(ItemNumber,NumberOfLinkedItems);
	}
	
}

//************************************************************************
// Fonction qui permet de réduire la quantité pour un élément
//************************************************************************

function RemoveQuantity(ItemNumber,NumberOfLinkedItems)

{
	var QuantityCell="QuantityCell"+ItemNumber;
	var QuantityItem=Number(document.getElementById(QuantityCell).value);
			
	if (QuantityItem>0){

		QuantityItem=QuantityItem-1;
		if(QuantityItem==0){
			QuantityItem=1;
		}
		
		document.getElementById(QuantityCell).value=QuantityItem.toString();
		RefreshLinePrice(ItemNumber,NumberOfLinkedItems);
				
	}

}

//************************************************************************
// Fonction qui permet de raffraichir les prix calculés
//************************************************************************

function RefreshLinePrice(ItemNumber, NumberOfLinkedItems)

{
	var UnitPriceCell="UnitPrice"+ItemNumber;
	var DiscountCell="DiscountCell"+ItemNumber;
	var DiscountedPriceCell="DiscountedPriceCell"+ItemNumber

	var BasePrice=Number(document.getElementById(UnitPriceCell).innerHTML);
	var Discount=Number(document.getElementById(DiscountCell).value);

	var DiscountAmount=(0.01*Discount*BasePrice);
	DiscountedPrice=(BasePrice-DiscountAmount);
	document.getElementById(DiscountedPriceCell).value=DiscountedPrice;
	
	var QuantityCell="QuantityCell"+ItemNumber;
	var QuantityItem=Number(document.getElementById(QuantityCell).value);
	var TVACell="TVACell"+ItemNumber;
	var SelectedTVA=document.getElementById(TVACell);
	var TVAChoice=SelectedTVA.selectedIndex;
	
	var TVA=SelectedTVA.options[TVAChoice].value;
	
	var HTPrice=(DiscountedPrice*QuantityItem);
	var CalculatedTVA=(HTPrice/100*TVA);
	var TTCPrice=(HTPrice+CalculatedTVA);

	HTPrice=HTPrice.toFixed(2);
	TTCPrice=TTCPrice.toFixed(2);

	var HTPriceCell="HTPrice"+ItemNumber;
	var TTCPriceCell="TTCPrice"+ItemNumber;

	document.getElementById(HTPriceCell).value=HTPrice.toString();
	document.getElementById(TTCPriceCell).value=TTCPrice.toString();

	RefreshGlobalPrice(NumberOfLinkedItems);


}

//*****************************************************************************************************
//* Cette fonction va permettre de calculer le prix global du devis
//*****************************************************************************************************

function RefreshGlobalPrice(NumberOfLinkedItems)

{

	var HTPrice=0;
	var TTCPrice=0;
	var TotalHTPrice=0;
	var TotalTTCPrice=0;
	var HTPriceCell='';
	var TTCPriceCell='';

	for(counter=1;counter<=NumberOfLinkedItems;counter++){

		HTPriceCell="HTPrice"+counter;
		TTCPriceCell="TTCPrice"+counter;

		HTPrice=Number(document.getElementById(HTPriceCell).value);
		TTCPrice=Number(document.getElementById(TTCPriceCell).value);

		TotalHTPrice=(TotalHTPrice+HTPrice)
		TotalTTCPrice=(TotalTTCPrice+TTCPrice)
		
	}

	TotalTTCPrice=TotalTTCPrice.toFixed(2);
	

	var FinalPrice="<center><br><table class='TablePrice'>";
	FinalPrice+="<tr><td class='TitleCell'>Prix HT : </td><td class='TitleCell'>"+TotalHTPrice.toString()+" €</td></tr>";
	FinalPrice+="<tr><td class='TitleCell'>Prix TTC : </td><td class='TitleCell'>"+TotalTTCPrice.toString()+" €</td></tr>";
	FinalPrice+="</table><br></center>";

	QuotationDetail_GlobalPrice.innerHTML="";
	QuotationDetail_GlobalPrice.style.display="none";
	QuotationDetail_GlobalPrice.style.display="block";
	QuotationDetail_GlobalPrice.innerHTML=FinalPrice;

}

//****************************************************************************************************************
// Cette fonction va permettre d'enregistrer une version du devis
//****************************************************************************************************************

function QuotationRegistration(QuotationID, NumberOfLinkedItems){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	var ItemArray=new Array(NumberOfLinkedItems);
	for(CounterArray=0;CounterArray<NumberOfLinkedItems;CounterArray++){
		ItemArray[CounterArray]=new Array(4);
	}

	var ItemReferenceCell="";
	var DiscountCell="";
	var QuantityCell="";
	var TVACell=""

	for(CounterArray=0;CounterArray<NumberOfLinkedItems;CounterArray++){

		IntReferenceCell="IntReference"+(CounterArray+1);
		DiscountCell="DiscountCell"+(CounterArray+1);
		QuantityCell="QuantityCell"+(CounterArray+1);
		TVACell="TVACell"+(CounterArray+1);

		ItemArray[CounterArray][0]=document.getElementById(IntReferenceCell).innerHTML;
		ItemArray[CounterArray][1]=document.getElementById(DiscountCell).value;
		ItemArray[CounterArray][2]=document.getElementById(QuantityCell).value;
		ItemArray[CounterArray][3]=document.getElementById(TVACell).value;

	}

	LoadQuotationVersion(QuotationID);
	
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);

		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res=this.response;

			if(res.Success==1){
				IsQuotationRegistered=1;
				MessageBox.value="Une version du devis a bien été enregistrée.";
			}
			
			if(res.Success==0){
				IsQuotationRegistered=0;
				MessageBox.value="Une erreur est survenue, le devis n'a pas été enregistré";
			}

														
				 
		} else if (this.readyState == 4) {
				MessageBox.value("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/QuotationRegistration.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("QuotationID="+QuotationID+"&NumberOfLinkedItems="+NumberOfLinkedItems+"&ItemArray="+ItemArray+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//****************************************************************************************************************
// Cette fonction va permettre de générer une version PDF du devis
//****************************************************************************************************************

function QuotationPDF(){

	
		var UserEmail=document.getElementById("LoggedUser").innerHTML;
		var UserSession=document.getElementById("UserSession").innerHTML;
		var QuotationID=document.getElementById('QuotationNumber').innerHTML;
		var QuotationTotalHT=document.getElementById('QuotationTotalHT').innerHTML;
		var QuotationTotalTTC=document.getElementById('QuotationTotalTTC').innerHTML;
		var PaymentConditions=document.getElementById('SelectPaymentCondition').value;
		var SelectedPaymentCondition = document.getElementById("SelectPaymentCondition").options[document.getElementById('SelectPaymentCondition').selectedIndex].text;

		var formData = new FormData();
		formData.append('LoggedUser',UserEmail);
		formData.append('UserSession',UserSession);
		formData.append('QuotationID',QuotationID);
		formData.append('QuotationTotalHT',QuotationTotalHT);
		formData.append('QuotationTotalTTC',QuotationTotalTTC);
		formData.append('SelectedPaymentCondition', SelectedPaymentCondition);


		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function() {
		console.log(this);

			
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				var res=this.response;

				if(res.Success==1){

					RefreshListOfGeneratedQuotations(QuotationID);
				
				}

				if(res.Success==0){

					
				
				}
				
								
			} else if (this.readyState == 4) {
					
			}
			
		}

		xhr.open("POST", "/async/GeneratePDF.php", true);
		xhr.responseType = "json";
		/*xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");*/
		xhr.send(formData);

		return false;

	

}

//****************************************************************************************************************
// Cette fonction va permettre d'envoyer au client final la version affichée du devis
//****************************************************************************************************************

function QuotationSending(QuotationID){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var SelectedVersion=document.getElementById("QuotationVersion").value;
	
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);

		
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res=this.response;

			for(Counter=1;Counter<=res.NbOfItem;Counter++){

				document.getElementById("DiscountCell"+Counter).value=res.ItemInQuotation[Counter-1][2];
				document.getElementById("QuantityCell"+Counter).value=res.ItemInQuotation[Counter-1][3];
				document.getElementById("TVACell"+Counter).value=res.ItemInQuotation[Counter-1][4];
				RefreshLinePrice(Counter,res.NbOfItem);
			}			
			
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/LoadQuotation.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("SelectedVersion="+SelectedVersion+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//****************************************************************************************************************
// Cette fonction va permettre d'afficher les différentes versions d'un devis
//****************************************************************************************************************

function LoadQuotationVersion(QuotationID){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;

	
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);

		var SelectVersion="";
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res=this.response;

			Version="<select id='QuotationVersion'>";

			for(Counter=0;Counter<=(res.NumberOfVersion-1);Counter++){

				Version+="<option value='"+res.Version[Counter]+"'>"+res.Version[Counter]+"</option>";
			}
			Version+="<select>";
			
			document.getElementById("ExistingQuotationVersion").innerHTML="";
			document.getElementById("ExistingQuotationVersion").innerHTML=Version;					
			
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/LoadQuotationVersion.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("QuotationID="+QuotationID+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}

//****************************************************************************************************************
// Cette fonction va permettre de charger et d'afficher les données d'un devis enregistré
//****************************************************************************************************************

function LoadQuotation(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var SelectedVersion=document.getElementById("QuotationVersion").value;
	
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);

		
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res=this.response;

			for(Counter=1;Counter<=res.NbOfItem;Counter++){

				document.getElementById("DiscountCell"+Counter).value=res.ItemInQuotation[Counter-1][2];
				document.getElementById("QuantityCell"+Counter).value=res.ItemInQuotation[Counter-1][3];
				document.getElementById("TVACell"+Counter).value=res.ItemInQuotation[Counter-1][4];
				RefreshLinePrice(Counter,res.NbOfItem);
			}			
			
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/LoadQuotation.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("SelectedVersion="+SelectedVersion+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;

}


/*********************************************************************************************/
/* fonction qui permet d'afficher le détail d'un devis et de le modifier                     */
/*********************************************************************************************/

function DisplayQuotationDetail2(counter)
{
	DisplayQuotations.style.display="none";
	DisplayCatalog.style.display="none";
	DisplayProfile.style.display="none";
	DisplayCustomers.style.display="none";
	DisplayQuotationModification.style.display="block";

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {

	console.log(this);
		if (this.readyState == 4 && this.status == 200) {
			
			console.log(this.response);
			var res = this.response;
			console.log(res.Success);


			var CategoryList='<select id=\'QuotationDetail_GlobalCategoryList\'>';

			for(Counter=0;Counter<res.TotalNumberOfCategories;Counter++){

				CategoryList+='<option value='+res.TotalCategoryList[Counter][0]+'>'+res.TotalCategoryList[Counter][1]+'</option>';

			}

			CategoryList+='</select>';

			var GlobalItemList='<select id=\'QuotationDetail_GlobalItemList\' onchange="DisplayItemPrice()">';

			for(Counter=0;Counter<res.GlobalItemList.length;Counter++){

				GlobalItemList+='<option value='+res.GlobalItemList[Counter][0]+'>'+res.GlobalItemList[Counter][1]+'</option>';

			}

			GlobalItemList+='</select>';			

			QuotationDetail_ListOfCategories.innerHTML=CategoryList;
			QuotationDetail_ListOfItems.innerHTML=GlobalItemList;

			QuotationName.innerHTML=res.QuotationName;
			CustomerDetail.innerHTML="A l'attention de : <br>"+res.CustomerName+"<br>"+res.CustomerAddress1+"<br>"+res.CustomerAddress2+"<br>"+res.CustomerCP+"<br>"+res.CustomerCity+"<br>"+res.CustomerTel1+"<br>"+res.CustomerTel2
			WorkerDetail.innerHTML=res.SocialName+" "+res.CompanyName+"<br>Siret : "+res.RCSNumber+"<br>"+res.LegalAddress1+"<br>"+res.LegalAddress2+"<br>"+res.CP+"<br>"+res.City+"<br>"+res.Tel1+"<br>"+res.Tel2;
			QuotationDate.innerHTML="Date : "+res.QuotationDate;
			QuotationNumber.innerHTML=counter;


			RefreshQuotationDetail(counter)
			DisplayItemPrice();
			RefreshListOfGeneratedQuotations(counter);

								 
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
	}

	xhr.open("POST", "/async/GetQuotationDetail.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("QuotationID="+counter+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;


}

/******************************************************************************************/
/* fonction qui permet de recalculer et afficher les prix des items à intégrer dans un devis */
/******************************************************************************************/
function DisplayItemPrice(){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
	var ItemSelected=document.getElementById("QuotationDetail_GlobalItemList").value;
	var TVA=document.getElementById("TVASelector").value;
	var Discount=document.getElementById("Discount").value;
	var ItemQuantity=document.getElementById("ItemQuantity").value;
	
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
	console.log(this);

		
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res=this.response;
			var ItemPrice=res.ItemPrice;
			var FinalItemPrice=	(ItemPrice-((ItemPrice*Discount)/100))*ItemQuantity;
			var FinalItemPriceHT=FinalItemPrice.toFixed(2);
			var FinalItemPriceTTC=(FinalItemPrice+((FinalItemPrice*TVA)/100));
			FinalItemPriceTTC=FinalItemPriceTTC.toFixed(2);
			document.getElementById("CustomerPriceHT").value=FinalItemPriceHT;
			document.getElementById("CustomerPriceTTC").value=FinalItemPriceTTC;
			var ItemBuyingPrice=res.ItemBuyingPrice;
			if (ItemBuyingPrice!=0){

				document.getElementById("ItemBuyingPrice").value=ItemBuyingPrice;
				var Margin=((FinalItemPriceHT)-(ItemBuyingPrice*ItemQuantity)).toFixed(2);
				document.getElementById("Margin").innerHTML="<input type=text name='ItemMargin' value='"+Margin+"' id='ItemMargin' disabled='disabled'>";
				if(Margin>=2){

					document.getElementById('ItemMargin').style.backgroundColor='#CCFF33'; 

				}
				if((Margin>=0)&&(Margin<2)){

					document.getElementById('ItemMargin').style.backgroundColor='#CC8833'; 
					document.getElementById('ItemMargin').style.color='#FFFFFF';

				}
				if(Margin<0){

					document.getElementById('ItemMargin').style.backgroundColor='#CC0033'; 
					document.getElementById('ItemMargin').style.color='#FFFFFF';
				}
				
								
			}	

			if (ItemBuyingPrice==0){

				document.getElementById("ItemBuyingPrice").value="Non défini";
				document.getElementById("Margin").innerHTML="<input type=text name='ItemMargin' value='Non défini' id='ItemMargin' disabled='disabled' style='background-color: #00DFDE0;'>";
			}	
			
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/GetItemPrice.php", true);
	xhr.responseType = "json";
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("ItemSelected="+ItemSelected+"&LoggedUser="+UserEmail+"&UserSession="+UserSession);

	return false;


}

/* Cette fonction va permettre de raffraichir le div ListOfGeneratedQuotations */

function RefreshListOfGeneratedQuotations(QuotationID){

	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
		
	var xhr = new XMLHttpRequest();

	var formData = new FormData();
		formData.append('LoggedUser',UserEmail);
		formData.append('UserSession',UserSession);
		formData.append('QuotationID',QuotationID);
		
	xhr.onreadystatechange = function() {
	console.log(this);

		
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			var res=this.response;
			document.getElementById("QuotationAction").style.display="none";
			ListOfGeneratedQuotations.innerHTML="";
			ListOfPDF="<select id='SelectListOfPDF'>";
			for(Counter=0;Counter<res.NumberOfPDF;Counter++){

				ListOfPDF+="<option value='"+res.ListOfPDF[Counter][0]+"'>Version du "+res.ListOfPDF[Counter][1]+" à "+res.ListOfPDF[Counter][2]+"</option>";
			}
			ListOfPDF+="<select>";

			if(res.NumberOfPDF>0){
				document.getElementById("QuotationAction").style.display="block";
				ListOfGeneratedQuotations.innerHTML=ListOfPDF;
				SelectListOfPDF.selectedIndex = -1;
			}

							
			
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/RefreshListOfGeneratedQuotations.php", true);
	xhr.responseType = "json";
	/*xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");*/
	xhr.send(formData);

	return false;

}

/* Fonction qui permet de visualiser le PDF pointé par le select SelectListOfPDF */

function VisualizePDF(){

	var QuotationPDFName=document.getElementById("SelectListOfPDF").value;
	window.open("http://eartisan/QuotationPDF/"+QuotationPDFName);

}

/* Fonction qui permet de supprimer un PDF généré précédemment */

function DeletePDF(){

	var QuotationPDFName=document.getElementById("SelectListOfPDF").value;
	var UserEmail=document.getElementById("LoggedUser").innerHTML;
	var UserSession=document.getElementById("UserSession").innerHTML;
		
	var xhr = new XMLHttpRequest();

	var formData = new FormData();
	formData.append('LoggedUser',UserEmail);
	formData.append('UserSession',UserSession);
	formData.append('QuotationPDFName',QuotationPDFName);
		
	xhr.onreadystatechange = function() {
	console.log(this);
	var res=this.response;

		
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);

			if(res.Success==1){

				var QuotationID=document.getElementById("QuotationNumber").innerHTML;
				RefreshListOfGeneratedQuotations(QuotationID);

			}

			if(res.Success==0){

			}
			
							
			
		} else if (this.readyState == 4) {
				alert("Une erreur est survenue...");
			}
		
		}

	xhr.open("POST", "/async/DeletePDF.php", true);
	xhr.responseType = "json";
	/*xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");*/
	xhr.send(formData);

	return false;
}


