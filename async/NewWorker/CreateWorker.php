<?php

	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$CompanyName=$_POST['CompanyName'];
	$SocialName=$_POST['SocialName'];
	$RCSNumber=$_POST['RCSNumber'];
	$Address1=$_POST['Address1'];
	$Address2=$_POST['Address2'];
	$CP=$_POST['CP'];
	$City=$_POST['City'];
	$Tel1=$_POST['Tel1'];
	$Tel2=$_POST['Tel2'];
	$Email=$_POST['Email'];

	$CryptoKey='AZERTY';
	$CreationDate=date("Ymd");

	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	}

	  catch(exception $e) {

	    die('Erreur '.$e->getMessage());

	}

/*
	Check if a similar account does not exist with the same email address
*/

	$ExistingWorker=0;

	$sql="select * from worker where Email='".$Email."'";

	foreach  ($base->query($sql) as $row) {
			
		$ExistingWorker=1;
			
	}

/* Get a New temporary password */

		$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$TempPassword = '';
		
		for ($i = 0; $i < 10; $i++)
		{
			$TempPassword .= $caracteres[rand(0, 60)];
		}


/*
	Insert the new account in the DB	
*/

	If ($ExistingWorker==0){

		$sql="insert into worker (FirstName,LastName,CompanyName,SocialName,RCSNumber,LegalAddress1,LegalAddress2,CP,City,Tel1,Tel2,Email,Password,Valid,CryptoKey,Payment,CreationDate) values('".$FirstName."','".$LastName."','".$CompanyName."','".$SocialName."','".$RCSNumber."','".$Address1."','".$Address2."','".$CP."','".$City."','".$Tel1."','".$Tel2."','".$Email."','".$TempPassword."',0,'".$CryptoKey."',0,'".$CreationDate."')";
		$Result=$base->exec($sql);

		/* Création d'une clé de validation de la création de compte */

		$ConfirmationCode = '';
		
		for ($i = 0; $i < 100; $i++)
		{
			$ConfirmationCode .= $caracteres[rand(0, 60)];
		}

		/* 
			On stocke cette chaine de validation et on envoie un email
		*/

		$sql="insert into validationworker (Email,ValidationCode) values('".$Email."','".$ConfirmationCode."');";
		$Result=$base->exec($sql);

		/*require("SendMail.php");
		EmailConfirmation($Email,$ConfirmationCode);*/
			
	}


	$msg=0; /* Utilisateur avec une même adresse email */
	
	if ($ExistingWorker==1){

		$msg=0;

	}

	if($ExistingWorker==0){

		if($Result){

			$msg=1; /* Utilisateur bien créé */
		}
		else{

			$msg=2; /* Problème lors de la création */
		}
	}

	$res = ["Success" => $msg];
	
	echo json_encode($res);


?>