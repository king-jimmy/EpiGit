<?php
/*
 * Interface Web for BLIH
 * Author: Jimmy KING (king_j)
*/

/*
** Creating a new repository
*/
function blih_create_repository($repository)
{		
	$extra_data = array("name" => $repository, "type" => 'git');
	$extra_data_json = json_encode($extra_data, JSON_PRETTY_PRINT);
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2'], 'data' => $extra_data);  
	$hash = hash_init("sha512", HASH_HMAC, $_SESSION['hashed']);
	hash_update($hash, $_SESSION['login']);
	hash_update($hash, $extra_data_json);
	$sign = hash_final($hash);
	$data['signature'] = $sign;
	$data = json_encode($data);
	$curl = curl_init('https://blih.epitech.eu/repositories');                                                                      
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
** Getting repository list
*/
function blih_repository_list()
{
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2']);                                                                    
	$data = json_encode($data);                                                                              
																															 
	$curl = curl_init('https://blih.epitech.eu/repositories');                                                                      
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
** Getting informations about a repository
*/
function blih_repository_infos($repository)
{
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2']);                                                                    
	$data = json_encode($data);                                                                              
																														 
	$curl = curl_init('https://blih.epitech.eu/repository/'.$repository.'');                                                                      
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
** Delete a repository
*/
function blih_repository_delete($repository)
{
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2']);                                                                    
	$data = json_encode($data);                                                                              
																														 
	$curl = curl_init('https://blih.epitech.eu/repository/'.$repository.'');                                                                      
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
	
/*
** Getting ACL infos from a repository
*/
function blih_repository_get_acl($repository)
{
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2']);                                                                    
	$data = json_encode($data);                                                                              
																															 
	$curl = curl_init('https://blih.epitech.eu/repository/'.$repository.'/acls');                                                                      
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
** Grant ACL to a user to a repository 
*/
function blih_repository_set_acl($repository, $login, $right)
{
	$extra_data = array("acl" => $right, "user" => $login);
	$extra_data_json = json_encode($extra_data, JSON_PRETTY_PRINT);
		
	$data = array("user" => $_SESSION['login'], "signature" => $_SESSION['login2'], 'data' => $extra_data);  

	$hash = hash_init("sha512", HASH_HMAC, $_SESSION['hashed']);
	hash_update($hash, $_SESSION['login']);
	hash_update($hash, $extra_data_json);
	$sign = hash_final($hash);
	$data['signature'] = $sign;
	$data = json_encode($data);
	$curl = curl_init('https://blih.epitech.eu/repository/'.$repository.'/acls');                                                                      
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

?>