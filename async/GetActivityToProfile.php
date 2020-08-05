<?php

	/* Cette fonction va permettre de récupérer la liste des catégories d'activité associées au profil */

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");

	/* Récupération de la liste d'activité de la table de lien */

	$Success=0;
	$ActivityList=array();
	$Counter=0;
	$sql="select * from workertypelink where WorkerID=".$WorkerID;


	foreach  ($base->query($sql) as $row) {
		
		$Success=1;
		$ActivityID=$row['WorkerTypeID'];
		$Counter++;
		$sql2="select * from workertype where ID=".$ActivityID;
		foreach  ($base->query($sql2) as $row2){
			$ActivityList[$Counter][0]=$ActivityID;
			$ActivityList[$Counter][1]=$row2['WorkerTypeName'];
		}
									
	}

	$res = ["Success" => $Success, "ActivityList" => $ActivityList, "NbOfActivityAssociated" => $Counter];
	echo json_encode($res);

?>