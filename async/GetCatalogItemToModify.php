<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$ItemID=$_POST['ItemID'];

	require("common.php");

	$msg=0;

	$sql="select * from quotationitem where ID=".$ItemID;
	
	foreach  ($base->query($sql) as $row) {
		
		$ItemID=$row['ID'];
		$ItemName=$row['Name'];
		$ItemDescription=$row['Description'];
		$ItemPrice=$row['Price'];
		$ItemUnit=$row['Unit'];
		$ItemBuyingPrice=$row['BuyingPrice'];
		$msg=1;
					
	}

	$res = ["Success" => $msg, "ItemID" => $ItemID, "ItemName" => $ItemName, "ItemDescription" => $ItemDescription, "ItemPrice" => $ItemPrice, "ItemUnit" => $ItemUnit, "ItemBuyingPrice" => $ItemBuyingPrice];
	echo json_encode($res);
?>