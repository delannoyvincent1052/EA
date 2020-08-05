<?php

	header('Content-Type: text/html; charset=UTF-8');

	session_start();

	require('fpdf.php');

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationID=$_POST['QuotationID'];
	$QuotationTotalHT=$_POST['QuotationTotalHT'];
	$QuotationTotalTTC=$_POST['QuotationTotalTTC'];
	$SelectedPaymentCondition=$_POST['SelectedPaymentCondition'];

	require("common.php");

  	/* Récupération de l'ID du worker et de l'ID du customer et du nom du devis */

  	$sql="select * from quotations where ID=".$QuotationID;

  	foreach  ($base->query($sql) as $row) {
		
		$WorkerID=$row['OwnerID'];
		$CustomerID=$row['Customer'];
		$QuotationName=$row['QuotationName'];
					
	}

	/* Récupération des informations sur le worker */

	$sql="select * from worker where ID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$CompanyName=$row["SocialName"]." ".$row["CompanyName"];
		$LegalAddress1=$row["LegalAddress1"];
		$LegalAddress2=$row["LegalAddress2"];
		$CP=$row["CP"];
		$City=$row["City"];
		$RCSNumber=$row["RCSNumber"];
		$Tel1=$row["Tel1"];

	}

	/* Récupération des informations sur le customer */

	$sql="select * from customer where ID=".$CustomerID;

	foreach  ($base->query($sql) as $row) {
		
		$CustomerName=$row["LastName"]." ".$row["FirstName"];
		$CustomerAddress1=$row["Address1"];
		$CustomerAddress2=$row["Address2"];
		$CustomerCP=$row["CP"];
		$CustomerCity=$row["City"];
					
	}

	/* Récupération des informations sur le contenu du devis */

	$sql="select * from quotationitemcategorylink where QuotationID=".$QuotationID." order by QuotationCategory";
	$ItemCounter=0;
	$ItemInQuotation=array();


	foreach  ($base->query($sql) as $row) {

		
		$sql1="select * from quotationitem where ID=".$row["QuotationItem"];

		foreach ($base->query($sql1) as $row1) {
			
			$ItemInQuotation[$ItemCounter][0]=$row1["Name"];
			$ItemInQuotation[$ItemCounter][1]=$row["QuantityItem"];
			$ItemInQuotation[$ItemCounter][2]=$row["ItemProposedPrice"];
			$ItemInQuotation[$ItemCounter][3]=$row["ItemProposedTVA"];

		}

		$sql2="select * from quotationcategory where ID=".$row['QuotationCategory'];

		foreach ($base->query($sql2) as $row2) {
			
			$ItemInQuotation[$ItemCounter][4]=$row2["CategoryName"];
			
		}

		$ItemCounter++;
					
	}
	
  	/* Contient le nom du devis, le nom du client, le nom de l'artisan										*/
  	/* Le date de création du gupnp_device_action_callback_set(				                                */

  	$pdf = new FPDF();
  	$pdf->AddPage();
  	$pdf->SetFont('Arial','B',15);
	$pdf->MultiCell(190,10,"*** Devis ***\n".$QuotationName,1,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Times','',12);
	$LegalAddress=$LegalAddress1;
	if($LegalAddress2!=""){
		$LegalAddress=$LegalAddress."\n".$LegalAddress2;
	}
	$pdf->MultiCell(95,5,$CompanyName."\n".$LegalAddress."\n".$CP." - ".$City,0,'L',0);
	$pdf->Cell(110,40,"",0,0,'C');
	$CustomerAddress=$CustomerAddress1;
	if($CustomerAddress2!=""){
		$CustomerAddress=$CustomerAddress."\n".$CustomerAddress2;
	}
	$pdf->MultiCell(95,5,$CustomerName."\n".$CustomerAddress."\n".$CustomerCP." - ".$CustomerCity,0,'L',0);
	$Today=date("d-m-Y");
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(190,5,utf8_decode("Devis numéro : ").$WorkerID."-".$QuotationID." / Date : ".$Today,0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(190,1,"",0,0,'C',1);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',22);
	$pdf->Cell(95,10,$QuotationTotalHT,0,0,'C');
	$pdf->Cell(95,10,$QuotationTotalTTC,0,0,'C');
	$pdf->SetFont('Times','',12);
	$pdf->Ln(10);
	$pdf->Cell(190,1,"",0,0,'C',1);
	$pdf->Ln(12);
	$pdf->SetFont('Times','B',8);
	$pdf->Cell(12,7,"Ligne",1,0,'C');
	$pdf->Cell(18,7,utf8_decode("Quantité"),1,0,'C');
	$pdf->Cell(70,7,utf8_decode("Désignation"),1,0,'C');
	$pdf->Cell(25,7,utf8_decode("Prix Unit HT"),1,0,'C');
	$pdf->Cell(15,7,utf8_decode("TVA"),1,0,'C');
	$pdf->Cell(25,7,utf8_decode("Montant HT"),1,0,'C');
	$pdf->Cell(25,7,utf8_decode("Montant TTC"),1,0,'C');
	$pdf->Ln(10);
	$X=$pdf->GetX();
	$Y=$pdf->GetY();
	
	$pdf->MultiCell(190,120,"",1,'L',0);

	$pdf->SetX($X);
	$pdf->SetY($Y);

	/* affichage des lignes du devis */

	$Category="";

	for($Counter=0;$Counter<$ItemCounter;$Counter++){
		if($Category!=$ItemInQuotation[$Counter][4]){
			$pdf->SetFont('Times','BI',8);
			$pdf->MultiCell(190,7,$ItemInQuotation[$Counter][4],1,'L',0);
			$Category=$ItemInQuotation[$Counter][4];
		}
		$pdf->SetFont('Times','I',10);
		$Line=$Counter+1;
		$pdf->Cell(12,7,$Line,0,0,'C');
		/* Quantité */
		$pdf->Cell(18,7,$ItemInQuotation[$Counter][1],0,0,'C');
		/* description */
		$pdf->Cell(70,7,$ItemInQuotation[$Counter][0],0,0,'L');
		/* Prix unitaire */
		$PriceItemHT=$ItemInQuotation[$Counter][2];
		$UnitHTPrice=($ItemInQuotation[$Counter][2])/($ItemInQuotation[$Counter][1]);
		$pdf->Cell(25,7,round($UnitHTPrice,2)." euros",0,0,'C');
		/* TVA */
		$TVA=$ItemInQuotation[$Counter][3];
		$pdf->Cell(15,7,$TVA."%",0,0,'C');
		/* Total HT*/
		$TotalHT=$UnitHTPrice*$ItemInQuotation[$Counter][1];
		$pdf->Cell(25,7,$TotalHT." euros",0,0,'C');
		/* total TTC */
		$TotalTTC=$TotalHT+(($TotalHT*$TVA)/100);
		$pdf->Cell(25,7,$TotalTTC." euros",0,0,'C');
		$pdf->Ln(7);
	}
	$pdf->Ln(5);
	$X=$pdf->GetX();
	$Y=$pdf->GetY();
	$pdf->SetX(10);
	$pdf->SetY(237);
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(95,7,utf8_decode("Conditions et modalités de paiement"),1,0,'C',0);
	$pdf->Cell(95,7,"Date et signature",1,0,'C',0);
	$pdf->Ln(7);
	$pdf->Cell(95,15,utf8_decode($SelectedPaymentCondition),1,0,'C',0);
	$pdf->Cell(95,15,"",1,'C',0);
	$pdf->Ln(20);
	$pdf->SetFont('Arial','I',6);
	$pdf->MultiCell(190,6,$CompanyName." - Immatriculation registre du commerce : ".$RCSNumber."\n".$LegalAddress." - ".$CP." ".$City." - Tel : ".$Tel1." - Email : ".$WorkerEmail,1,'C',0);

	$QuotationDate=date("d")."-".date("m")."-".date("Y");
	$QuotationTime=date("H")."h".date("i")."m".date("s")."s";
	$QuotationFileName="Dev-".$QuotationID.$CustomerID.$WorkerID."-".$QuotationDate."-".$QuotationTime.".pdf";
	$ecriture=$pdf->Output("F","../QuotationPDF/".$QuotationFileName);

	/* Ecriture de la quotation générée dans la table quotationfile */

	$sql="insert into quotationfile(QuotationID,QuotationFileName,QuotationDate,QuotationTime) values (".$QuotationID.",'".$QuotationFileName."','".$QuotationDate."','".$QuotationTime."')";
	$Result=$base->exec($sql);

	if($Result){

		$Status=1;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationPDFCreation',1)";
		$Result=$base->exec($sql);

	}
	if(!$Result){

		$Status=0;
		$CreationDate=date("Ymd");
		$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Quotation','QuotationPDFCreation',0)";
		$Result=$base->exec($sql);

	}


	$res = ["Success"=> $Status, "QuotationID" => $QuotationID, "QuotationFileName" => $QuotationFileName, "QuotationDate" => $QuotationDate, "QuotationTime" => $QuotationTime];
	echo json_encode($res);



?>