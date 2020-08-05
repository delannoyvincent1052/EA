<?php

/* Cette fonction va supprimer une catégorie d'activité précédemment associée */

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$ActivityCategoryID=$_POST['ActivityCategoryID'];
	
	require("common.php");

	/* Suppression dans la base de données */

	$Success=0;

	$sql="delete from workertypelink where WorkerTypeID=".$ActivityCategoryID;
	$Result=$base->exec($sql);

	if($Result){

		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','DeleteAssociatedActivityCategory',1)";
		$Result=$base->exec($sql);
		$Success=1;

	}

	if(!$Result){

		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','DeleteAssociatedActivityCategory',0)";
		$Result=$base->exec($sql);
		$Success=1;

	}

	$res = ["Success" => $Success];
	echo json_encode($res);

?>