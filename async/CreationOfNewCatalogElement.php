<?php

	session_start();

	/* Récupération des variables */

	$ItemName=$_POST['ItemName'];
	$ItemDescription=$_POST['ItemDescription'];
	$ItemPrice=$_POST['ItemPrice'];
	$ItemUnit=$_POST['ItemUnit'];
	$ItemBuyingPrice=$_POST['ItemBuyingPrice'];
	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];


	/* Contrôle des variables */

	$VarOK=1;
	$VarIssue=array();
	if($ItemName==''){
		$VarOK=0;
		$VarIssue[0]=1;
	}
	if($ItemDescription==''){
		$VarOK=0;
		$VarIssue[1]=1;
	}
	if($ItemPrice==''){
		$VarOK=0;
		$VarIssue[2]=1;
	}
	if($ItemUnit==''){
		$VarOK=0;
		$VarIssue[3]=1;
	}

	/* Fin de contrôle des variables */

	/* Connexion à la DB et test de validité de la session */
	require("common.php");
	/* *************************************************** */

	$msg=0;

	if($VarOK==1){

		/* On contrôle d'abord si l'item n'existe pas déjà */

		$ExistingItem=0;

		$sql="select * from quotationitem where Name='".$ItemName."' and WorkerID=".$WorkerID;
		
		foreach  ($base->query($sql) as $row) {
		
			$ExistingItem++;
												
		}	

		if($ExistingItem>0){

			$msg=1;
		}

		/* Si l'élément n'existe pas encore, on peut le créer */

		If($ExistingItem==0){

			$sql="insert into quotationitem (Name,Description,Price,Unit,WorkerID,BuyingPrice) values ('".$ItemName."','".$ItemDescription."',".$ItemPrice.",'".$ItemUnit."',".$WorkerID.",".$ItemBuyingPrice.");";
			$Result=$base->exec($sql);
			
			if($Result){

				$msg=2;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','CatalogItem','CatalogItemCreation',1)";
				$Result=$base->exec($sql);
			}

			if(!$Result){

				$msg=2;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','CatalogItem','CatalogItemCreation',0)";
				$Result=$base->exec($sql);
			}

		}
	}

	$res = ["Var" => $VarOK, "Success" => $msg];
	echo json_encode($res);
?>