<?php

/* Cette fonction va permettre de supprimer une réalisation */

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$RealisationID=$_POST['IDRealisation'];

	require("common.php");

	/* Suppression de la réalisation pointée */

	$Status=0;

	$sql="delete from realisation where ID=".$RealisationID;
	$Result=$base->exec($sql);

	if($Result){
		$Status=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','DeleteRealisation',1)";
		$Result=$base->exec($sql);
	}

	if(!$Result){
		$Status=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','DeleteRealisation',0)";
		$Result=$base->exec($sql);

	}

	$res = ["Success" => $Status];
	echo json_encode($res);



?>