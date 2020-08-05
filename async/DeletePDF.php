<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationPDFName=$_POST['QuotationPDFName'];
	
	require("common.php");

	/* Vérification de l'existence du PDF à supprimer */

	$sql="select * from quotationfile where QuotationFileName='".$QuotationPDFName."'";
	$NbOfPDF=0;

	foreach  ($base->query($sql) as $row) {
		
		$NbOfPDF++;
									
	}

	/* Suppression du fichier PDF et de l'entrée dans la base de données */

	$Status=0;

	if($NbOfPDF>0){

		$sql="delete from quotationfile where QuotationFileName='".$QuotationPDFName."'";
		$Result=$base->exec($sql);
		$ResultFile=unlink("../QuotationPDF/".$QuotationPDFName);

		if($Result){
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationPDFDeletion',1)";
			$Result=$base->exec($sql);
			$Status=1;
		}

		if(!$Result){
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationPDFDeletion',0)";
			$Result=$base->exec($sql);
		}
	}
	

	$res = ["Success"=> $Status];
	echo json_encode($res);

?>