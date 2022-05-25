<?php
	include $_SERVER['DOCUMENT_ROOT']."/webstorge/php/db.php";
	$uname = $_GET["uname"];
	query("update FileDownload set star=1 where uname='$uname';");
	header("location: ../index.php")
?>
	