<?php

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$Category=$_POST['Category'];
	$Action=$_POST['Action'];
	$Result=$_POST['Result'];

	require("common.php");

	$CreationDate=date("Ymd");

	$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','".$Category."','".$Action."',".$Result.")";
	/*$Result=$base->exec($sql);

	if($Result){
	
		$Success=1;
	}
	else{

		$Success=0;
	}*/

	$res = ["Log" => $sql];
	echo json_encode($res);
	
?>
