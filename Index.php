<?php
	session_start();
	if ($_GET['Session']!=session_id())
	{
			header("Location: Login.html");
	}

	$Email=$_GET['Email'];
	$Session=$_GET['Session'];
?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>E-Artisan</title>
			<LINK rel="stylesheet" type="text/css" href="css/style2.css">
			<script type = "text/javascript" src = "/js/Home.js" ></script>
			<script type = "text/javascript" src = "/js/CatalogItems.js" ></script>
			<script type = "text/javascript" src = "/js/QuotationDetails.js" ></script>
			<script type = "text/javascript" src = "/js/Customers.js" ></script>
			<script type = "text/javascript" src = "/js/Profile.js" ></script>
			<script type = "text/javascript" src = "/js/Invoices.js" ></script>
			<script type = "text/javascript" src = "/js/CustomPage.js" ></script>

		</head>
	<body>

		<div id="conteneur">
		<h1 id="header" style="text-align: right"><a href="Disconnect.php" title="I-Artisan - Administration"><span>Déconnexion</span></a>
			<div id="TableLogin">
				<table>
						<tr>
							<td><center><img src="img/logoiart-60p.png" class="LogoLogin"  /></center></td>
						</tr>
						<tr>
							<td><center><br><br><br><br><?php echo "Utilisateur :"?></center><center><div id="LoggedUser"><?php echo $Email ?></div></center><div style="visibility: hidden" id="UserSession"><?php echo $Session ?></div></td>
						</tr>
						
				</table>
			</div>
		</h1>
	
		    <nav>
		      <ul id="menu">
		        <li><a href="#" id="Customers" onclick="DisplayCustomersFunction()">Clients</a></li>
		        <li><a href="#" id="Quotations" onclick="DisplayQuotationsFunction()">Devis</a></li>
		        <li><a href="#" id="Invoices" onclick="DisplayInvoicesFunction()">Factures</a></li>
		        <li><a href="#" id="Catalog" onclick="DisplayCatalogFunction()">Catalogue</a></li>
		        <li><a href="#" id="Profile" onclick="DisplayProfileFunction()">Profil</a></li>
		      </ul>
		    </nav>

	<!-- *********************************************************************************************************** -->
	<!-- DEBUT AFFICHAGE -->
	<!-- *********************************************************************************************************** -->

	<div id="contenu">
		

	<!-- *********************************************************************************************************** -->
	<!-- Affichage du dashboard initial -->
	<!-- *********************************************************************************************************** -->
	
		<div id ="DisplayHome" style="width:300; height:700; overflow:auto; border:solid 0px black; display:block">
			<br><br>
			<center><div id="DisplayHomeFeatures">
				<center><table>
					<tr>
						<td width="150"><div style="text-align: right"><img src="img/Home_1.png" class="LogoLogin"  /></div></td>
						<td width="500"><div style="text-align: left"><h4>Renseignez votre profil</h4></div></td>
					</tr>
					<tr>
						<td width="150"><div style="text-align: right"><img src="img/Home_2.png" class="LogoLogin"  /></div></td>
						<td width="500"><div style="text-align: left"><h4>Créez votre catalogue et vos catégories</h4></div></td>
						
					</tr>
					<tr>
						<td width="150"><div style="text-align: right"><img src="img/Home_3.png" class="LogoLogin"  /></div></td>
						<td width="500"><div style="text-align: left"><h4>Déclarez vos clients</h4></div></td>
					</tr>
					<tr>
						<td width="150"><div style="text-align: right"><img src="img/Home_4.png" class="LogoLogin"  /></div></td>
						<td width="500"><div style="text-align: left"><h4>Créez et transmettez automatiquement vos devis</h4></div></td>
						
					</tr>
					<tr>
						<div id="QuotationsToHaveAttention"></div>
					</tr>

				</table></center>

			</div></center>

			<br>
			
		</div>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage Factures -->
	<!-- *********************************************************************************************************** -->

		<div id ="DisplayInvoices" style="width:300; height:700; overflow:auto; border:solid 0px black; display:none">
			<br><br>
			<center><div id="DisplayExistingInvoices"></div></center>
			<br>
			<div id="StatusInvoices"></div>
			<br>
		</div>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage devis -->
	<!-- *********************************************************************************************************** -->


		<div id ="DisplayQuotations" style="width:300; height:700; overflow:auto; border:solid 0px black; display:none">
			<br>
			<div id="DisplayQuotationList"></div>
				<br>
				<h2>Nouveau Devis</h2>
				<center><table>
					<tr><th width="250">Nom du devis : </th><td width="400"><a href="#" class="info"><input type="text" id="LoadQuotationName" name="QuotationName" class="QuotationInput" placeholder="Le nom que doit porter ce devis" size="50"><div>Ce champ est obligatoire.<br>Seuls les lettres, chiffres et caractères accentués sont admis.</div></a></td><td><div id="QuotationNameError"></div></td></tr>
					<tr><th width="250">Client : </th><td><div id="LoadQuotationCustomer"></div></td><td></td></tr>
					<tr><td colspan="2"><center><input type="button" value="Créer" onclick="CreateQuotation()"></center></td></tr>
				</table></center>
				<center><div id="QuotationCreationResult"></div></center>
					
				<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
				<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>	

			<br>
			
			<div id="DisplayQuotationDetail"></div>
		</div>


	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage Catalogue -->
	<!-- *********************************************************************************************************** -->

		<div id ="DisplayCatalog" style="width:300; height:700; overflow:auto; border:solid 0px black; display:none">
			<br>
			<h2>Eléments du catalogue</h2>
			<div id="DisplayCatalogItems"></div>
			<br>	
			<h3>Ajout d'éléments</h3>						
			<center><table>
			
				<tr><th width="250"><div style="text-align: right">Nom : </div></th><td><input type="text" id="LoadItemName" name="ItemName"></td></tr>
				<tr><th width="250"><div style="text-align: right">Description : </div></th><td><input type="text" id="LoadItemDescription" name="ItemDescription"></td></tr>
				<tr><th width="250"><div style="text-align: right">Prix client: </div></th><td><input type="text" id="LoadItemPrice" name="ItemPrice"></td></tr>
				<tr><th width="250"><div style="text-align: right">Unité : </div></th><td><input type="text" id="LoadItemUnit" name="ItemUnit"></td></tr>
				<tr><th width="250"><div style="text-align: right">Prix d'achat : </div></th><td><input type="text" id="LoadItemBuyingPrice" name="ItemBuyingPrice"></td></tr>
				
				<tr><td colspan="2"><center><input type="button" value="Créer" onclick="CreateNewCatalogElement()"><input type="button" value="Mettre à jour" onclick="UpdateSelectedItem()"></center></td></tr>
			</table></center>

			<br><br>

			<h2>Catégories</h2>

			<div id="DisplayExistingCategories"></div><br>
			<h3>Ajout d'une catégorie</h3>
			<center><table>

				
				
				<tr><th width="250"><div style="text-align: right">Nom : </div></th><td><input type="text" id="LoadCategoryName" name="CategoryName"></td></tr>
				<tr><td colspan="2"><center><input type="button" value="Créer" onclick="CreateCategory()"></center></td></tr>

			</table></center>
			<br>
							
		</div>

			<input type="hidden" id="LoadItemID" name="ItemID"><br>
			<input type="hidden" id="LoadProfileID" name="ID"><br>
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
			<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
			
		<br>
		

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage Profil -->
	<!-- *********************************************************************************************************** -->

		<div id ="DisplayProfile" style="width:300; height:700; overflow:auto; border:solid 0px black; display:none">
			
			<h2>Mes informations</h2>
			
			<table id="StandardForm">
			
				<tr><th width="250"><div style="text-align: right">Prénom : </div></th><td width="400"><input type="text" id="LoadProfileFirstName" name="FirstName" class="ProfileInput" maxlength="15"></td><td width="340" id="ProfileError" rowspan="12"></td></tr>
				<tr><th width="250"><div style="text-align: right">Nom : </div></th><td width="400"><input type="text" id="LoadProfileLastName"name="LastName" class="ProfileInput" maxlength="15"></td></tr>
				<tr><th width="250"><div style="text-align: right">Société : </div></th><td width="400"><input type="text" id="LoadProfileCompanyName"name="CompanyName" class="ProfileInput" maxlength="255"></td></tr>
				<tr><th width="250"><div style="text-align: right">Raison Sociale : </div></th><td width="400"><input type="text" id="LoadProfileSocialName"name="SocialName" class="ProfileInput" maxlength="10"></td></tr>
				<tr><th width="250"><div style="text-align: right">SIRET : </div></th><td width="400"><input type="text" id="LoadProfileRCSNumber"name="RCSNumber" class="ProfileInput" maxlength="50"></td></tr>
				<tr><th width="250"><div style="text-align: right">Addresse 1 : </div></th><td width="400"><input type="text" id="LoadProfileAddress1" name="Address1" class="ProfileInput" maxlength="250"></td></tr>
				<tr><th width="250"><div style="text-align: right">Addresse 2 : </div></th><td width="400"><input type="text" id="LoadProfileAddress2" name="Address2" class="ProfileInput" maxlength="250"></td></tr>
				<tr><th width="250"><div style="text-align: right">CP : </div></th><td width="400"><input type="text" id="LoadProfileCP" name="CP" class="ProfileInput" maxlength="5"></td></tr>
				<tr><th width="250"><div style="text-align: right">Ville : </div></th><td width="400"><input type="text" id="LoadProfileCity" name="City" class="ProfileInput" maxlength="100"></td></tr>
				<tr><th width="250"><div style="text-align: right">Tel1 : </div></th><td width="400"><input type="text" id="LoadProfileTel1" name="Tel1" class="ProfileInput" maxlength="12"></td></tr>
				<tr><th width="250"><div style="text-align: right">Tel2 : </div></th><td width="400"><input type="text" id="LoadProfileTel2" name="Tel2" class="ProfileInput" maxlength="12"></td></tr>
				<tr><th width="250"><div style="text-align: right">Email : </div></th><td width="400"><input type="text" id="LoadProfileEmail" name="Email" class="ProfileInput" maxlength="255"></td></tr>
			
				<tr><td colspan="2"><div id="ButtonCustomers"><br><center><input type="button" value="Modifier" onclick="ModifyProfile()"></center></div></td></tr><br>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div>Ces champs reprennet les informations entrées lors de votre inscription.<br> Vous pouvez les modifier et cliquer sur le bouton "Enregister" pour les modifier<br>(Cas de déménagement ou de changement de numéro par exemple)</div></a></center></td></tr>
			
			</table><br>

			<h2>Ma catégorie d'activité</h2>

			<table>
				<tr><th width="250"><div style="text-align: right">Mes catégories actuelles :</div></th><td width="400"><div id="ActualActivityCategory"></div></td></tr>
				<tr>
					<th width="250"><div style="text-align: right">Choisissez vos categories :</div></th><td width="400"><div id="ActivityCategoryList"></div><input type="button" value="Ajouter" onclick="AddActivityCategory()"></td>
					<td width="340" id="ActivityCategoryError"><div id="ActivityCategoryError"></div></td>
				</tr>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div>Renseigner les catégories dans votre profil, vous permettra<br>d'apparaitre des les recherches des utilisateurs du site.</div></a></center></td></tr>
			</table><br>

			<h2>Mon Mot de passe</h2>
			<table>

				<tr><th width="250"><div style="text-align: right">Nouveau mot de passe :</div></th><td width="400"><input type="text" id="NewPassword1" name="NewPassword1" class="ProfileInput" maxlength="12"></td><td width="340" id="NewPassword1Error" rowspan="2" height="100"></td></tr>
				<tr><th width="250"><div style="text-align: right">Entrez à nouveau le mot de passe :</div></th><td width="400"><input type="text" id="NewPassword2" name="NewPassword2" class="ProfileInput" maxlength="12"></td></tr>
				<tr><td colspan="2"><center><input type="button" value="Modifier" onclick="ChangePassword()"></center></td></tr>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div>Afin d'assurer la sécurité de votre compte, nous vous recommandons de changer<br>votre mot de passe régulièrement.<br>Ce mot de passe doit ne doit contenir que des lettres et des chiffres<br>et doit être d'une longueur de 8 caractères minimum.</div></a></center></td></tr>

			</table>

			<h2>Mon logo</h2>
			<table>
				<tr><th width="250"><div style="text-align: right">Logo actuel :</div></th><td width="400"><div id="ActualLogo" style="text-align:left"></div></td><td width="340" id="WorkerLogoError"></td></tr>
				<tr><th width="250"><div style="text-align: right">Fichier logo :</div></th><td width="400"><input type="file" id="WorkerLogo" name="WorkerLogo" class="ProfileInput" maxlength="12"></td><td width="340" id="WorkerLogoError"></td></tr>
				<tr><td colspan="2"><center><input type="button" value="Charger" onclick="UploadLogo()"></center></td><td id="LogoError"></td></tr>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div>Votre logo sera utilisé pour personnaliser votre page perso et pour personnaliser<br>les devis qui seront transmis à vos clients.</div></a></center></td></tr>
			</table>

			<h2>Mon activité</h2>
			<table>
				<tr><th width="250"><div style="text-align: right">Votre activité :</div></th><td width="400"><center><textarea id="MyActivity" cols="46" rows="12" style="resize:none"></textarea></center></td><td width="340" id="ActivityError"></td></td></tr>
				<tr><td colspan="2"><center><input type="button" value="Valider" onclick="SetActivityDescription()"></center></td></tr>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div>Cette description sera utilisé pour personnaliser votre page perso et pour personnaliser<br>les devis qui seront transmis à vos clients.<br>Vous disposez d'un maximum de 500 caractères pour la renseigner.</div></a></center></td></tr>
			</table>

			<h2>Mes réalisations</h2>
			<table>
				<tr><th width="250"><div style="text-align: right">Titre :</div></th><td width="400"><input type="text" id="RealisationTitle" name="RealisationTitle" class="ProfileInput" maxlength="250" size="46"></td><td width="340" id="RealisationError" rowspan="3"><div id="RealisationError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">Description :</div></th><td width="400"><textarea cols="46" rows="5" id="RealisationDescription" style="resize:none"></textarea></td></tr>
				<tr><th width="250"><div style="text-align: right">Photo de la réalisation :</div></th><td width="400"><input type="file" id="RealisationPicture" name="RealisationPicture" class="ProfileInput" maxlength="12"></td></td></tr>
				<tr><td colspan="2"><center><input type="button" value="Ajouter" onclick="AddRealisation()"></center></td></tr>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div style="text-align: left">Vos réalisations seront utilisées pour personnaliser votre page personnelle.<br>Nous vous conseillons de visualiser toujours vos réalisations avant de générer<br>votre page perso.</div></a></center></td></tr>
			</table>
			<div id="RealisationList"></div>
			<div id="RealisationDetail"></div>

			<h2>Ma page perso</h2>
			<table>
				<tr><th width="250"><div style="text-align: right">Page perso actuelle :</div></th><td width="400"><div id="ActualCustomPage"></div></td></td></tr>
				<tr>
					<th width="250"><div style="text-align: right">Choisissez votre modèle :</div></th>
					<td width="400"><select id="TmplCustomPageSelector">
						<option value="1">Classique</option>
						<option value="2">Moderne</option>
					</select>
					<input type="button" value="Visualiser" onclick="ViewTmplCustomPage()"><input type="button" value="Générer" onclick="GenerateCustomPage()">	</td>
					<td width="340" id="CustomPageError"><div id="CustomPageError"></div></td>
				</tr>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div style="text-align: left">Votre page personnelle est une page web publique pour laquelle vous pouvez<br>communiquer l'adresse à vos clients et prospects.<br>Elle leur permettra de vous connaitre et de voir vos réalisations.</div></a></center></td></tr>
			</table>

			<h2>Mon RIB</h2>

			<table>
				<tr><td width="250"><div style="text-align: right"></div></td><td width="400"><div id="ActualRIB"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">Nom du RIB :</div></th><td width="400"><input type="text" id="RIBName" name="RIBName" class="ProfileInput" maxlength="100" size="50"></td><td width="340" id="RIBNameError"><div id="RIBNameError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">Prénom :</div></th><td width="400"><input type="text" id="RIBFirstName" name="RIBFirstName" class="ProfileInput" maxlength="100" size="50"></td><td width="340" id="RIBFirstNameError"><div id="RIBFirstNameError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">Nom :</div></th><td width="400"><input type="text" id="RIBLastName" name="RIBLastName" class="ProfileInput" maxlength="100" size="50"></td><td width="340" id="RIBLastNameError"><div id="RIBLastNameError" style="color:#ff0000;"></div></td></tr>
				<tr>
					<th width="250"><div style="text-align: right">Banque :</div></th>
					<td width="400"><select id="RIBBankName">
						<option value="1">Caisse d'Epargne</option>
						<option value="2">Crédit Agricole</option>
						<option value="3">Société Générale</option>
					</select>
				</td></tr>
				<tr><th width="250"><div style="text-align: right">Code banque :</div></th><td width="400"><input type="text" id="RIBBankCode" name="RIBBankCode" class="ProfileInput" maxlength="5" size="5"></td><td width="340" id="RIBBankCodeError"><div id="RIBBankCodeError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">Code guichet :</div></th><td width="400"><input type="text" id="RIBGuichetCode" name="RIBGuichetCode" class="ProfileInput" maxlength="4" size="4"></td><td width="340" id="RIBGuichetCodeError"><div id="RIBGuichetCodeError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">Numéro de compte :</div></th><td width="400"><input type="text" id="RIBAccountNumber" name="RIBAccountNumber" class="ProfileInput" maxlength="30" size="30"></td><td width="340" id="RIBAccountNumberError"><div id="RIBAccountNumberError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">Clé :</div></th><td width="400"><input type="text" id="RIBAccountKey" name="RIBAccountKey" class="ProfileInput" maxlength="2" size="2"></td><td width="340" id="RIBAccountKeyError"><div id="RIBAccountKeyError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">IBAN :</div></th><td width="400"><input type="text" id="RIBIBAN" name="RIBIBAN" class="ProfileInput" maxlength="50" size="50"></td><td width="340" id="RIBIBANError"><div id="RIBIBANError" style="color:#ff0000;"></div></td></tr>
				<tr><th width="250"><div style="text-align: right">SWIFT :</div></th><td width="400"><input type="text" id="RIBSWIFT" name="RIBSWIFT" class="ProfileInput" maxlength="10" size="10"></td><td width="340" id="RIBSWIFTError"><div id="RIBSWIFTError" style="color:#ff0000;"></div></td></tr>


				<tr><td colspan="2"><center><input type="button" value="Enregistrer le RIB" onclick="RIBRegistration()"></center></td></tr>
				<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div style="text-align: left">Votre RIB sera utilisé pour que vos clients puisse effectuer des paiements en ligne.</div></a></center></td></tr>

			</table>

			<h2>Mon abonnement</h2>
			<center><div id="ActualSubscription"></div></center>
			<div id="SubscriptionForm">
				<table>

					<tr><th width="250"><div style="text-align: right">Votre choix de formule :</div></th>

						<td width="400">
							<div>
								  <input type="radio" id="Basic" name="SubscriptionSelection" value="Basic - Annuaire - Page perso" onchange="DisplayPaymentSelection('Basic')"><label for="Basic">Basic : Annuaire - Page perso</label>
							</div>
						
							<div>
								  <input type="radio" id="Advanced" name="SubscriptionSelection" value="Complet - Annuaire - Page perso - Gestion des devis" checked onchange="DisplayPaymentSelection('Advanced')"><label for="Advanced">Complet : Annuaire - Page perso - Gestion des devis</label>
							</div><br>
							<div>
								
								<div id="PaymentSelection"></div>
																 
							</div>
						</td>
					</tr>
					<tr>
		
						<td colspan="2"><div style="text-align: center"><input type="button" value="Valider" onclick="SubscriptionValidation()"></div></td>
						<td width="340" id="CustomPageError"><div id="CustomPageError"></div></td>
					</tr>
					<tr><td colspan="3"><center><a href="#" class="info"><img src="img/Help.png" class="LogoLogin"  /><div style="text-align: left">Votre sélection va déterminer votre niveau d'accès à la plateforme et va valider votre<br>niveau d'abonnement.</div></a></center></td></tr>
				</table>
			</div>

		<input type="hidden" id="LoadProfileID" name="ID"><br>
		<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>"><br>
		<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>"><br>
				
		<br>
	</div>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage Customers -->
	<!-- *********************************************************************************************************** -->

	<div id ="DisplayCustomers" style="width:300; height:700; overflow:auto; border:solid 0px black; display:none">
		<div id="DisplayCustomersList"></div><br>
		<h2>Création / Modification client</h2>
		
		<div><center><table>
			<tr><td colspan="3"><center><div id="CustomerCreationUpdateMessage"></div></center></td></tr>		
			<tr><td></td><td><input type="hidden" id="LoadID" name="CustomerID"></td></tr>
			<tr><th width="250">Prénom : </th><td><input type="text" id="LoadFirstName" name="FirstName" class="CustomerInput"></td><td><div id="CustomerFirstNameError"></div></td></tr>
			<tr><th width="250">Nom : </th><td><input type="text" id="LoadLastName"name="LastName" class="CustomerInput"></td><td><div id="CustomerLastNameError"></div></td></tr>
			<tr><th width="250">Addresse 1 : </th><td><input type="text" id="LoadAddress1" name="Address1" class="CustomerInput"></td><td><div id="CustomerAddress1Error"></div></td></tr>
			<tr><th width="250">Addresse 2 : </th><td><input type="text" id="LoadAddress2" name="Address2" class="CustomerInput"></td><td><div id="CustomerAddress2Error"></div></td></tr>
			<tr><th width="250">CP : </th><td><input type="text" id="LoadCP" name="CP" class="CustomerInput"></td><td><div id="CustomerCPError"></div></td></tr>
			<tr><th width="250">Ville : </th><td><input type="text" id="LoadCity" name="City" class="CustomerInput"></td><td><div id="CustomerCityError"></div></td></tr>
			<tr><th width="250">Tel1 : </th><td><input type="text" id="LoadTel1" name="Tel1" class="CustomerInput"></td><td><div id="CustomerTel1Error"></div></td></tr>
			<tr><th width="250">Tel2 : </th><td><input type="text" id="LoadTel2" name="Tel2" class="CustomerInput"></td><td><div id="CustomerTel2Error"></div></td></tr>
			<tr><th width="250">Email : </th><td><input type="text" id="LoadEmail" name="Email" class="CustomerInput"></td><td><div id="CustomerEmailError"></div></td></tr>
			<tr><td colspan="2"><center><input type="button" value="Créer" onclick="CreateANewCustomer()"><input type="button" value="Mettre à jour" onclick="UpdateSelectedCustomer()"></center></td></tr>
			<tr><td colspan="2"><div id="CreationCustomerMessage"></div></td>
			</table></center><br>
			<input type="hidden" id="LoadID" name="ID">
			<input type="hidden" name="WorkerSession" type="hidden" value="<?php echo $Session ?>">
			<input type="hidden" name="WorkerEmail" type="hidden" value="<?php echo $Email ?>">
		
		</table></center></div>
	</div>

	<!-- *********************************************************************************************************** -->
	<!-- Page d'affichage de modification de Devis -->
	<!-- *********************************************************************************************************** -->

		<div id ="DisplayQuotationModification" style="width:300; height:700; overflow:auto; border:solid 0px black; display:none">
			
			<center><table>
				<th colspan="3"><center>Detail de devis</center></th>
			</table></center>
			
			<!-- Affichage des champs d'ajout de produits dans une quotation -->

			<center>
				<table>
					<tr>
						<td colspan="5"><hr></td>
					</tr>
					<tr>
						<td colspan="5"><h3>Ajout d'éléments au devis</h3></td>
					</tr>
					<tr>
						<td>
							<div id="QuotationDetail_ListOfCategories"></div>
						</td>
						<td>
							<div id="QuotationDetail_ListOfItems"></div>
						</td>
						<td> TVA : 
							<select id="TVASelector" onchange="DisplayItemPrice()">
								<option value="5">5%</option>
								<option value="10">10%</option>
								<option value="20" selected="selected">20%</option>
							</select>						
						</td>
						<td> Remise :
							<select id="Discount" onchange="DisplayItemPrice()">
								<option value="0">0%</option>
								<option value="5">5%</option>
								<option value="10">10%</option>
								<option value="15">15%</option>
								<option value="20">20%</option>
								<option value="25">25%</option>
								<option value="30">30%</option>
								<option value="35">35%</option>
								<option value="40">40%</option>
								<option value="45">45%</option>
								<option value="50">50%</option>
							</select>
						</td>
						<td width="100"> Quantité :
							<input type="number" name="ItemQuantity" id="ItemQuantity" size="2" min="1" value="1" onchange="DisplayItemPrice()" style="width: 50px">
							
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td><center>Prix client HT : 
							<input type=text name="CustomerPriceHT" value="" disabled="disabled" id="CustomerPriceHT"></center>
						</td>
						<td><center>Prix client TTC : 
							<input type=text name="CustomerPriceTTC" value="" disabled="disabled" id="CustomerPriceTTC"></center>
						</td>
						<td><center>Prix d'achat (unité)
							<input type=text name="ItemBuyingPrice" value="" id="ItemBuyingPrice" disabled="disabled"></center>
						</td>
						<td><center>Marge :
							<div id="Margin"></div></center>
						</td>

					</tr>
						<td colspan="4"><center><input type="button" value="Ajouter" onclick="AddToQuotation()"></center></td>
					<tr>

					</tr>
						<td colspan="4"><hr></td>
					<tr>
					</tr>
				</table>
			</center>

			<!-- Fin -->

			<!-- Affichage de devis -->
			<center>
				<table>
					<tr>
						<td style="border: 0px solid black"><h3>Visualisation du devis</h3></td>
					</tr>
				</table>
			</center>

			<center>
				<table style="border-collapse: collapse;">
					
					<tr>
						<td colspan="2" style="border: 1px solid black"><center><div id="QuotationName"></div></center></td>
					</tr>
					<tr>
						<td style="border: 1px solid black"><div id="CustomerDetail"></div></td><td style="border: 1px solid black"><div id="WorkerDetail"></div></td>
					</tr>
					<tr>
						<td style="border: 1px solid black"><div id="QuotationDate"></div></td><td style="border: 1px solid black">Numéro du devis : <div id="QuotationNumber"></div></td>
					</tr>
				</table>
				<table>
					<tr>
						<td colspan="2"><hr></td>
					</tr>
					<tr>
						<td><center><div id="QuotationTotalHT" style="font-size: large;"></div></center></td><td><center><div id="QuotationTotalTTC" style="font-size: large;"></div></center></td>
					</tr>
					<tr>
						<td colspan="2"><hr></td>
					</tr>
				</table>
							
				<!-- Affichage de la table qui liste des éléments d'un devis (fonction RefreshQuotationDetail) -->		
				<div id="QuotationDetail_ActualQuotation"></div>
				<!-- Fin d'affichage de cette table -->
					
				
					<div id="QuotationDetail_ExistingItems" style="display:none"></div>

				</table>
				<br>
				<table style="border-collapse: collapse;">
					<tr>
						<td style="border: 1px solid black">Conditions et modalités de paiement<br>
							
							<select id="SelectPaymentCondition">
								<option value="1">20% à la commande - Solde sur facturation</option>
								<option value="2">30% à la commande - Solde sur facturation</option>
								<option value="3">40% à la commande - Solde sur facturation</option>
								<option value="4">20% à la commande - Paiement échelonné</option>
								<option value="5">30% à la commande - Paiement échelonné</option>
								
							</select>
							<div id="PaymentCondition"></div>
						</td>

						<td style="border: 1px solid black" width="200">Date & Signature client</td>
					</tr>
				</table>

				<table>
					<tr>

						<td><center><input type="button" value="Générer le devis" onclick="QuotationPDF()"></center></td>

					</tr>
					
				</table>

			</center>

			<!-- Fin Affichage de devis -->

			<!-- Action sur le devis -->

			<div id ="QuotationAction" style="width:300; height:700; overflow:auto; border:solid 0px black; display:none">
			
				
					<center><table>
						<tr>
							<td style="border: 0px solid black"><h3>Actions possibles</h3></td>
						</tr>
						<tr>
							<td style="text-align: right;">Devis générés : </td>
							<td><div id="ListOfGeneratedQuotations"></div></td>
							<td><center><input type="button" value="Visualiser" onclick="VisualizePDF()"></center></td>
							<td><center><input type="button" value="Supprimer" onclick="DeletePDF()"></center></td>
							<td><center><input type="button" value="Transmettre" onclick="SendPDF()"></center></td>
						</tr>
						
					</table></center>
				
			</div>		

		
		</div>

	</div>

	<!-- *********************************************************************************************************** -->
	<!-- FIN AFFICHAGE -->
	<!-- *********************************************************************************************************** -->

    <p id="footer">Réalisation : V. Delannoy - RCS 1234567890 - Email : delannoyvincent@free.fr</p>

    </div>


</body>
</html>