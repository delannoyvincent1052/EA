<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$ActivityDescription=$_POST['ActivityDescription'];
	
	require("common.php");

	/* Vérification si une ligne existe déjà dans la base pour cet utilisateur */

	$ExistingLine=0;
	
	$sql="select * from worker_add where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$ExistingLine=1;
									
	}

	/* Mise à jour de l'enregistrement déjà existant */

	if($ExistingLine==1){

		$sql="update worker_add set ActivityDescription='".$ActivityDescription."' where OwnerID=".$WorkerID;
		$Result=$base->exec($sql);
	}

	/* Création de l'enregistrement si il n'est pas déjà existant */

	if($ExistingLine==0){

		$sql="insert into worker_add (LogoName,ActivityDescription,OwnerID) values ('','".$ActivityDescription."',".$WorkerID.");";
		$Result=$base->exec($sql);
	}

	if($Result){

		$Result=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','SetActivityDescription',1)";
		$Result=$base->exec($sql);
		$res = ["Success" => $Result];
		echo json_encode($res);
	}

	if(!$Result){

		$Result=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','SetActivityDescription',0)";
		$Result=$base->exec($sql);
		$res = ["Success" => $Result];
		echo json_encode($res);
	}

?>