<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationID=$_POST['QuotationID'];
	$NumberOfLinkedItems=$_POST['NumberOfLinkedItems'];
	$ItemArray=$_POST['ItemArray'];

	$ItemToBackup=explode(",",$ItemArray);
	$NumberOfItemsToBackup=sizeof($ItemToBackup);

	require("common.php");

	$CurrentDate=date('Y')."-".date('m')."-".date('j')."-".date('H')."-".date('i')."-".date('s');
	$sql="insert into generatedquotation(WorkerID,QuotationID,GenerationDate) values (".$WorkerID.",".$QuotationID.",'".$CurrentDate."');";
	$Result=$base->exec($sql);

	/* Récupération de l'ID généré */

	$sql="select ID from generatedquotation where GenerationDate='".$CurrentDate."';";

	foreach  ($base->query($sql) as $row) {
		
		$GeneratedID=$row['ID'];
									
	}

	$Status=0;

	for($counter=1;$counter<$NumberOfItemsToBackup;$counter+=4){

		$ItemID=$ItemToBackup[$counter-1];
		$Discount=$ItemToBackup[$counter];
		$Quantity=$ItemToBackup[$counter+1];
		$TVA=$ItemToBackup[$counter+2];
		$sql="insert into generatedquotationitem (GeneratedQuotationID,ItemID,Discount,Quantity,TVA) values(".$GeneratedID.",".$ItemID.",".$Discount.",".$Quantity.",".$TVA.");";
		$Result=$base->exec($sql);

	}

	if($Result){

		$Status=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationRegistration',1)";
		$Result=$base->exec($sql);
	}

	if(!$Result){

		$Status=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationRegistration',0)";
		$Result=$base->exec($sql);
	}

	


	$res = ["Success" => $Status];
	echo json_encode($res);


?>
