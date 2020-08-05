<?php

	session_start();

	/* Contrôle des champs */

	$FieldsOK=1;

	if(isset($_POST['LoggedUser'])){
		$LoggedUser=$_POST['LoggedUser'];
	}
	else{
		$FieldsOK=0;
	}

	if(isset($_POST['UserSession'])){
		$UserSession=$_POST['UserSession'];
	}
	else{
		$FieldsOK=0;
	}

	if(isset($_POST['RIBName'])){
		$RIBName=$_POST['RIBName'];
	}
	else{
		$FieldsOK=0;
	}

	if(isset($_POST['RIBFirstName'])){
		$RIBFirstName=$_POST['RIBFirstName'];
	}
	else{
		$FieldsOK=0;
	}
	
	if(isset($_POST['RIBLastName'])){
		$RIBLastName=$_POST['RIBLastName'];
	}
	else{
		$FieldsOK=0;
	}
	
	if(isset($_POST['RIBBankName'])){
		$RIBBankName=$_POST['RIBBankName'];
	}
	else{
		$FieldsOK=0;
	}

	if(isset($_POST['RIBBankCode'])){
		$RIBBankCode=$_POST['RIBBankCode'];
	}
	else{
		$FieldsOK=0;
	}
	
	if(isset($_POST['RIBGuichetCode'])){
		$RIBGuichetCode=$_POST['RIBGuichetCode'];
	}
	else{
		$FieldsOK=0;
	}
	
	if(isset($_POST['RIBAccountNumber'])){
		$RIBAccountNumber=$_POST['RIBAccountNumber'];
	}
	else{
		$FieldsOK=0;
	}
	
	if(isset($_POST['RIBAccountKey'])){
		$RIBAccountKey=$_POST['RIBAccountKey'];
	}
	else{
		$FieldsOK=0;
	}

	if(isset($_POST['RIBIBAN'])){
		$RIBIBAN=$_POST['RIBIBAN'];
	}
	else{
		$FieldsOK=0;
	}

	if(isset($_POST['RIBSWIFT'])){
		$RIBSWIFT=$_POST['RIBSWIFT'];
	}
	else{
		$FieldsOK=0;
	}

	/* fin de contrôle des champs */

	
	if($FieldsOK==1){

		require("common.php");

		/* Vérification pour savoir si un RIB est déjà enregistré */

		$ExistingRIB=0;

		$sql="select * from workerrib where OwnerID=".$WorkerID;

		foreach  ($base->query($sql) as $row) {
			
			$ExistingRIB=1;
										
		}	

		if($ExistingRIB==0){
			

			$sql="insert into workerrib(RIBName, FirstName, LastName, BankName, BankCode, GuichetCode, AccountNumber, AccountKey, IBAN, SWIFT, OwnerID) values ('".$RIBName."','".$RIBFirstName."','".$RIBLastName."','".$RIBBankName."','".$RIBBankCode."','".$RIBGuichetCode."','".$RIBAccountNumber."','".$RIBAccountKey."','".$RIBIBAN."','".$RIBSWIFT."',".$WorkerID.")";
			$Result=$base->exec($sql);

		}

		if($ExistingRIB==1){

			$sql="update workerrib set RIBName='".$RIBName."', FirstName='".$RIBFirstName."', LastName='".$RIBLastName."', BankName='".$RIBBankName."',BankCode='".$RIBBankCode."', GuichetCode='".$RIBGuichetCode."', AccountNumber='".$RIBAccountNumber."', AccountKey='".$RIBAccountKey."',IBAN='".$RIBIBAN."', SWIFT='".$RIBSWIFT."' where OwnerID=".$WorkerID;
			$Result=$base->exec($sql);

		}

		if($Result){

			$res = ["Success" => 1];
	
		}

		if(!$Result){

			$res = ["Success" => 0];
	
		}

	}

	if($FieldsOK==0){

		header("Location: /Login.html");

	}

	echo json_encode($sql);

?>