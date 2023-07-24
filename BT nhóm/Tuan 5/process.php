<?php
$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['comment'];
if (empty($name) || preg_match('/^\s*$/', $name)) {

    echo 'Họ tên không hợp lệ.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Email không hợp lệ.';
} else {
    echo "<h2>Bình luận của bạn đã được ghi nhận:</h2>";
    echo "<p><strong>Họ và tên:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    if (!empty($comment)) {
        echo "<p><strong>Bình luận:</strong> $comment</p>";
    }
}
