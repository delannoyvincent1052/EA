<?php

	$WorkerEmail=$_POST['LoggedUser'];
	
	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

  	}

  	catch(exception $e) {

    	die('Erreur '.$e->getMessage());

  	}

  	/* Récupération de l'ID du worker */

  	$sql="select * from Worker where Email='".$WorkerEmail."'";
  	
	foreach  ($base->query($sql) as $row) {
		
		$WorkerID=$row['ID'];
									
	}

	/* Récupération des données utilisateur de base */

	$BaseInfo=array();
	
	$sql = "select * from worker where ID=".$WorkerID;
	foreach  ($base->query($sql) as $row) {
		
		$BaseInfo[0]=$row['FirstName'];
		$BaseInfo[1]=$row['LastName'];
		$BaseInfo[2]=$row['CompanyName'];
		$BaseInfo[3]=$row['SocialName'];
		$BaseInfo[4]=$row['RCSNumber'];
		$BaseInfo[5]=$row['LegalAddress1'];
		$BaseInfo[6]=$row['LegalAddress2'];
		$BaseInfo[7]=$row['CP'];
		$BaseInfo[8]=$row['City'];
		$BaseInfo[9]=$row['Tel1'];
		$BaseInfo[10]=$row['Tel2'];
		$BaseInfo[11]=$row['Email'];
									
	}

	/* Récupération des données additionnelles */

	$sql="select * from worker_add where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$LogoName=$row['LogoName'];
		$ActivityDescription=$row['ActivityDescription'];
									
	}

	/* Récupération des informations sur les réalisations */

	$Counter=0;
	$RealisationList=array();

	$sql="select * from realisation where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$RealisationList[$Counter][0]=$row['Title'];
		$RealisationList[$Counter][1]=$row['Description'];
		$RealisationList[$Counter][2]=$row['Picture'];
		$Counter++;
									
	}


	$res = ["Success" => 1,"BaseInfo" => $BaseInfo, "LogoName" => $LogoName, "ActivityDescription" => $ActivityDescription, "NbOfRealisation" => $Counter, "RealisationList" => $RealisationList];
	echo json_encode($res);



?>