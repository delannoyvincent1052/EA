<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");

	$CategoryList=array();
	$Counter=0;

	$sql="select * from quotationcategory where WorkerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$CategoryList[$Counter][0]=$row['ID'];
		$CategoryList[$Counter][1]=$row['CategoryName'];
		$Counter++;
									
	}

	$Result=1;

	$res = ["Success" => $Result,"Categories" => $CategoryList,"NumberOfCategories" => $Counter];
	echo json_encode($res);

?>
