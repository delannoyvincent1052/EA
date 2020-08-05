<?php

//**************************************************************************************************************
// Fonction qui va permettre de supprimer un utilisateur
//**************************************************************************************************************
	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	$CustomerID=$_POST['CustomerID'];
	

	require("common.php");

	/* Vérification de l'information "devis en cours" */

	$ExistingQuotation=0;
	$sql="select * from quotations where Customer=".$CustomerID;

	foreach  ($base->query($sql) as $row) {
		
		$ExistingQuotation=1;
									
	}

	if($ExistingQuotation==0){

		$sql="delete from customer where ID=".$CustomerID;
		$Result=$base->exec($sql);

		if($Result){

			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Customer','CustomerDeletion',1)";
			$Result=$base->exec($sql);
			$res = ["Success" => 1];
			echo json_encode($res);
		}

		if(!$Result){

			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Customer','CustomerDeletion',0)";
			$Result=$base->exec($sql);
			$res = ["Success" => 0];
			echo json_encode($res);
		}

	}

	if($ExistingQuotation==1){

		$res = ["Success" => 2];
		echo json_encode($res);
	}

?>
