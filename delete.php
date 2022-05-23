<?php
	include $_SERVER['DOCUMENT_ROOT']."/real01/php/db.php";
	$uname = $_GET["uname"];
	query("delete from FileDownload where uname='$uname';");
	header("location: index.php")
?>
	