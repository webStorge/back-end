<?php
<<<<<<< HEAD
	include $_SERVER['DOCUMENT_ROOT']."/webstorge/php/db.php";
	$uname = $_GET["uname"];
	query("delete from FileDownload where uname='$uname';");
	header("location: ../index.php")
=======
	include $_SERVER['DOCUMENT_ROOT']."/real01/php/db.php";
	$uname = $_GET["uname"];
	query("delete from FileDownload where uname='$uname';");
	header("location: index.php")
>>>>>>> b48a14aad0be0d2fa981aa1a27a6e49b0cf91335
?>
	