<?php
/*
 * Interface Web for BLIH
 * Author: Jimmy KING (king_j)
*/
session_start();
include "inc/blih.php";
include "inc/utils.php";

if (isset($_POST['inputLogin']) && isset($_POST['inputUnix']) && $_POST['inputUnix'] != '' && $_POST['inputLogin'] != '')
{
	$_SESSION['login'] = htmlspecialchars($_POST['inputLogin']);
	$passwd = hash("sha512", $_POST['inputUnix']);
	$_SESSION['hashed'] = $passwd;
	$passwd = hash_hmac("sha512", $_SESSION['login'], $passwd);
	$_SESSION['login2'] = $passwd;
	if (blih_whoami() != 'Error')
		header('Location: index.php');
}

if (isset($_GET['logout']))
	session_destroy();
else if (isset($_SESSION['login']) && isset($_SESSION['login2']) && blih_whoami() != 'Error')
	header('Location: index.php');
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
    <div class="page_content">
		<center>
		<h1 style="padding-top:15px;">Accès Epitech</h1>
		<h4>Veuillez entrer vos identifiants pour accéder à EpiGit.</h4>
		</center>
		<div class="well" style="margin-top:25px;">
			<?php
				if (isset($_POST['inputLogin']))
				{
					if (blih_whoami() == 'Error')
					{
						echo '<div class="alert alert-danger">
								<center>Identifiants incorrect</center>
							  </div>';
					}
					else
					{
						echo '<div class="alert alert-success">
								<center>Connexion à EpiGit reussi !</center>
							  </div>';
					}
				}
			?>
              <form class="form-horizontal" method="POST" action="login.php">
                  <div class="form-group">
                    <label for="inputLogin" class="col-lg-4 control-label" style="color:#666666;">Login Epitech</label>
                    <div class="col-lg-6" >
                      <input type="text" class="form-control" id="inputLogin" name="inputLogin" placeholder="Veuillez indiquez votre login epitech">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputUnix" class="col-lg-4 control-label" style="color:#666666;">Mot de passe UNIX</label>
                    <div class="col-lg-6">
                      <input type="password" class="form-control" id="inputUnix" name="inputUnix" placeholder="Veuillez indiquez votre mot de passe UNIX">
                    </div>
                  </div>
					<center>
						<div style="padding-top:15px;">
							<input type="submit" class="btn btn-lg btn-primary" name="submit_btn" value="Connexion" />
						</div>
					</center>
              </form>
        </div>
		
		<div style="text-align:center; padding-top:80px;">
		<h5></h5>
		</div>
	</div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="js/extra.js"></script>  
	
	</body>
</html>
