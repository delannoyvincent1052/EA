<?php

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	

	require("common.php");

	/* Récupération de la liste des devis du Worker */

	$QuotationList=array();

	$Counter=0;

	$sql="select * from quotations where OwnerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {

		$QuotationName=$row['QuotationName'];
		$QuotationList[$Counter][0]=$QuotationName;


		$sql2="select * from customer where ID=".$row['Customer'];
		foreach  ($base->query($sql2) as $row2) {
			$CustomerDetail=$row2['LastName']." - ".$row2['FirstName']." - ".$row2['City'];
		}

		$QuotationList[$Counter][1]=$CustomerDetail;
		$QuotationList[$Counter][2]=$row['Date'];
		$QuotationList[$Counter][3]=$row['Status'];
		$QuotationList[$Counter][4]=$row['ID'];
		
		$Counter++;
											
	}

	$NumberOfQuotations=$Counter;
	$Counter=0;

	$CustomerList=array();

	$sql="select * from customer where OwnerID=".$WorkerID;
	foreach  ($base->query($sql) as $row) {

		$CustomerList[$Counter][0]=$row['ID'];
		$CustomerList[$Counter][1]=$row['LastName'];
		$CustomerList[$Counter][2]=$row['FirstName'];
		$CustomerList[$Counter][3]=$row['CP'];
		$CustomerList[$Counter][4]=$row['City'];
		$Counter++;
	}

	$NumberOfCustomers=$Counter;


	$res = ["Success" => 1,"Quotations" => $QuotationList,"NumberOfQuotations" => $NumberOfQuotations, "CustomerList" => $CustomerList, "NumberOfCustomers" => $NumberOfCustomers];
	
	echo json_encode($res);

?>
