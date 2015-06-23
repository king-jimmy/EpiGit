<?php
/*
 * Interface Web for BLIH
 * Author: Jimmy KING (king_j)
*/
 
/* INCLUDE REPOSITORY FUNCTIONS */
include "repository.php";

/* INCLUDE SSH KEYS FUNCTIONS */
include "ssh_keys.php";

/*
** Getting the current login
*/
function blih_whoami()
{
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2']);                                                                    
	$data = json_encode($data);  
		
	$curl = curl_init('https://blih.epitech.eu/whoami');
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);    
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data),
		'User-Agent: EpiGit 0.1')                                                                       
	);      
	$result = curl_exec($curl);
	$result = json_decode($result, true);
		
	if (isset($result['error']))
		return ('Error');
	else
		return ($result['message']);
}
?>