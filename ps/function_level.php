<?php

function my_simple_crypt( $string, $action = 'e' ){
	$secret_key = '345RTY#``.,|º12.ç}][psd22#46TS58B74%$/&(!';
    $secret_iv = 'JKASFA!"$$/45623"·%·$%/$){`123$$·&"QWAZCVn';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    if( $action == 'e' ) {$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );}else if( $action == 'd' ){$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );}return $output;
}

function generateRandomString($length = 6){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function linkcon(){
   try {
        $conexion = new PDO("mysql:host=localhost;", "root", my_simple_crypt("","d"));
        return($conexion);
   } catch (PDOException $e) {
        print "<p>Error";
        print "<p>Error: " . $e->getMessage() . "</p>\n";
        exit();
   }
}
function SearchContentLink($x){
	$db = linkcon();
	if(isset($x)&&!Empty($x)){
		$LINKQUERY = $db->query("SELECT * FROM `pilink`.`LINK` WHERE `LINK`.`TITLE` LIKE '%".$x."%' ORDER BY `LINK`.`DATE` DESC LIMIT 9;");	
	}else{
		$LINKQUERY = $db->query("SELECT * FROM `pilink`.`LINK` ORDER BY `LINK`.`DATE` DESC LIMIT 9;");
	}
	$ArrayLINK = array();	
	while($rows=$LINKQUERY->fetch(PDO::FETCH_ASSOC)){$ArrayLINK[] = $rows;}
	return $ArrayLINK;
}

function ListContentLinkSearch(){
	if(!is_null($_POST['SearchContentProcedure'])||$_POST['SearchBoxContentVar']!=""){
		$ArrayLINK = SearchContentLink($_POST['SearchBoxContentVar']);
		$nregistros = sizeof($ArrayLINK);
		for ($i = 0; $i < $nregistros; $i++) {
		print"
		<div class=\"mediabox SelectablePilink\" pilink=\"".$ArrayLINK[$i]['id_link']."\" >
			<table class=\"PilinkTable\">
				<tr>
					<td rowspan=\"2\">
					<span class=\"PostImagePilink ".$ArrayLINK[$i]['IMG']."\" alt=\"pilink\"></span>
					</td>
					<td class=\"DefinedTitle\"><h3>".$ArrayLINK[$i]['TITLE']."</h3></td>
				</tr>
				<tr>
					<td colspan=\"2\"><p>".$ArrayLINK[$i]['TAGS']."</p></td>
				</tr>
			</table>
		</div>
		";
		}
		//$_POST['SearchContentProcedure'] = NULL;
	}else{
		ListContentLink();
	}
}
function ListContentLink(){
	$ArrayLINK = SearchContentLink("");
	$nregistros = sizeof($ArrayLINK);
	for ($i = 0; $i < $nregistros; $i++) {
		print"
		<div class=\"mediabox SelectablePilink\" pilink=\"".$ArrayLINK[$i]['id_link']."\" >
			<table class=\"PilinkTable\">
				<tr>
					<td rowspan=\"2\">
					<span class=\"PostImagePilink ".$ArrayLINK[$i]['IMG']."\" alt=\"pilink\"></span>
					</td>
					<td class=\"DefinedTitle\"><h3>".$ArrayLINK[$i]['TITLE']."</h3></td>
				</tr>
				<tr>
					<td colspan=\"2\"><p>".$ArrayLINK[$i]['TAGS']."</p></td>
				</tr>
			</table>
		</div>
		";
	}
}
if(isset($_POST['SearchContentProcedure'])&&isset($_POST['SearchBoxContentVar'])){
	ListContentLinkSearch();
}


function ShowPilink($Pilink){
	$db = linkcon();
	$LINKQUERY = $db->query("SELECT * FROM `pilink`.`LINK` WHERE `LINK`.`id_link` = '".$Pilink."';");
	$ContentLINK = array();	
	while($rows=$LINKQUERY->fetch(PDO::FETCH_ASSOC)){$ContentLINK[] = $rows;}
	$nregistros = sizeof($ContentLINK);
	for ($i = 0; $i < $nregistros; $i++) {
		print"
		<div class=\"mediabox\">
			<table class=\"PilinkTable\">
				<tr>
					<td rowspan=\"2\">
					<span class=\"PostImagePilink ".$ContentLINK[$i]['IMG']."\" alt=\"pilink\"></span>
					</td>
					<td class=\"DefinedTitle\"><h3>".$ContentLINK[$i]['TITLE']."</h3></td>
				</tr>
				<tr>
					<td colspan=\"2\"><p>10 Oct 2010 - 13:36</p></td>
				</tr>
			</table>
		</div>";
		print"
		<div class=\"mediabox\">
			<table class=\"PilinkTable\">
				<tr>
					<td class=\"\"><h3>".$ContentLINK[$i]['description']."</h3></td>
				</tr>
				<tr>
					<td><p>Description</p></td>
				</tr>
			</table>
		</div>";
		print"
		<div class=\"mediabox\">
			<table class=\"PilinkTable\">
				<tr>
					<td class=\"LongText\"><h3>".$ContentLINK[$i]['TAGS']."</h3></td>
				</tr>
				<tr>
					<td><p>Tags</p></td>
				</tr>
			</table>
		</div>";
		print"
		<div class=\"mediabox\">
			<table class=\"PilinkTable\">
				<tr>
					<td class=\"LongText\"><h3>".$ContentLINK[$i]['longcription']."</h3></td>
				</tr>
				<tr>
					<td><p>Long Description</p></td>
				</tr>
			</table>
		</div>";
		print"
		<div class=\"mediabox\">
			<table class=\"PilinkTable\">
				<tr>
					<td>
						<a href=\"".$ContentLINK[$i]['LINK']."\" target=\"_blank\" >
							<input type=\"button\" class=\"buttonlink\" value=\"&#xf07b;\"/>
						</a>
					</td>
				</tr>
				<tr>
					<td><p>The Link</p></td>
				</tr>
			</table>
		</div>";
	}
}

if(isset($_POST['Pilink'])){
	ShowPilink($_POST['Pilink']);
}

function CreateNewPilink(){
	
	$db = linkcon();
	
	$codeGen = generateRandomString();
	
	//CreateNewLink($codeGen);
	GenerateSTDpilink($codeGen);
	
	$linkCrypt =  my_simple_crypt($_POST['LinkLink'], $action = 'e' );
	
	$pilink = "https://pilink.net/L/".$codeGen."";
		
	$consulta = $db->prepare("INSERT INTO `pilink`.`crypted_link` (`id_owne`, `LINK`, `pilink`, `DATE`) VALUES ('1', '".$linkCrypt."', '".$pilink."', CURRENT_TIMESTAMP);");
	
	$consulta->execute();
	
	$consulta->setFetchMode(PDO::FETCH_ASSOC);
	
	$affected_rows = $consulta->rowCount();
	
	if($affected_rows > 0)
	{
		$consulta2 = $db->prepare("
		INSERT INTO `pilink`.`LINK` (`TITLE`, `TAGS`, `LINK`, `IMG`, `description`, `longcription`) 
		VALUES ('".$_POST['LinkTitle']."', '".$_POST['LinkTags']."', '".$pilink."', '".$_POST['LinkCategory']."', '".$_POST['LinkDesc']."', '".$_POST['LinkDescLong']."')");
		$consulta2->execute();
		$consulta2->setFetchMode(PDO::FETCH_ASSOC);
		$affected_rows2 = $consulta2->rowCount();
		if($affected_rows2 > 0)
		{
			return true;
		}
	}
}

if(isset($_POST['LinkCount'])){
	GetLinkCount();
}

function GetLinkCount(){
	$db = linkcon();
	$LINKQUERY = $db->query("SELECT `crypted_link`.`LINK` FROM `pilink`.`crypted_link` WHERE `crypted_link`.`pilink` = '".$_POST['LinkCount']."';");
	$ContentLINK = array();
	while($rows=$LINKQUERY->fetch(PDO::FETCH_ASSOC)){$ContentLINK[] = $rows;}
	$linkCrypt =  my_simple_crypt($ContentLINK[0]['LINK'], 'd' );
	echo $linkCrypt;
}

function CreateNewLink($ID){
	
	$fichero = fopen("L/".$ID.".php", "w");
	// Abre el fichero para obtener el contenido existente
	$actual = file_get_contents("L/".$ID.".php");
	// Añade una nueva persona al fichero
	$actual .= '<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
			<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
			<title>PILINK</title>
			<meta name="description" content="Pilink: Cryptographic Links" />
			<meta name="keywords" content="Crypt Decrypt Link Links Post Content Library" />
			<meta name="author" content="D" />
			<link rel="shortcut icon" href="../../favicon.ico">
			<link rel="stylesheet" type="text/css" href="../css/component.css" />
		</head>
		<body>
			<div class="container">
				<div id="tabs" class="tabs">
					<div class="content">
						<section id="section-1" style="display:block;">
							<div class="mediabox">
								<h3>Decrypt a Link</h3>
								<p><input type="text" class="inputlink" value="https://pilink.net/L/'.$ID.'" DISABLED /></p>
								<p>This is the link you access.</p>
							</div>
							<div class="mediabox">
								<h3>Password</h3>
								<p><input type="password" class="inputlink" value="" placeholder="Password" /></p>
								<p>Type the password to reveal it.</p>
							</div>
							<div class="mediabox">
								<h3>Link Reveal</h3>
								<p><input type="text" class="inputlink" value="" placeholder="https://**************" DISABLED /></p>
								<p>Paste here the link you want to crypt.</p>
							</div>
						</section>
					</div>
				</div>
				<p class="info">PILINK</p>
			</div>
		</body>
	</html>';
	// Escribe el contenido al fichero
	file_put_contents("L/".$ID.".php", $actual);
}

function GenerateSTDpilink($ID){
	
	$fichero = fopen("L/".$ID.".php", "w");
	// Abre el fichero para obtener el contenido existente
	$actual = file_get_contents("L/".$ID.".php");
	// Añade una nueva persona al fichero
	$actual .= '
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
			<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
			<title>PILINK</title>
			<meta name="description" content="Pilink: Cryptographic Links" />
			<meta name="keywords" content="Crypt Decrypt Link Links Post Content Library" />
			<meta name="author" content="D" />
			<link rel="shortcut icon" href="../../favicon.ico">
			<link rel="stylesheet" type="text/css" href="../css/component.css" />
			<script src="../js/libjquerypilink.js"></script>
		</head>
		<body>
			<div class="container">
				<p class="HeaderLink">PILINK</p>
					<div id="tabs" class="tabs">
							<div class="content">
								<section id="section-1" style="display:block;">
									<div class="mediabox">
										<h3>Pilink</h3>
										<p><input type="text" class="inputlink linkaccess" value="https://pilink.net/L/'.$ID.'" DISABLED /></p>
										<p>Generated pilink</p>
									</div>
									<div class="mediabox">
										<h3 class="centeredmedia">Wait</h3>
										<p><input type="text" class="inputlinkcounter" value="5" /></p>
										<p class="centeredmedia">Seconds</p>
									</div>
									<div class="mediabox">
										<h3>Link Reveal</h3>
										<p><input type="text" class="inputlink resultcounter " value="https://###" DISABLED /></p>
										<p>Click it</p>
									</div>
								</section>
							</div>
					</div>
				<p class="info">PILINK</p>
			</div>
			<script src="../js/libfunctionpilink.js"></script>
		</body>
	</html>';
	// Escribe el contenido al fichero
	file_put_contents("L/".$ID.".php", $actual);
	
}

function AddItemToList($itemname){
	$fp = fopen("../L/recipes.xml", "a");
	$add = '<recipe name="'.$itemname.'" count="1" craft_area="workbench" tags="workbenchCrafting">
		<ingredient name="resourceNail" count="10"/>
		<ingredient name="resourceWood" count="30"/>
		<ingredient name="resourceBrokenGlass" count="5"/>
		<ingredient name="resourceMechanicalParts" count="1"/>
	</recipe>';
	fwrite($fp, $add);  
	fclose($fp);  
}
if(isset($_POST['ItemName'])){
	if(AddItemToList($_POST['ItemName'])){
		echo "»".$_POST['ItemName'];
	}
}
?>