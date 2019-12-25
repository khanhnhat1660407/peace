<?php
require_once 'init.php';
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["upload_image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$timeStamp = time();
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["upload_image"]["tmp_name"]);
    if($check !== false) {
        $_source_path = $_FILES['upload_image']['tmp_name'];
        $newFileName = $currentUser['id'] . '-' . $timeStamp . '.' .$imageFileType;
        $target_path = 'uploads/' .$newFileName;
        if(move_uploaded_file($_source_path, $target_path))
        {
            $privacyNum = 1;
            $privacy = $_POST['Privacy-value'];
            switch($privacy)
            {
                case 'Mọi người': $privacyNum = 1;break;
                case 'Bạn bè': $privacyNum = 2;break;
                case 'Chỉ mình tôi': $privacyNum = 3;break;
            }
            $content = strip_tags($_POST['status-image']);
            $userId = $currentUser['id'];
            addPost($userId,$content,$privacyNum,$target_path);
            header('Location: index.php');
            exit();
        }
    } else {
        die('nha');
        return;
    }
}
?>

