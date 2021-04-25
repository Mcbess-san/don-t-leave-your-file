<?php

if($_SERVER["REQUEST_METHOD"] === "POST" ){ 
   
    $data = array_map('trim', $_POST);

    $errors = [];

    if (empty($data['firstname'])) {
        $errors[] = 'You have too enter a firstname';
    }

    $firstnameLength = 255;
    if (strlen($data['firstname']) > $firstnameLength) {
        $errors[] = 'The firstname need to be ' . $firstnameLength . ' character';
    }

    if (empty($data['lastname'])) {
        $errors[] = 'You have too enter a name';
    }

    $lastnameLength = 255;
    if (strlen($data['lastname']) > $lastnameLength) {
        $errors[] = 'The name need to be ' . $lastnameLength . '  character';
    }

    $uploadDir = 'public/uploads/';
    
    $uploadFile = $uploadDir .'_' . uniqid() . '_' .basename($_FILES['avatar']['name']);

    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    
    $extensions_ok = ['jpg','jpeg','png','webp'];
    
    $maxFileSize = 1000000;

    if( (!in_array($extension, $extensions_ok ))){
        $errors[] = 'You have too select an image where the type is Jpg or Jpeg or Png or Webp!';
    }

    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize){
        $errors[] = "Your file need to be under 1M !";   
    }  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach( $errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <h1>Homer Simpson</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="lastname">Name</label>
        <input type="text" name="lastname" id="lastname"value="<?= $data['lastname'] ?? '' ?>" required>

        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname"value="<?= $data['firstname'] ?? '' ?>" required>

        <label for="age">Age</label>
        <input type="number" name="age" id="age" value="<?= $data['age'] ?? '' ?>" required>

        <label for="imageUpload">Upload an profile image</label>    
        <input type="file" name="avatar" id="imageUpload" />
        <button name="send">Send</button>
    </form>
</body>
</html>