<?php
$target_dir = "uploads/"; //specify the directory where you want your images to go

function randomKey() {
  $key = '';
  for ($i=0; $i < 20 ; $i++) {
  	$key = $key.rand(0,100);
  }
  return $key;
}

$rand = randomKey();

$originalName = basename($_FILES["fileToUpload"]["name"]);
$imageFileType = pathinfo($originalName,PATHINFO_EXTENSION);
$target_file = $target_dir . $rand . "." . $imageFileType;
$uploadOk = 1;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "そのファイルは画像ファイルではありません。";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "そのファイルは既に存在します。";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "容量が、5MBを超えています。";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "JPG、JPEG、PNG、GIF形式でアップロードしてください。";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "アップロードに失敗しました。";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "写真ファイル". basename( $_FILES["fileToUpload"]["name"]). "のアップロードが完了しました。";

    //This is where you're going to put your query
    //& if you want to push the randomly generated image name to
    //your database, use the $rand variable in your query
    //else, delete this text


    } else {
        echo "アップロード中にエラーが発生しました。";
    }
}
?>
<br>
<a href="../main.php">Homeに戻る</a>
