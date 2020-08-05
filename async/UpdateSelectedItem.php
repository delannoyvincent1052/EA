<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$ItemID=$_POST['ItemID'];
	$ItemName=$_POST['ItemName'];
	$ItemDescription=$_POST['ItemDescription'];
	$ItemPrice=$_POST['ItemPrice'];
	$ItemUnit=$_POST['ItemUnit'];
	$ItemBuyingPrice=$_POST['ItemBuyingPrice'];

	require("common.php");

	$Status=0;

	$sql="update quotationitem set Name='".$ItemName."',Description='".$ItemDescription."',Price=".$ItemPrice.",Unit='".$ItemUnit."', BuyingPrice=".$ItemBuyingPrice." where ID=".$ItemID.";";
	$Result=$base->exec($sql);
	  	

	if($Result){

		$Status=1; /* Item bien mis à jour */
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','QuotationItem','QuotationItemUpdate',1)";
		$Result=$base->exec($sql);
	}
	else{

		$Status=0; 
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','QuotationItem','QuotationItemUpdate',0)";
		$Result=$base->exec($sql);
	}

	$res = ["Success" => $Status];
	echo json_encode($res);

?>
