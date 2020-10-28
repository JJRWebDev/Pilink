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
		<script src="js/libjquerypilink.js"></script>
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<?php
			include("ps/function_level.php");
			$db = linkcon();
		?>
	</head>
	<body>
		<div class="container">
			<div id="tabs" class="tabs">
				<nav class="navlistmenu">
					<ul>
						<li class="HomeSection" ><a href="#section-1" class="icon-doc-1"><span>Home</span></a></li>
						<li><a href="#section-2" class="icon-lock"><span>Crypt</span></a></li>
						<li><a href="#section-3" class="icon-box"><span>Short</span></a></li>
						<li><a href="#section-4" class="icon-link"><span>Links</span></a></li>
						<li><a href="#section-5" class="icon-plus"><span>New</span></a></li>
						<li style="display:none;" ><a href="#section-6"></a></li>
					</ul>
				</nav>
				<div class="content">
					<!-- HOME // -->
					<section id="section-1" >
						<div class="mediabox <!--WelcomerBox-->">
							<h3>Welcome to</h3>
							<input class="AnnounceBox" placeholder="PILINK" DISABLED />
							<p>Link your way...</p>
						</div>
						<div class="mediabox">
							<h3>Crypt</h3>
							<input class="AnnounceBox" placeholder="LINKS" DISABLED />
							<p>Keep your links safe.</p>
						</div>
						<div class="mediabox">
							<h3>Explore</h3>
							<input type="text" class="SearchBox" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Search ..." name="SearchBoxContentVar" />
								<!--<span class="SearchBoxIcon icon-link"></span>-->
							<p>The content library.</p>
						</div>
						<?php
							if(isset($_POST['LinkTitle'])){
								if(CreateNewPilink()){
									header("Location: /");
								}else{
									echo"<p>Failed to create pilink.</p>";
								}
							}
						?>
						<span class="SearchContentSection"><?php ListContentLink(); ?></span>
						<input type="text" name="ItemName" class="inputlink ItemName" spellcheck="false" autocomplete="off"  placeholder="ItemName" />
						<input type="submit" class="buttonlink AddItemToList" value="&#xe801;"/>
					</section>
					<!-- \\ HOME -->
					<!-- CRYPT // -->
					<section id="section-2">
						<?php
							if(isset($_POST['cryptlink'])){
								$checkgen = false;
								// Llamamos a los checks
								if(isset($_POST['LinkToCrypt'])&&isset($_POST['PasswordKeyCode'])){
									$codeGen = generateRandomString();
									CreateNewLink($codeGen);
									$linkCrypt =  my_simple_crypt( $_POST['LinkToCrypt'], $action = 'e' );
									$passCrypt =  my_simple_crypt( $_POST['PasswordKeyCode'], $action = 'e' );
									$pilink = "https://pilink.net/L/".$codeGen."";
									$consulta = $db->prepare("INSERT INTO `pilink`.`crypted_link` (`id_crypt`, `id_owne`, `PSSWD`, `LINK`, `pilink`, `DATE`) VALUES (NULL, '1', '".$passCrypt."', '".$linkCrypt."', '".$pilink."', CURRENT_TIMESTAMP);");
									if($consulta->execute()){
										$checkgen = true;
									}
								}
							}
						?>
						<form method="post" action="/">
						<div class="mediabox <!--WelcomerBox-->">
							<h3>Crypt a Link</h3>
							<p><input type="text" name="LinkToCrypt" autocomplete="off" autocorrect="off" autocapitalize="off" class="inputlink UserGiveLink" required value="" placeholder="Your link here..." /></p>
							<p>Paste here the link.</p>
							<!--<p><input type="button" class="inputsubmitlink PasteLinkToInput" name="Paste" value="Paste"><p>-->
						</div>
						<div class="mediabox <!--WelcomerBox-->">
							<h3>Key Word</h3>
							<p class="PortionGraph">
								<input type="password" name="PasswordKeyCode" autocomplete="off" autocorrect="off" autocapitalize="off" required class="inputlinkPortion" value="" placeholder="Password"/>
								<input type="submit" class="inputsubmitlinkPortion" name="cryptlink" value="Crypt"/>
							</p>
							<p>Add a password to reveal it.</p>
							<!--<p><input type="submit" class="inputsubmitlink" name="cryptlink" value="Crypt"><p>-->
						</div>
						</form>
						<div class="mediabox <!--WelcomerBox-->">
							<h3>Crypted Link</h3>
							<p class="PortionGraph">
								<input type="text" class="inputlinkPortion CopyValPilink" value="<?php if ($checkgen){echo $pilink;} ?>" placeholder="Generated Link" />
								<input type="button" class="inputsubmitlinkPortion CopyPilink" name="Copy" value="Copy"/>
							</p>
							<p>Output generated link.</p>
							<!--<p><input type="button" class="inputsubmitlink" name="Copy" value="Copy"><p>-->
						</div>
					</section>
					<!-- \\ CRYPT -->
					<!-- SHORT // -->
					<section id="section-3">
						<div class="mediabox <!--WelcomerBox-->">
							<h3>Short a Link</h3>
							<p><input type="text" class="inputlink" value="http://mega.co.nz/3453DFGDSASDG#%$"  /></p>
							<p>Paste here the link.</p>
						</div>
						<div class="mediabox <!--WelcomerBox-->">
							<h3>»</h3>
						</div>
						<div class="mediabox <!--WelcomerBox-->">
							<h3>Short Link</h3>
							<p><input type="text" class="inputlink" value="http://pilink.net/7BFGT3"  /></p>
							<p>Gen Links that require a password to unlock real link.</p>
						</div>
					</section>
					<!-- \\ SHORT -->
					<section id="section-4">
						<div class="mediabox <!--WelcomerBox-->">
							<h3>Explore the content</h3>
							<input class="AnnounceBox" placeholder="PILINK" DISABLED />
							<p>Link your way...</p>
						</div>
						<div class="mediabox">
							<h3>Category</h3>
							<input class="inputlink" />
							<p>Select a brand</p>
						</div>
						<div class="mediabox">
							<h3>Search</h3>
							<input class="inputlink" />
							<p>Search for </p>
						</div>
						<?php ListContentLink(); ?>
					</section>
					<!-- \\ USER -->
					<section id="section-5">
						<div class="mediabox <!--WelcomerBox-->">
							<!--<span class="imguser">*</span>-->
							<h3>GUEST</h3>
							You can add content with Guest user
						</div>
						<div class="mediabox <!--WelcomerBox-->">
							<h3>New Content</h3>
							<table class="inputcontenttab">
								<tr>
									<td><input type="button" class="inputlink AddNewPilink" value="Add" style="background-color: white;font-weight: bold;color: gray;" /></td>
								</tr>
							</table>
						</div>
						<div class="mediabox <!--WelcomerBox-->">
							<h3>NEW SIGN</h3>
							<h3>LOG IN</h3>
						</div>
						<div class="mediabox">
							<!--<span class="imguser">*</span>-->
							<h3>Information</h3>
							<p>We are not taking responsability on the content that users upload.</p>
						</div>
					</section>
					<section id="section-6">
						<div class="mediabox">
							<h3>New Content</h3>
							<input class="AnnounceBox" placeholder="PILINK" DISABLED />
							<p>Link your way...</p>
						</div>
						<div class="mediabox mediadynamic">
							<h3>&nbsp;</h3>
							<input class="AnnounceBox" placeholder="&nbsp;" DISABLED />
							<p>&nbsp;</p>
						</div>
						<div class="mediabox mediadynamic">
							<h3>&nbsp;</h3>
							<input class="AnnounceBox" placeholder="&nbsp;" DISABLED />
							<p>&nbsp;</p>
						</div>
						<form method="post" name="PilinkNew" action="/">
						<div class="mediabox">
							<h3>Title</h3>
							<p><input type="text" name="LinkTitle" class="inputlink" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" REQUIRED pattern=".{0}|.{8,30}" maxlength="30" placeholder="Add a title..." /></p>
							<p>Min lenght 8, Max lenght 30.</p>
						</div>
						<div class="mediabox">
							<h3>Short Description</h3>
							<p><input type="text" name="LinkDesc" class="inputlink" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" REQUIRED pattern=".{0}|.{10,30}" maxlength="30" placeholder="Type resumed description..." /></p>
							<p>Min lenght 10, Max lenght 30.</p>
						</div>
						<div class="mediabox">
							<h3>Category</h3>
							<p>
								<select class="inputlink CategoryIcon" name="LinkCategory">
									<option value="gam">&nbsp;Games&nbsp;&#xe03b;</option>
									<option value="vid">&nbsp;Video&nbsp;&#xe011;</option>
									<option value="pic">&nbsp;Image&nbsp;&#xe00f;</option>
									<option value="fil">&nbsp;Files&nbsp;&#xe005;</option>
									<option value="doc">&nbsp;Docss&nbsp;&#xe015;</option>
									<option value="mus">&nbsp;Audio&nbsp;&#xe03a;</option>
									<option value="mis">&nbsp;Other&nbsp;&#xe001;</option>
								</select>
							</p>
							<p>Select a category.</p>
						</div>
						<div class="mediabox">
							<h3>Link</h3>
							<p><input type="text" name="LinkLink" class="inputlink" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" REQUIRED placeholder="https://pilink.net" /></p>
							<p>Max lenght 200.</p>
						</div>
						<div class="mediabox">
							<h3>Long Description</h3>
							<p><input type="text" name="LinkDescLong" class="inputlink" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" REQUIRED pattern=".{0}|.{30,300}" maxlength="300" placeholder="Type extended description..." /></p>
							<p>Min lenght 30, Max lenght 300.</p>
						</div>
						<div class="mediabox">
							<h3>Tags</h3>
							<p><input type="text" name="LinkTags" class="inputlink" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" REQUIRED placeholder="Type your tags here..." /></p>
							<p>Add tags split by ","</p>
						</div>
						<div class="mediabox">
							<h3>Add</h3>
							<p><input type="submit" class="buttonlink" value="&#xe801;"/></p>
							<p>Click it</p>
						</div>
						</form>
					</section>
					<!-- USER // -->
				</div><!-- /content -->
			</div><!-- /tabs -->
			<p class="info">PILINK</p>
		</div>
		<script src="js/cbpFWTabs.js"></script>
		<script src="js/libfunctionpilink.js"></script>
		<script>
			new CBPFWTabs( document.getElementById( 'tabs' ) );
		</script>
		<script type="text/javascript">
			var triggers = [].slice.call( tabs.querySelectorAll( 'nav > ul > li' ) );
				document.getElementById('tabs').addEventListener('click', function() {
			});
			$('.AddNewPilink').click(function(){
				triggers[5].click();
			});
		</script>
		<?php
		if(isset($_POST['cryptlink'])){
			?>
			<script type="text/javascript">
			triggers[1].click();
			</script>
		<?php
		} 
		?>
	</body>
</html>
