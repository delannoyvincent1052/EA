<?php

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");

	/* Récupération du nom du logo actuel */

	$LogoName='';
	$Result=0;

	$sql="select LogoName from worker_add where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$LogoName=$row['LogoName'];
		if($LogoName!=''){
			$Result=1;
		}
									
	}

	if($Result==1){

		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Profile','GetLogoName',1)";
		$Result=$base->exec($sql);

	}

	if($Result==0){

		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Profile','GetLogoName',0)";
		$Result=$base->exec($sql);

	}

	$res = ["Success" => $Result, "LogoName" => $LogoName];
	echo json_encode($res);

?>