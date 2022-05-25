<?php
//db ¿¬µ¿ 
$db = new mysqli("localhost","root","Tkddyd@135","oss");
$db->set_charset("utf8");


function query($query)
{
	global $db;
	return $db->query($query);
}
?>