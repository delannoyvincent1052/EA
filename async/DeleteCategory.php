<?php

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$CategoryID=$_POST['CategoryID'];

	require("common.php");

	$Result=0;
	$sql="delete from quotationcategory where ID=".$CategoryID;
	$Result=$base->exec($sql);

	if($Result){

		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Category','CategoryDeletion',1)";
		$Result=$base->exec($sql);
		$res = ["Success" => 1];
				
	}

	if(!$Result){

		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Category','CategoryDeletion',0)";
		$Result=$base->exec($sql);
		$res = ["Success" => 0];
		
	}

	echo json_encode($res);

?>