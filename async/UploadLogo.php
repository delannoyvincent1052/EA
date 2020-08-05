<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];

	if (isset($_FILES["file"])){


		require("common.php");

		$tmp_name = $_FILES["file"]["tmp_name"];
		$name = $_FILES["file"]["name"];
		move_uploaded_file($tmp_name, "../logos/logo-".$WorkerEmail.".jpg");
		$LogoName="logo-".$WorkerEmail.".jpg";
		$LogoNameRedim="logoRD-".$WorkerEmail.".jpg";
		if(file_exists("../logos/".$LogoNameRedim)){
			unlink("../logos/".$LogoNameRedim);
		}
		$redimOK = fctredimimage(200,140,'../logos/',$LogoName,'../logos/',$LogoNameRedim);
		$Success=0;
		
		if ($redimOK == 1) { 

			$ExistingData=0;

			$sql="select * from worker_add where OwnerID=".$WorkerID;

			foreach  ($base->query($sql) as $row) {
					
				$ExistingData++;
												
			}	

			if($ExistingData==1){

				$sql="update worker_add set LogoName='' where OwnerID=".$WorkerID;
				$Result=$base->exec($sql);

				$sql="update worker_add set LogoName='".$LogoNameRedim."' where OwnerID=".$WorkerID;
																				
			}

			if($ExistingData==0){

				$sql="insert into worker_add(LogoName,ActivityDescription,OwnerID) values ('".$LogoNameRedim."','',".$WorkerID.");";
				
			}

			$Result=$base->exec($sql);
			

			if($Result){
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','UploadLogo',1)";
				$Result=$base->exec($sql);
				$Success=1;
			}

			if(!$Result){
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','UploadLogo',0)";
				$Result=$base->exec($sql);
				$Success=0;
			}

			$res = ["Success" => $Success, "Redimensionnement" => $redimOK];
			echo json_encode($res);
		}		
		else{

			$res = ["Success" => $Success, "Redimensionnement" => False];
			echo json_encode($res);

		}		
	}

	

/************************************************************************************************/
/* Fonction de  redimensionnement d'image */
/************************************************************************************************/

	function fctredimimage($W_max, $H_max, $rep_Src, $img_Src, $rep_Dst, $img_Dst) {
 
 		$condition = 0;
		if ($rep_Dst=='') { $rep_Dst = $rep_Src; } // (même répertoire)
		if ($img_Dst=='') { $img_Dst = $img_Src; } // (même nom)
 // ---------------------
 // si le fichier existe dans le répertoire, on continue...
 if (file_exists($rep_Src.$img_Src) && ($W_max!=0 || $H_max!=0)) { 


   // ----------------------
   // extensions acceptées : 
	$extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
   // extension fichier Source
	$extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));
   // ----------------------
   // extension OK ? on continue ...
   if(in_array($extension_Src, explode(',', $extension_Allowed))) {
     // ------------------------
      // récupération des dimensions de l'image Src
      $img_size = getimagesize($rep_Src.$img_Src);
      $W_Src = $img_size[0]; // largeur
      $H_Src = $img_size[1]; // hauteur
      // ------------------------
      // condition de redimensionnement et dimensions de l'image finale
      // ------------------------
      // A- LARGEUR ET HAUTEUR maxi fixes
      if ($W_max!=0 && $H_max!=0) {
         $ratiox = $W_Src / $W_max; // ratio en largeur
         $ratioy = $H_Src / $H_max; // ratio en hauteur
         $ratio = max($ratiox,$ratioy); // le plus grand
         $W = $W_Src/$ratio;
         $H = $H_Src/$ratio;   
         $condition = ($W_Src>$W) || ($W_Src>$H); // 1 si vrai (true)
      }
      // ------------------------
      // B- HAUTEUR maxi fixe
      if ($W_max==0 && $H_max!=0) {
         $H = $H_max;
         $W = $H * ($W_Src / $H_Src);
         $condition = ($H_Src > $H_max); // 1 si vrai (true)
      }
      // ------------------------
      // C- LARGEUR maxi fixe
      if ($W_max!=0 && $H_max==0) {
         $W = $W_max;
         $H = $W * ($H_Src / $W_Src);         
         $condition = ($W_Src > $W_max); // 1 si vrai (true)
      }
      // ---------------------------------------------
      // REDIMENSIONNEMENT si la condition est vraie
      // ---------------------------------------------
      // - Si l'image Source est plus petite que les dimensions indiquées :
      // Par defaut : PAS de redimensionnement.
      // - Mais on peut "forcer" le redimensionnement en ajoutant ici :
      // $condition = 1; (risque de perte de qualité)
      if ($condition==1) {
         // ---------------------
         // creation de la ressource-image "Src" en fonction de l extension
         switch($extension_Src) {
         case 'jpg':
         case 'jpeg':
           $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
           break;
         case 'png':
           $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
           break;
         }
         // ---------------------
         // creation d une ressource-image "Dst" aux dimensions finales
         // fond noir (par defaut)
         switch($extension_Src) {
         case 'jpg':
         case 'jpeg':
           $Ress_Dst = imagecreatetruecolor($W,$H);
           break;
         case 'png':
           $Ress_Dst = imagecreatetruecolor($W,$H);
           // fond transparent (pour les png avec transparence)
           imagesavealpha($Ress_Dst, true);
           $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
           imagefill($Ress_Dst, 0, 0, $trans_color);
           break;
         }
         // ---------------------
         // REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
         imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src); 
         // ---------------------
         // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
         switch ($extension_Src) { 
         case 'jpg':
         case 'jpeg':
           imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
           break;
         case 'png':
           imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
           break;
         }
         // ------------------------
         // liberation des ressources-image
         imagedestroy ($Ress_Src);
         imagedestroy ($Ress_Dst);
      }
      // ------------------------
   }
 }
 // ---------------------------------------------------
 // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
 if ($condition==1 && file_exists($rep_Dst.$img_Dst)) { 
  
  return true;
}
 else {  
  
  return false; 
}
 // ---------------------------------------------------
};
?>