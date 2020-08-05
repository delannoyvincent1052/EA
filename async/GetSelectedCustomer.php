<?php

//**************************************************************************************************************
// Fonction pour permet de récupérer les informations sur le client sélectionné
//**************************************************************************************************************

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	$CustomerID=$_POST['CustomerID'];
	

	require("common.php");

	/* Récupération des informations sur l'ID du client récupéré */

	$SelectedCustomerDetail=array();


	$sql="select * from customer where ID=".$CustomerID;
	foreach  ($base->query($sql) as $row) {
		
		$SelectedCustomerDetail[0]=$row['ID'];
		$SelectedCustomerDetail[1]=$row['FirstName'];
		$SelectedCustomerDetail[2]=$row['LastName'];
		$SelectedCustomerDetail[3]=$row['Address1'];
		$SelectedCustomerDetail[4]=$row['Address2'];
		$SelectedCustomerDetail[5]=$row['CP'];
		$SelectedCustomerDetail[6]=$row['City'];
		$SelectedCustomerDetail[7]=$row['Tel1'];
		$SelectedCustomerDetail[8]=$row['Tel2'];
		$SelectedCustomerDetail[9]=$row['Email'];
	}

	$res = ["CustomerDetail" => $SelectedCustomerDetail, "Success" => 1];
	echo json_encode($res);

?>