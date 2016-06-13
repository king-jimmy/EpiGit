<?php


/*
** Open the dialog for deleting a repository
*/
if ($_GET['repository'] == 'delete')
{
	if (isset($_GET['name']))
	{
		echo '<h2>Dépôt: '. $_GET['name'] .'</h2>
			<h5 style="padding-top:30px;">Souhaitez vous supprimer le dépôt ?</h5>		
			<a href="index.php?repository=confirm-delete&name='.$_GET['name'].'" class="btn btn-lg btn-success">Confirmer</a>	<a href="index.php?repository=view" class="btn btn-lg btn-default">Annuler</a>';
	}
}

/*
** Removing the repository
*/
else if ($_GET['repository'] == 'confirm-delete')
{
	if (isset($_GET['name']))
	{
		blih_repository_delete($_GET['name']);
		header('Location: index.php?repository=list&deleted='.$_GET['name']);
	}
}
/*
** Showing the informations about a repository
*/
else if ($_GET['repository'] == 'view')
{
	if (isset($_GET['name']))
	{
		if (isset($_POST['delete']))
		{
			$return_blih = blih_repository_set_acl($_GET['name'], $_POST['delete'], '');
			if (isset($return_blih['error']))
				echo '<div class="alert alert-danger">Une erreur est survenue, impossible de retirer les droits.</div>';
			else
				echo '<div class="alert alert-success">'.$_POST['delete'].' n\'as plus aucun droit sur votre dépôt.</div>';
		}
		if (isset($_POST['login']) && isset($_POST['right']))
		{
			$return_blih = blih_repository_set_acl($_GET['name'], $_POST['login'], $_POST['right']);
			if (isset($return_blih['error']))
				echo '<div class="alert alert-danger">Une erreur est survenue, impossible d\'ajouter les droits.</div>';
			else
				echo '<div class="alert alert-success">Les droits de '. get_right_text($_POST['right']) .' pour '. $_POST['login'] .' ont été ajouté.</div>';
		}

		$infos = blih_repository_infos($_GET['name']);
		$acl = blih_repository_get_acl($_GET['name']);
		echo '<h2>Dépôt: '. $_GET['name'] .'</h2>';
		echo '
				<h5>Date de création: '. date('Y-m-d H:i:s', $infos['message']['creation_time']).'</h5>
				<h3>Droits utilistateurs: </h3>
				<table class="table table-striped" style="width:90%;">
					<thead>
						<tr>
							<td style="width:50%;"><b>Login</b></td>
							<td style="width:40%;"><b>Droits</b></td>
							<td style="text-align:center;"><b>Actions</b></td>
						</tr>
					</thead>
					<tbody>';
		foreach ($acl as $user => $rights)
		{
			if ($user != 'error')
			{
				$right = get_right_text($rights);
				echo '
				<form id="delete'. str_replace("-", "", $user) .'" action="" method="POST">
				<input type="hidden" name="delete" value="'.$user.'">
				<tr>
					<td>'. $user .'</td>
					<td>'. $right .'</td>
					<td style="text-align:center;"><a target="blank" href="https://intra.epitech.eu/user/'.$user.'"><i class="icon-eye-open"></i></a> <a href="#" onclick="delete'. str_replace("-", "", $user) .'.submit();"><i class="icon-trash"></i></a></td>
				</tr>
				</form>	';
			}
		}
		echo ' 
					</tbody>
				</table> 
			<form id="rightform" action="" method="POST">
				<table> 
					<tr>
						<td style="width:10%;"></td>
						<td style="width: 5%;">Login:</td>
						<td style="width: 15%;"><input style="width:150px;"type="text" class="form-control" name="login"></td>
						<td style="width: 5%;">Droits:</td>
						<td style="width: 15%;">
							<select class="form-control" id="select" name="right">
								<option value="r">Lecture</option>
								<option value="rw">Lecture/Ecriture</option>
							</select>
						</td>
						<td style="width: 15%;"></td>
					</tr>
				</table> 
				<a href="#" onclick="rightform.submit();" style="margin-top:15px; width: 20%;"class="btn btn-sm btn-primary">Ajouter</a>
			</form>';
	}
}
/*
** Showing every repository of the user
*/
else if ($_GET['repository'] == 'list')
{
	echo '<h2>Liste des dépôts</h2>';
	if (isset($_GET['deleted']))
		echo '<div class="alert alert-success">Le dépôt '.$_GET['deleted'].' à été supprimé</div>';
	if (isset($_POST['repo']))
		{
			$return_blih = blih_create_repository($_POST['repo']);
			if (isset($return_blih['error']))
				echo '<div class="alert alert-danger">Une erreur est survenue durant la création du dépôt.</div>';
			else
				echo '<div class="alert alert-success">Le dépôt '.$_POST['repo'].' à été créé.</div>';
		}
	echo '<table class="table table-striped" style="width:90%;">
			  <thead>
				<tr>
					<td style="width:80%;"><b>Nom du dépôt</b></td>
					<td style="text-align:center;"><b>Actions</b></td>
				</tr>
			  </thead>
		  <tbody>';
	$result = blih_repository_list();
	usort($result['repositories'], function($a, $b) {
		return strcmp($a['url'], $b['url']);
	});
	
	foreach($result['repositories'] as $repo)
	{
		$name = str_replace('https://blih.epitech.eu/repository/', '', $repo['url']);		
		echo '<tr>';
		echo '	<td>'. $name .'</td>';
		echo '  <td style="text-align:center;"><a alt="Voir plus d\'informations" href="index.php?repository=view&name='.$name.'"><i class="icon-eye-open"></i></a> <a alt="Supprimer le dépôt" href="index.php?repository=delete&name='.$name.'"><i class="icon-trash"></i></a></td>';
		echo '<tr>';
	}
echo '
		  </tbody>
		</table> 
		<form id="repository_creator" action="" method="POST">
			<table> 
				<tr>
					<td style="width:15%;"></td>
					<td style="width: 14%;">Nom du dépôt:</td>
					<td style="width: 30%;"><input type="text" class="form-control" name="repo"></td>
					<td style="width: 40%;"><a href="#" onclick="repository_creator.submit();" style="margin-left:15px;" class="btn btn-sm btn-primary">Créer un nouveau Dépôt</a></td>
				</tr>
			</table> 
		</form>';
}
?>