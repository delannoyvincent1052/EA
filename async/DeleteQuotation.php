<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationID=$_POST['QuotationID'];
	
	require("common.php");

	$Status=0;

	/* Suppression des liens avec les éléments du devis (table )quotationitemcategorylink */

	$sql="delete from quotationitemcategorylink where QuotationID=".$QuotationID;
	$Result=$base->exec($sql);

	/* Suppression du devis pointé */

	$sql="delete from quotations where ID=".$QuotationID;
	$Result=$base->exec($sql);

	if($Result){

		$Status=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationDeletion',1)";
		$Result=$base->exec($sql);
	}

	if(!$Result){

		$Status=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationDeletion',0)";
		$Result=$base->exec($sql);
	}

	$res = ["Success" => $Status];
	echo json_encode($res);
	
?>