<?php
include_once 'partials/create_post.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<?php include '../component/header.php' ?>

<body>
</body>

<script type="module" src="../assets/js/event/create_post.js"></script>
</html>