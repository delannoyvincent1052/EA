<?php

	if(isset($_POST['email'])){

		$Email=$_POST['email'];

		try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	  	}

	  	catch(exception $e) {

	    	die('Erreur '.$e->getMessage());

	  	}

	  	/* Suppression de l'entrée dans la table validationworker*/

	  	$sql="delete from validationworker where Email='".$Email."'";
	  	$Result=$base->exec($sql);

	  	/* Creation d'une nouvelle entrée dans la table validationworker */

	  	$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$ConfirmationCode = '';
		
		for ($i = 0; $i < 100; $i++)
		{
			$ConfirmationCode .= $caracteres[rand(0, 60)];
		}

		/* 
			On stocke cette chaine de validation et on envoie un email
		*/

		$sql="insert into validationworker values('".$Email."','".$ConfirmationCode."');";
		$Result=$base->exec($sql);
		require("SendMail.php");
		EmailConfirmation($Email,$ConfirmationCode);
		$res = ["Success" => 1];
		echo json_encode($res);

		/*

	  	if($Result){

	  		$res = ["Success" => 1];
			echo json_encode($res);
	  	}
	  	else{
	  		$res = ["Success" => 0];
			echo json_encode($res);
	  	}
	  	*/
	}

?>