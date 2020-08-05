<?php

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");

	/* Récupération de la liste des réalisations */

	$Realisation=array();
	$Counter=0;
	$Result=0;

	$sql="select * from realisation where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$Realisation[$Counter][0]=$row['ID'];
		$Realisation[$Counter][1]=$row['Title'];
		$Realisation[$Counter][2]=$row['Description'];
		$Realisation[$Counter][3]=$row['Picture'];							
		$Counter++;
	}

	if($Counter>0){

		$Result=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Profile','GetRealisation',1)";
		$Result=$base->exec($sql);
		$res = ["Success" => $Result, "NbOfRealisation" => $Counter, "Realisation" => $Realisation];
		echo json_encode($res);
	}

	if($Counter==0){

		$Result=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Profile','GetRealisation',1)";
		$Result=$base->exec($sql);
		$res = ["Success" => $Result, "NbOfRealisation" => $Counter];
		echo json_encode($res);
	}



?>