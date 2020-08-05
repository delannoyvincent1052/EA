<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	

	require("common.php");

	/* Récupération du RIB enregistré */

	$ExistingRIB=0;
	$RIBName="";
	$sql="select * from workerrib where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$ExistingRIB=1;
		$RIBName=$row['RIBName'];
		$RIBFirstName=$row['FirstName'];
		$RIBLastName=$row['LastName'];
		$RIBBankName=$row['BankName'];
		$RIBBankCode=$row['BankCode'];
		$RIBGuichetCode=$row['GuichetCode'];
		$RIBAccountNumber=$row['AccountNumber'];
		$RIBAccountKey=$row['AccountKey'];
		$RIBIBAN=$row['IBAN'];
		$RIBSWIFT=$row['SWIFT'];
									
	}

	$Success=0;

	if($ExistingRIB==1){

		$res = ["Success" => 1, "RIBName" => $RIBName, "RIBFirstName" => $RIBFirstName, "RIBLastName" => $RIBLastName, "RIBBankCode" => $RIBBankCode, "RIBGuichetCode" => $RIBGuichetCode, "RIBAccountNumber" => $RIBAccountNumber, "RIBAccountKey" => $RIBAccountKey, "RIBIBAN" => $RIBIBAN, "RIBSWIFT" => $RIBSWIFT];
	}

	if($ExistingRIB==0){

		$res = ["Success" => 0];
	}

	echo json_encode($res);
	
?>