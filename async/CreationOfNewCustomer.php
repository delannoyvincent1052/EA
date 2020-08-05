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
	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];

	/* Contrôle des variables */

	$VarOK=1;
	$VarIssue=array();
	if($FirstName==''){
		$VarOK=0;
		$VarIssue[0]=1;
	}
	if($LastName==''){
		$VarOK=0;
		$VarIssue[1]=1;
	}
	if($CustomerEmail==''){
		$VarOK=0;
		$VarIssue[2]=1;
	}
	
	/* Fin de contrôle des variables */

	require("common.php");
	
	$ExistingCustomer=0;
	$Status=0;

	$sql="select * from customer where FirstName='".$FirstName."' and LastName='".$LastName."' and Tel1='".$Tel1."';";

	foreach  ($base->query($sql) as $row) {
		
		$ExistingCustomer=1;
		$msg=1;
									
	}

	if($ExistingCustomer==0){

			$sql="insert into customer (FirstName,LastName,Address1,Address2,CP,City,Tel1,Tel2,Email,OwnerID) values ('".$FirstName."','".$LastName."','".$Address1."','".$Address2."','".$CP."','".$City."','".$Tel1."','".$Tel2."','".$CustomerEmail."',".$WorkerID.")";
			$Result=$base->exec($sql);

			if($Result){
				$msg=2;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Customer','CreationOfNewCustomer',1)";
				$Result=$base->exec($sql);
			}
			if(!$Result){
				$msg=3;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Customer','CreationOfNewCustomer',0)";
				$Result=$base->exec($sql);
			}
			
	}
	
	$res = ["Success" => $msg];
	echo json_encode($res);

?>