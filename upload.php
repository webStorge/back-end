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

$query = "
	INSERT INTO FileDownload
    	(name,uname,date,size)
    VALUES('$name','$new_filename','$date','$size');";
mysqli_query($con,$query);

$file->setName($new_filename);
if ($result === false) { // false가 나왔다면 무슨 에러인지 출력한다(29번 줄의  태그를 주석 쳐야 제대로 볼 수 있다)
    echo mysqli_error($con);
}
// Validate file upload
// MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
$file->addValidations(array(
    // Ensure file is of type "image/png"
    new \Upload\Validation\Mimetype('image/png'),

    //You can also add multi mimetype validation
    //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

    // Ensure file is no larger than 5M (use "B", "K", M", or "G")
    new \Upload\Validation\Size('5M')
));

// Access data about the file that has been uploaded
$data = array(
    'name'       => $file->getNameWithExtension(),
    'extension'  => $file->getExtension(),
    'mime'       => $file->getMimetype(),
    'size'       => $file->getSize()
);

// Try to upload file
try {
    // Success!
    $file->upload();
} catch (\Exception $e) {
    // Fail!
    $errors = $file->getErrors();
}
?>