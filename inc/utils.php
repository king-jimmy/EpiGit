<?php
/*
 * Interface Web for BLIH
 * Author: Jimmy KING (king_j)
*/

function get_right_text($rights)
{
	$right = 'Aucun Droits';
	if (substr_count($rights, 'r'))
		$right = 'Lecture';
	if (substr_count($rights, 'w'))
		$right = 'Ecriture';
	if (substr_count($rights, 'rw'))
		$right = 'Lecture/Ecriture';
	return ($right);
}

?>