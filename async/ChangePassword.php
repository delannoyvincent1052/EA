<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$Password1=$_POST['Password1'];
	$Password2=$_POST['Password2'];

	require("common.php");

	$Status=2;

	if($Password1==$Password2){

		$sql="update worker set Password='".$Password1."' where ID=".$WorkerID;
		$Result=$base->exec($sql);

		if($Result){
			$Status=1;
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','ChangePassword',1)";
			$Result=$base->exec($sql);
		}

		if(!$Result){
			$Status=0;
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','ChangePassword',0)";
			$Result=$base->exec($sql);

		}

	}

	$res = ["Success" => $Status];
	echo json_encode($res);
	
?>