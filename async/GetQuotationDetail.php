<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationID=$_POST['QuotationID'];
	
	require("common.php");

  	/* Récupération des informations sur le worker */

  	$sql="select * from Worker where Email='".$WorkerEmail."'";
  	
	foreach  ($base->query($sql) as $row) {
		
		$WorkerID=$row['ID'];
		$CompanyName=$row['CompanyName'];
		$SocialName=$row['SocialName'];
		$RCSNumber=$row['RCSNumber'];
		$LegalAddress1=$row['LegalAddress1'];
		$LegalAddress2=$row['LegalAddress2'];
		$CP=$row['CP'];
		$City=$row['City'];
		$Tel1=$row['Tel1'];
		$Tel2=$row['Tel2'];
									
	}	

	$Status=0;

	/* Récupération du nom du devis */

	$sql="select * from quotations where ID=".$QuotationID;

	foreach  ($base->query($sql) as $row) {
		
		$QuotationName=$row['QuotationName'];
		$CustomerID=$row['Customer'];
		$QuotationDate=$row['Date'];
									
	}	

	/* Récupération du nom du client */

	$sql="select * from customer where ID=".$CustomerID;

	foreach  ($base->query($sql) as $row) {
		
		$CustomerName=$row['LastName']." ".$row['FirstName'];
		$CustomerAddress1=$row['Address1'];
		$CustomerAddress2=$row['Address2'];
		$CustomerCP=$row['CP'];
		$CustomerCity=$row['City'];
		$CustomerTel1=$row['Tel1'];
		$CustomerTel2=$row['Tel2'];
												
	}	

	/* Récupération de la liste des categories */

	$CategoryList=array();
	$Counter=0;

	$sql="select * from quotationcategory where WorkerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$CategoryList[$Counter]=$row['CategoryName'];
												
	}	
	
	$NumberOfCategory=$Counter;

	/* Récupération des items existants dans le devis */

	$ItemList=array();
	$Counter=0;

	$sql="select * from quotationitemcategorylink where QuotationID=".$QuotationID;

	foreach  ($base->query($sql) as $row) {
		
		$ItemID=$row['QuotationItem'];
		$ItemCategory=$row['QuotationCategory'];

		$sqlItem="select * from quotationitem where ID=".$ItemID." and WorkerID=".$WorkerID;

		foreach ($base->query($sqlItem) as $rowItem){

			$ItemName=$rowItem['Name'];
			$ItemDescription=$rowItem['Description'];
			$ItemPrice=$rowItem['Price'];
			$ItemUnit=$rowItem['Unit'];
		}

		$sqlCategory="select * from quotationcategory where ID=".$ItemCategory. " and WorkerID=".$WorkerID;

		foreach ($base->query($sqlCategory) as $rowCategory){

			$CategoryName=$rowCategory['CategoryName'];
			
		}


		$ItemList[$Counter][0]=$ItemName;
		$ItemList[$Counter][1]=$ItemDescription;
		$ItemList[$Counter][2]=$ItemPrice;
		$ItemList[$Counter][3]=$ItemUnit;
		$ItemList[$Counter][4]=$CategoryName;

		$Counter++;
												
	}

	$NumberOfItemInQuotation=$Counter;

	/* Récupération de la liste totale des Items */

	$Counter=0;
	$TotalItemList=array();

	$sql="select * from quotationitem where WorkerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$TotalItemList[$Counter][0]=$row['ID'];
		$TotalItemList[$Counter][1]=$row['Name'];
		$TotalItemList[$Counter][2]=$row['Description'];
		$TotalItemList[$Counter][3]=$row['Price'];
		$TotalItemList[$Counter][4]=$row['Unit'];
		$Counter++;
												
	}	

	$TotalNumberOfItems=$Counter;

	/* Récupération de la liste totale des catégories */

	$Counter=0;
	$TotalCategoryList=array();

	$sql="select * from quotationcategory where WorkerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$TotalCategoryList[$Counter][0]=$row['ID'];
		$TotalCategoryList[$Counter][1]=$row['CategoryName'];
		$Counter++;
												
	}

	$TotalNumberOfCategories=$Counter;


	$res = ["Success" => 1, "QuotationName" => $QuotationName, "QuotationDate" => $QuotationDate, "CustomerName" => $CustomerName, "CustomerAddress1" => $CustomerAddress1, "CustomerAddress2" => $CustomerAddress2, "CustomerCP" => $CustomerCP, "CustomerCity" => $CustomerCity, "CustomerTel1" => $CustomerTel1, "CustomerTel2" => $CustomerTel2, "CompanyName" => $CompanyName, "SocialName" => $SocialName, "RCSNumber" => $RCSNumber, "LegalAddress1" => $LegalAddress1, "LegalAddress2" => $LegalAddress2, "CP" => $CP, "City" => $City, "Tel1" => $Tel1, "Tel2" => $Tel2, "NumberOfCategory" => $NumberOfCategory, "CategoryList" => $CategoryList, "NumberOfItemInQuotation" => $NumberOfItemInQuotation, "ItemListInQuotation" => $ItemList, "TotalNumberOfItems" => $TotalNumberOfItems, "GlobalItemList" => $TotalItemList, "TotalNumberOfCategories" => $TotalNumberOfCategories, "TotalCategoryList" => $TotalCategoryList];
	
	echo json_encode($res);
	
?>