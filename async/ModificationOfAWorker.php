<?php

	session_start();
	

	$FirstName=$_POST['FirstName'];
	$LastName=$_POST['LastName'];
	$CompanyName=$_POST['CompanyName'];
	$SocialName=$_POST['SocialName'];
	$RCSNumber=$_POST['RCSNumber'];
	$Address1=$_POST['Address1'];
	$Address2=$_POST['Address2'];
	$CP=$_POST['CP'];
	$City=$_POST['City'];
	$Tel1=$_POST['Tel1'];
	$Tel2=$_POST['Tel2'];
	$WorkerEmail=$_POST['Email'];
	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];

	
	require("common.php");

  	$sql="update worker set FirstName='".$FirstName."',LastName='".$LastName."',CompanyName='".$CompanyName."',RCSNumber='".$RCSNumber."',LegalAddress1='".$Address1."',LegalAddress2='".$Address2."',CP='".$CP."',City='".$City."',Tel1='".$Tel1."',Tel2='".$Tel2."',Email='".$WorkerEmail."' where ID=".$WorkerID;
  	
  	$Result=$base->exec($sql);

	if($Result){

		$Status=1; 
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','ProfileModification',1)";
		$Result=$base->exec($sql);
	}
	if(!$Result){

		$Status=0; 
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','ProfileModification',0)";
		$Result=$base->exec($sql);
	}	
	
	$res = ["Success" => $Status];
	echo json_encode($res);

?>