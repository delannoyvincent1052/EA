<?php

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");

	/* Récupération de la description de l'activité */

	$ActivityDescription='';
	$Result=0;

	$sql="select ActivityDescription from worker_add where OwnerID=".$WorkerID;
	foreach  ($base->query($sql) as $row) {
		
		$ActivityDescription=$row['ActivityDescription'];
		if($ActivityDescription<>""){
			$Result=1;
		}
											
	}

	if($Result==1){
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Profile','ActivityDefined',1)";
		$Result=$base->exec($sql);
	}

	if($Result==0){
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Profile','ActivityDefined',0)";
		$Result=$base->exec($sql);
	}

	$res = ["Success" => $Result, "Description" => $ActivityDescription];
	echo json_encode($res);

?>
