<?php
//db 연동 
session_start();
$db = new mysqli("localhost","root","Tkddyd@135","oss");
$db->set_charset("utf8");

if ($db->connect_error) {
  die("Fail : " .$db->connect_error); // 연결 실패 시 원인을 출력한다
} else {
  echo "OK"; // 연결 성공 시 웹 페이지 좌상단에 연결 성공이라는 문구를 출력한다
}

function query($query)
{
	global $db;
	return $db->query($query);
}
?>