<?php
/*
 * Interface Web for BLIH
 * Author: Jimmy KING (king_j)
*/
session_start();
include "inc/blih.php";
include "inc/utils.php";

if (!isset($_SESSION['login']) && !isset($_SESSION['login2']) || blih_whoami() == 'Error')
	header('Location: login.php');

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>EpiGit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="template/css/bootstrap.min.css">
	<link rel="stylesheet" href="template/css/bootstrap-theme.css">
	<link rel="stylesheet" href="template/css/extrapurple.css">
	<link rel="stylesheet" href="template/css/main.css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
  <div class="page_body">
    <div class="pagea_content">
		<div class="row">
			<div class="well" style="width: 21%;position: fixed;">
            <h2 id="nav-pills" style="color:#000;">Epitech Git</h2>
              <ul class="nav nav-pills nav-stacked" style="max-width: 300px;">
                <li <?php echo ( isset($_GET['repository']) ? 'class="active"' : '') ?>><a href="index.php?repository=list">Mes Dépôts</a></li>
				<li <?php echo ( isset($_GET['ssh_keys']) ? 'class="active"' : '') ?>><a href="index.php?ssh_keys=list">Mes Clés SSH</a></li>
				<li><a href="login.php?logout">Déconnexion (<?php echo blih_whoami(); ?>)</a></li>
              </ul>
			</div>
			<div class="col-sm-3">
			</div>
			<div class="col-sm-7 well" style="margin-left:7%; color:#000; min-height:500px;">
				<center>
						<?php

							if (isset($_GET['ssh_keys']))
								include "modules/ssh_keys.php";			
							else if (isset($_GET['repository']))
								include "modules/repository.php";	
							else
							{
								echo '<h2>Bienvenue sur EpiGit</h2>
									<h5>A partir d\'ici vous pouvez gérer vos dépôts GIT ainsi que vos clés ssh autorisées.</h5>
									<img src="template/images/epitech_logo.jpg">
								';
							}
						?>
				</center>
			</div>
		</div>
	</div>
	</div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="js/extra.js"></script>  
	<script>
	document.getElementById("uploadBtn").onchange = function () 
	{
		document.getElementById("uploadFile").value = this.value;
	};
	</script>
	</body>
</html>
