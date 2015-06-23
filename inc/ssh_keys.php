<?php
/*
 * Interface Web for BLIH
 * Author: Jimmy KING (king_j)
*/

/*	
** Getting SSH Keys list
*/
function blih_ssh_list()
{
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2']);                                                                    
	$data = json_encode($data);                                                                              
	$curl = curl_init('https://blih.epitech.eu/sshkeys');
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data),
		'User-Agent: EpiGit 0.1')
	);
	
	$result = curl_exec($curl);
	$result = json_decode($result, true);
	return ($result);
}

/*
** Upload a new SSH Key
*/
function blih_ssh_upload($ssh_key)
{		
	$ssh_key = str_replace("\n", "", $ssh_key);
	$ssh_key = str_replace(" ", "%20", $ssh_key);
	$extra_data = array("sshkey" => $ssh_key);
	$extra_data_json = json_encode($extra_data, JSON_PRETTY_PRINT);
	$extra_data_json = str_replace("\\", "", $extra_data_json);
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2'], 'data' => $extra_data);  
	$hash = hash_init("sha512", HASH_HMAC, $_SESSION['hashed']);
	hash_update($hash, $_SESSION['login']);
	hash_update($hash, $extra_data_json);
	$sign = hash_final($hash);
	$data['signature'] = $sign;
	$data = json_encode($data);
	$curl = curl_init('https://blih.epitech.eu/sshkeys');                                                                    
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                                                                  
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data),
		'User-Agent: EpiGit 0.1')                                                                       
	);                                                                                                                   
																														 
	$result = curl_exec($curl);
	$result = json_decode($result, true);
	return ($result);
}

/*
** Delete a SSH Key
*/
function blih_ssh_delete($ssh_key)
{
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2']);                                                                    
	$data = json_encode($data);       
	
	$curl = curl_init('https://blih.epitech.eu/sshkey/'.$ssh_key);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data),
		'User-Agent: EpiGit 0.1')
	);
	
	$result = curl_exec($curl);
	$result = json_decode($result, true);
	return ($result);
}
?>