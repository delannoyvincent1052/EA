<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	

	require("common.php");	

	/* Récupération de l'abonnement actuel */

	$ExistingSubscription=0;

	$sql="select * from subscription where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$ExistingSubscription=1;
		$SubscriptionType=$row['Type'];
		$SubscriptionPayment=$row['Payment'];
		$SubscriptionPaymentDate=$row['PaymentDate'];
									
	}

	if($ExistingSubscription==1){

		$res = ["Success" => 1, "SubscriptionType" => $SubscriptionType, "SubscriptionPayment" => $SubscriptionPayment, "SubscriptionPaymentDate" => $SubscriptionPaymentDate];

	}

	if($ExistingSubscription==0){

		$res = ["Success" => 0];

	}

	echo json_encode($res);

?>