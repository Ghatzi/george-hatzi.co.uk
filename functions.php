<?php

function mssql_escape($s) {
	if(get_magic_quotes_gpc()) {
		$s = stripslashes($s);
	}
	$s = str_replace("'","''",$s);
	return $s;
};

?>