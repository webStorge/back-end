<?php
$name=$_FILES['foo']['name'];  //���ε��� ���� �̸� �޾ƿ���
$size=$_FILES['foo']['size'];
$date = date("Y-m-d H:i:s");
$new_filename = uniqid();
require 'vendor/autoload.php'; //���
$storage = new \Upload\Storage\FileSystem('saveFile'); //���¼ҽ� -> ���� ����� ����
$file = new \Upload\File('foo', $storage); // ���¼ҽ� -> ���� ���� �޾ƿ���

//db ���� 
$con = new mysqli("localhost","root","Tkddyd@135","oss");
$con->set_charset("utf8");

if ($con->connect_error) {
  die("Fail : " .$con->connect_error); // ���� ���� �� ������ ����Ѵ�
} else {
  echo "OK"; // ���� ���� �� �� ������ �»�ܿ� ���� �����̶�� ������ ����Ѵ�
}

$query = "
	INSERT INTO FileDownload
    	(name,uname,date,size)
    VALUES('$name','$new_filename','$date','$size');";
mysqli_query($con,$query);

$file->setName($new_filename);
if ($result === false) { // false�� ���Դٸ� ���� �������� ����Ѵ�(29�� ����  �±׸� �ּ� �ľ� ����� �� �� �ִ�)
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