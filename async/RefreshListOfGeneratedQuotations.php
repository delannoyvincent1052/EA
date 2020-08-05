<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationID=$_POST['QuotationID'];
	
	require("common.php");	

	/* Récupération de la liste des quotations enregistrées (nom de fichier, date et heure de création */

	$sql="select * from quotationfile where QuotationID=".$QuotationID;

	$ListOfPDFQuotations=array();
	$Counter=0;

	foreach  ($base->query($sql) as $row) {
		
		$WorkerID=$row['ID'];
		$ListOfPDFQuotations[$Counter][0]=$row["QuotationFileName"];
		$ListOfPDFQuotations[$Counter][1]=$row["QuotationDate"];
		$ListOfPDFQuotations[$Counter][2]=$row["QuotationTime"];
		$Counter++;
									
	}	

	$res = ["QuotationID" => $QuotationID, "NumberOfPDF" => $Counter, "ListOfPDF" => $ListOfPDFQuotations];
	echo json_encode($res);

?>