<?php

session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$ItemQuotationLinkedID=$_POST['ItemQuotationLinkedID'];
	
		
	require("common.php");

	/* Suppression de la ligne de devis correspondante*/

	$Status=0;

	$sql="delete from quotationitemcategorylink where LinkID=".$ItemQuotationLinkedID;
	$Result=$base->exec($sql);

	if($Result){

		$Status=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationItemLinkDeletion',1)";
		$Result=$base->exec($sql);
	}

	if(!$Result){

		$Status=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationItemLinkDeletion',0)";
		$Result=$base->exec($sql);
	}

	$res = ["Success" => $Status];
	echo json_encode($res);
?>
