<?php

	session_start();
	

	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$Address1=$_POST['Address1'];
	$Address2=$_POST['Address2'];
	$CP=$_POST['CP'];
	$City=$_POST['City'];
	$Tel1=$_POST['Tel1'];
	$Tel2=$_POST['Tel2'];
	$CustomerEmail=$_POST['Email'];
	$CustomerID=$_POST['CustomerID'];
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];

	
	require("common.php");

  	$Status=0;

  	if(($FirstName!='')&&($LastName!='')&&($CustomerEmail!='')){

  		
		$sql="update customer set FirstName='".$FirstName."',LastName='".$LastName."',Address1='".$Address1."',Address2='".$Address2."',CP='".$CP."',City='".$City."',Tel1='".$Tel1."',Tel2='".$Tel2."',Email='".$CustomerEmail."' where ID=".$CustomerID.";";
		$Result=$base->exec($sql);

  	}

	if($Result){
		$Status=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Customer','UpdateCustomer',1)";
		$Result=$base->exec($sql);
	}
	if(!$Result){
		$Status=2;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$LoggedUser."','".$CreationDate."','Customer','UpdateCustomer',0)";
		$Result=$base->exec($sql);
	}
	
	
	$res = ["Success" => $Status];
	echo json_encode($res);

?>