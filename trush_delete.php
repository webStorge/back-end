<?php
	include $_SERVER['DOCUMENT_ROOT']."/webstorge/php/db.php";
	$uname = $_GET["uname"];
	query("update FileDownload set trush=0 where uname='$uname';");
	header("location: ../index.php")
?>
	