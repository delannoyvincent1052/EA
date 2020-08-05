<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	

	require("common.php");	

	$QuotationList=array();
	$Counter=0;

	$sql="select * from quotationitem where WorkerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$QuotationList[$Counter][0]=$row['ID'];
		$QuotationList[$Counter][1]=$row['Name'];
		$QuotationList[$Counter][2]=$row['Description'];
		$QuotationList[$Counter][3]=$row['Price'];
		$QuotationList[$Counter][4]=$row['Unit'];
		$Counter++;
									
	}

	$Result=1;

	$res = ["Success" => $Result,"Items" => $QuotationList,"NumberOfItems" => $Counter];
	echo json_encode($res);
?>
