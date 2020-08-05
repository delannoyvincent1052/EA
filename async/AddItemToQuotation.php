<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationID=$_POST['QuotationID'];
	$SelectedCategory=$_POST['SelectedCategory'];
	$SelectedItem=$_POST['SelectedItem'];
	$ItemProposedPrice=$_POST['ItemProposedPrice'];
	$ItemProposedTVA=$_POST['ItemProposedTVA'];
	$ItemQuantity=$_POST['ItemQuantity'];


	/* Connexion à la DB et test de validité de la session */
	require("common.php");
	/* *************************************************** */

	$Status=0;

	/* Insertion du nouveal item de devis dans la table quotationitemcategorylink*/

	$sql="insert into quotationitemcategorylink (QuotationID, QuotationItem, QuotationCategory, QuantityItem, ItemProposedPrice, ItemProposedTVA) values (".$QuotationID.",".$SelectedItem.",".$SelectedCategory.",".$ItemQuantity.",".$ItemProposedPrice.",".$ItemProposedTVA.")";
	$Result=$base->exec($sql);

	if($Result){

		$Status=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','AddItemToQuotation',1)";
		$Result=$base->exec($sql);
	}

	if(!$Result){
		
		$Status=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','AddItemToQuotation',0)";
		$Result=$base->exec($sql);
	}

	$res = ["Success" => $Status, "QuotationID" => $QuotationID];
	echo json_encode($res);
?>