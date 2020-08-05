<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$ActivityCategory=$_POST['ActivityCategory'];
	$Success=0;
		
	require("common.php");

	/* Contrôle pour savoir si la catégorie activité n'existe pas déjà dans le profil du worker */

	$ExistingCategoryInProfile=0;
	$Success=0;

	$sql="select * from workertypelink where WorkerTypeID='".$ActivityCategory."';";
	foreach  ($base->query($sql) as $row) {
		
		$ExistingCategoryInProfile=1;
									
	}

	if($ExistingCategoryInProfile==0){

		$sql="insert into workertypelink(WorkerTypeID,WorkerID) values (".$ActivityCategory.",".$WorkerID.")";
		$Result=$base->exec($sql);

		/*if($Result){

			$Success=1;
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','AddActivityToProfile',1)";
			$Result=$base->exec($sql);

		}

		if(!$Result){

			$Success=0;
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','AddActivityToProfile',0)";
			$Result=$base->exec($sql);

		}*/

	}

	if($ExistingCategoryInProfile==1){

		$Success=2;

	}

	$res = ["Success" => $Success];
	echo json_encode($res);

?>