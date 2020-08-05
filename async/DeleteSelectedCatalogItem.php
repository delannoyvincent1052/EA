<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$ItemID=$_POST['ItemID'];

	require("common.php");

	$msg=0;

	$sql="delete from quotationitem where ID=".$ItemID;
	$Result=$base->exec($sql);

	if($Result){
		$msg=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','CatalogItem','CatalogItemDeletion',1)";
		$Result=$base->exec($sql);
			
	}

	if(!$Result){
		$msg=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','CatalogItem','CatalogItemDeletion',0)";
		$Result=$base->exec($sql);
			
	}

	$res = ["Success" => $msg];
	echo json_encode($res);


?>