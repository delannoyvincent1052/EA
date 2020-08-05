<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$SelectedVersion=$_POST['SelectedVersion'];
	

	require("common.php");

	/* Récupération de la l'ID de devis généré */

	$sql="select * from generatedquotation where GenerationDate='".$SelectedVersion."'";

	foreach  ($base->query($sql) as $row) {
		
		$GeneratedQuotationID=$row['ID'];
									
	}	

	$ItemInQuotation=array();
	$Counter=0;

	$sql="select * from generatedquotationitem where GeneratedQuotationID=".$GeneratedQuotationID;

	foreach  ($base->query($sql) as $row) {

		$ItemInQuotation[$Counter][0]=$row['GeneratedQuotationID'];
		$ItemInQuotation[$Counter][1]=$row['ItemID'];
		$ItemInQuotation[$Counter][2]=$row['Discount'];
		$ItemInQuotation[$Counter][3]=$row['Quantity'];
		$ItemInQuotation[$Counter][4]=$row['TVA'];
		$Counter++;
									
	}

	$res = ["ItemInQuotation" => $ItemInQuotation, "NbOfItem" => $Counter];
	echo json_encode($res);

?>
