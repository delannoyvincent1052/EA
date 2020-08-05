<?php
	
	/* Cette fonction va permettre de créer un nouveau devis */
	
	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationName=$_POST['QuotationName'];
	$CustomerID=$_POST['CustomerID'];
	
	require("common.php");	

	$Success=0;
	$ExistingQuotation=0;

	if ($QuotationName!=''){

		/* On teste pour savoir si un nom de devis identique n'existe pas déjà */

		$sql="select * from quotations where QuotationName='".$QuotationName."' and OwnerID=".$WorkerID;

		foreach  ($base->query($sql) as $row) {
		
			$ExistingQuotation=1;
			
		}	

		if($ExistingQuotation==0){

			/* On peut créer le nouveau devis */

			$CreationDate=date("Ymd");
			$sql="insert into quotations (QuotationName,Customer,Date,Status,OwnerID) values ('".$QuotationName."',".$CustomerID.",'".$CreationDate."',1,".$WorkerID.");";
			$Result=$base->exec($sql);

			if($Result){

				$Success=1;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationCreation',1)";
				$Result=$base->exec($sql);
			}
			if(!$Result){

				$Success=0;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationCreation',0)";
				$Result=$base->exec($sql);
			}
		}



	}

	$res = ["Success" => $Success, "ExistingQuotation" => $ExistingQuotation];
	echo json_encode($res);

?>