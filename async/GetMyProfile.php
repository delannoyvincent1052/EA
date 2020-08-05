<?php

	/* Fonction qui sert à AJAX à récupérer la liste des clients déclarés par cet utilisateur*/
	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	

	require("common.php");

  	$WorkerDetail=array();

  	$sql="select * from Worker where Email='".$LoggedUser."';";
  	
	foreach  ($base->query($sql) as $row) {
		
		$WorkerDetail[0]=$row['ID'];
		$WorkerDetail[1]=$row['FirstName'];
		$WorkerDetail[2]=$row['LastName'];
		$WorkerDetail[3]=$row['CompanyName'];
		$WorkerDetail[4]=$row['SocialName'];
		$WorkerDetail[5]=$row['RCSNumber'];
		$WorkerDetail[6]=$row['LegalAddress1'];
		$WorkerDetail[7]=$row['LegalAddress2'];
		$WorkerDetail[8]=$row['CP'];
		$WorkerDetail[9]=$row['City'];
		$WorkerDetail[10]=$row['Tel1'];
		$WorkerDetail[11]=$row['Tel2'];
		$WorkerDetail[12]=$row['Email'];
									
	}
	
	$res = ["Success" => 1,"Worker" => $WorkerDetail];
	echo json_encode($res);
?>