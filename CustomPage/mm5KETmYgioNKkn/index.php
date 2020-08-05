<?php

	
	$WorkerEmail="delannoyvincent@free.fr";
	
	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

  	}

  	catch(exception $e) {

    	die('Erreur '.$e->getMessage());

  	}

  	/* Récupération de l'ID du worker */

  	$sql="select * from Worker where Email='".$WorkerEmail."'";
  	
	foreach  ($base->query($sql) as $row) {
		
		$WorkerID=$row['ID'];
									
	}

?>

<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>E-Artisan - Modèle page client</title>
			<script type = "text/javascript" src = "CustomPage.js" ></script>
		</head>
	<body>
		<div id="delannoyvincent@free.fr" style="visibility: hidden"><?php echo $WorkerEmail ?></div><div style="visibility: hidden" id="UserSession"><?php echo $WorkerSession ?></div>
		
		<center><table width="1000">
			<tr><td colspan="2" width="1000"><center><h1><div id="TmplCompanyName"></div></h1></center><br><hr></td></tr>
				<tr><td colspan="2" width="1000"><center><div id="TmplCompanyDescription"></div></center><br><hr></td></tr>
				<tr><td width="300"><center>Contact</center></td><td width="700"><center>Sur la carte :</center></td></tr>
				<tr><td width="300">
					<center><table>
						<tr><td width="100" style="text-align:right;">Nom :</td><td width="200"><div id="TmplLastName"></div></td></tr>
						<tr><td width="100" style="text-align:right;">Prénom :</td><td width="200"><div id="TmplFirstName"></div></td></tr>
						<tr><td width="100" style="text-align:right;">Addresse :</td><td width="200"><div id="TmplAddress1"></div></td></tr>
						<tr><td width="100" style="text-align:right;">Addresse :</td><td width="200"><div id="TmplAddress2"></div></td></tr>
						<tr><td width="100" style="text-align:right;">CP :</td><td width="200"><div id="TmplCP"></div></td></tr>
						<tr><td width="100" style="text-align:right;">Ville :</td><td width="200"><div id="TmplCity"></div></td></tr>
						<tr><td width="100" style="text-align:right;">Tel :</td><td width="200"><div id="TmplTel1"></div></td></tr>
						<tr><td width="100" style="text-align:right;">Email :</td><td width="200"><div id="TmplEmail"></div></td></tr>
					</table></center>
					
				</td>
				<td>
				<div style="overflow:hidden;width: 700px;position: relative;">
						<iframe width="700" height="440" src="https://maps.google.com/maps?width=700&amp;height=440&amp;hl=en&amp;q=Rouen%2C%20France+(Titre)&amp;ie=UTF8&amp;t=&amp;z=10&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
							
						</iframe>
						<div style="position: absolute;width: 80%;bottom: 10px;left: 0;right: 0;margin-left: auto;margin-right: auto;color: #000;text-align: center;">
							<small style="line-height: 1.8;font-size: 2px;background: #fff;">Powered by <a href="https://embedgooglemaps.com/en/">embedgooglemaps FR</a> & <a href="http://botonmegusta.org/">boton megusta</a>
							</small>
						</div>
						<style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
					</div>
				</td></tr>
				<tr><td colspan="2"><hr></td></tr>
		</table></center>
		
			
			<div id="RealisationList"></div>

		

	</body>
	<script type="text/javascript">window.onload=LoadCustomPage()</script>
	<footer>
		<center><table width="1000">
        	<tr><td><p>© 2018 Gandalf</p></td></tr>
    	</table></center>
    </footer>

	</html>

