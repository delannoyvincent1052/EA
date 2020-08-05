<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	$SubscriptionType=$_POST['SubscriptionType'];
	$Payment=$_POST['PaymentPeriod'];
	$PaymentDate=$_POST['PaymentDate'];

	require("common.php");

	/* vérification de l'existance d'un abonnement */

	$ExistingSubscription=0;
	$sql="select * from subscription where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$ExistingSubscription=1;
									
	}	

	if($ExistingSubscription==0){

		$sql="insert into subscription (Type,Payment,PaymentDate,OwnerID) values ('".$SubscriptionType."',".$Payment.",".$PaymentDate.",".$WorkerID.")";
		$Result=$base->exec($sql);
	}

	if(($ExistingSubscription==0)&&(!Result)){

		$res = ["Success" => 0];
	}
	if(($ExistingSubscription==0)&&(Result)){

		$res = ["Success" => 1];
	}
	if($ExistingSubscription==1){

		$res = ["Success" => 2];
	}

	echo json_encode($res);

?>