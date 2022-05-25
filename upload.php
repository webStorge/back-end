<?php
$name=$_FILES['foo']['name'];  //업로드한 파일 이름 받아오기
$size=$_FILES['foo']['size'];
$date = date("Y-m-d H:i:s");
$new_filename = uniqid();
require 'vendor/autoload.php'; //라라벨
$storage = new \Upload\Storage\FileSystem('saveFile'); //오픈소스 -> 파일 저장소 지정
$file = new \Upload\File('foo', $storage); // 오픈소스 -> 파일 정보 받아오기

//db 연동 
$con = new mysqli("localhost","root","Tkddyd@135","oss");
$con->set_charset("utf8");

if ($con->connect_error) {
  die("Fail : " .$con->connect_error); // 연결 실패 시 원인을 출력한다
} else {
  echo "OK"; // 연결 성공 시 웹 페이지 좌상단에 연결 성공이라는 문구를 출력한다
}
$number_query = "select * from FileDownload where name;";
$number = mysqli_query($con,$number_query);
$number_count = count($number);
$names = $new_filename."".$file->getExtension();
echo $number;
$query = "
	INSERT INTO FileDownload
    	(number,name,uname,date,size)
    VALUES('$number','$name','$names','$date','$size');";
mysqli_query($con,$query);

$file->setName($new_filename);
if ($result === false) { // false가 나왔다면 무슨 에러인지 출력한다(29번 줄의  태그를 주석 쳐야 제대로 볼 수 있다)
    echo mysqli_error($con);
}

$file->addValidations(array(
    new \Upload\Validation\Mimetype('image/png'),     #이미지형식 업로드 가능
    new \Upload\Validation\Size('5M') #5메가 까지 저장가능 
));

$data = array(
    'name'       => $file->getNameWithExtension(),
    'extension'  => $file->getExtension(),
    'mime'       => $file->getMimetype(),
    'size'       => $file->getSize()
);

try {
    $file->upload();
} catch (\Exception $e) {
    $errors = $file->getErrors();
}
?>