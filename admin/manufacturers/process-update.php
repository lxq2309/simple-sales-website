<?php
require_once '../../config.php';
require_once '../../connection.php';

if (empty ($_POST['manufacturer_id'])) {
    header("Location: index.php");
    exit;
}
$id = $_POST['manufacturer_id'];
// validate
if (empty ($_POST['name']) || empty ($_POST['description']) || empty ($_POST['phone_number'])) {
    header("Location: edit.php?id=$id&error=Vui lòng nhập đầy đủ thông tin");
    exit;
}

$name = addslashes($_POST['name']);
$description = addslashes($_POST['description']);
$phone_number = addslashes($_POST['phone_number']);
$old_image = addslashes($_POST['old_image']);
$new_image = $_FILES['new_image'];

// upload file
if ($new_image['size'] > 0) {
    $target_dir = "/images/manufacturers/";
    $target_file = $target_dir . time() . basename($new_image["name"]);
    move_uploaded_file($new_image["tmp_name"], '../..' . $target_file);
} else {
    $target_file = $old_image;
}


// update
$sql = "UPDATE manufacturers SET
            name = '$name',
            description = '$description',
            phone_number = '$phone_number',
            image = '$target_file'
        WHERE manufacturer_id = '$id'
";
try {
    mysqli_query($conn, $sql);
} catch (\Throwable $th) {
    header("Location: edit.php?id=$id&error=Lỗi hệ thống");
    exit;
}
header("Location: edit.php?id=$id&success=Sửa thành công");
