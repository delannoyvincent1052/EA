<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	$ItemSelected=$_POST['ItemSelected'];
	
	require("common.php");

	/* Récupération du prix de l'item sélectionné */

	$sql="select * from quotationitem where ID=".$ItemSelected;

	foreach  ($base->query($sql) as $row) {
		
		$ItemPrice=$row['Price'];
		$ItemBuyingPrice=$row['BuyingPrice'];
									
	}

	$res = ["Success" => 1, "ItemPrice" => $ItemPrice, "ItemBuyingPrice" => $ItemBuyingPrice];
	echo json_encode($res);



?>
