<?php 

/* Cette fonction va permettre de remonter les information de chaque élément d'un devis dans le div DisplayQuotationDetail */

	session_start();

	$QuotationID=$_POST['QuotationID'];
	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];

	require("common.php");

	if($QuotationID>0){

		/* Récupération de l'ensemble des lignes d'un devis */

		$ListOfItemsInQuotation=array();
		$Counter=0;

		$sql="select * from quotationitemcategorylink where QuotationID=".$QuotationID." order by QuotationCategory";

		foreach  ($base->query($sql) as $row) {
		
			$ListOfItemsInQuotation[$Counter][0]=$row['LinkID'];
			$ListOfItemsInQuotation[$Counter][1]=$row['QuotationItem'];
			$ListOfItemsInQuotation[$Counter][2]=$row['QuotationCategory'];
			$ListOfItemsInQuotation[$Counter][3]=$row['QuantityItem'];
			$ListOfItemsInQuotation[$Counter][4]=$row['ItemProposedPrice'];
			$ListOfItemsInQuotation[$Counter][5]=$row['ItemProposedTVA'];

			$sql2="select * from quotationitem where ID=".$row['QuotationItem'];

			foreach ($base->query($sql2) as $row2){

				$ItemName=$row2['Name'];
				$ItemDescription=$row2['Description'];
				$Price=$row2['Price'];
				$Unit=$row2['Unit'];


			}

			$ListOfItemsInQuotation[$Counter][6]=$ItemName;
			$ListOfItemsInQuotation[$Counter][7]=$ItemDescription;
			$ListOfItemsInQuotation[$Counter][8]=$Price;
			$ListOfItemsInQuotation[$Counter][9]=$Unit;

			$sql3="select * from quotationcategory where ID=".$row['QuotationCategory'];

			foreach ($base->query($sql3) as $row3){

				$ItemCategory=$row3['CategoryName'];

			}

			$ListOfItemsInQuotation[$Counter][8]=$ItemCategory;			

			$Counter++;


									
		}

		$NumberOfLinkedItems=$Counter;

	}


	$res = ["Success" => 1, "NumberOfLinkedItems" => $NumberOfLinkedItems, "ListOfItemsInQuotation" => $ListOfItemsInQuotation];
	/*$res = ["Success" => 1, "NumberOfLinkedItems" => $NumberOfLinkedItems, "ListOfItemsInQuotation" => $QuotationID];*/
	echo json_encode($res);


?>