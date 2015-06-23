<?php

/*
** Open the dialog for deleting a SSH Key
*/
if ($_GET['ssh_keys'] == 'delete')
{
	if (isset($_GET['name']))
	{
		echo '<h2>Clé SSH: '. $_GET['name'] .'</h2>
		<h5 style="padding-top:30px;">Souhaiter vous supprimer cette clé SSH ?</h5>			
		<a href="index.php?ssh_keys=confirm-delete&name='.$_GET['name'].'" class="btn btn-lg btn-success">Confirmer</a>	<a href="index.php?repository=view" class="btn btn-lg btn-default">Annuler</a>';
	}
}

/*
** Removing the SSH key
*/
else if ($_GET['ssh_keys'] == 'confirm-delete')
{
	if (isset($_GET['name']))
	{
		blih_ssh_delete($_GET['name']);
		header('Location: index.php?ssh_keys=list&deleted='.$_GET['name']);
	}
}
/*
** Showing every ssh keys of the user
*/
else if ($_GET['ssh_keys'] == 'list')
{
	echo '<h2>Liste des clés SSH</h2>';
	if (isset($_FILES['key']) && $_FILES['key']['tmp_name'] != '')
	{
		$ssh_key_content = file_get_contents($_FILES['key']['tmp_name']);
		$return_blih = blih_ssh_upload($ssh_key_content);
		if (isset($return_blih['error']))
		{
			if ($return_blih['error'] == 'sshkey already exists')
				echo '<div class="alert alert-danger">Un clé SSH avec ce nom existe déjà.</div>';
			else if ($return_blih['error'] == 'Bad token')
				echo '<div class="alert alert-danger">Une erreur est survenue.</div>';
		}
		if (isset($return_blih['message']))
			if ($return_blih['message'] == 'sshkey uploaded')
				echo '<div class="alert alert-success">La clé SSH à été envoyer sur le serveur.</div>';
	}
	if (isset($_GET['deleted']))
		echo '<div class="alert alert-success">La clé SSH '.$_GET['deleted'].' à été supprimer.</div>';
	echo '
	<table class="table table-striped" style="width:90%;">
	  <thead>
		<tr>
			<td style="width:80%;"><b>Nom de la clé</b></td>
			<td style="text-align:center;"><b>Actions</b></td>
		</tr>
	  </thead>
	  <tbody>';
	$result = blih_ssh_list();
	foreach($result as $ssh_key => $content)
	{
		if ($ssh_key != 'error')
		{
			echo '<tr>';
			echo '	<td>'. $ssh_key .'</td>';
			echo '  <td style="text-align:center;"><a alt="Supprimer la clé" href="index.php?ssh_keys=delete&name='.$ssh_key.'"><i class="icon-trash"></i></a></td>';
			echo '<tr>';
		}
	}
	echo '
	  </tbody>
	</table>
	<form action="" method="POST" enctype="multipart/form-data">
		 <input type="hidden" name="MAX_FILE_SIZE" value="1000" />
	  <legend>Ajouter une nouvelle clé SSH</legend>
	  <div class="form-group">
		<label for="inputName" class="col-lg-3 control-label" style="padding-top:18px;">Clé SSH</label>
		<div class="col-lg-7">
		 <input id="uploadFile" style="width:85%;" class="cform-control" placeholder="Choisissez votre clé publique" disabled="disabled" />
			<div class="fileUpload btn btn-primary">...
				<input id="uploadBtn" type="file" name="key" class="upload" />
			</div>
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-lg-10 col-lg-offset-1">
		  <button type="submit" class="btn btn-primary">Envoyer la clé</button> 
		</div>
	  </div>
  </form>';
}
?>