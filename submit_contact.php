<?php
/**
* On ne traite pas les super globales provenant de l'utilisateur directement,
* ces données doivent être testées et vérifiées.
*/
$postData = $_POST;

if (
    !isset($postData['email'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
    || empty($postData['message'])
    || trim($postData['message']) === ''
) {
    echo('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
}

// TEST VALIDATION FICHIER 
if(isset($_FILES["file"]) && $_FILES['file']['error'] === 0){
    //Vérification taille du fichier
    if($_FILES['file']['size'] > 1000000){
        echo "Fichier trop lourd";
        return;
    }
    //Vérification extension
    $fileInfo = pathinfo($_FILES['file']['name']);
    $extension = $fileInfo['extension'];
    $allowedExtension = ['jpg', 'jpeg', 'gif', 'png'];
    if(!in_array($extension, $allowedExtension)){
        echo "L'extension $extension n'est pas autorisé";
        return;
    }
    //Test si dossier upload est manquant
    $path = __DIR__ . '/upload/';
    if(!is_dir($path)){
        echo "Le dossier upload est manquant";
        return;
    }
    //Validation du fichier et stockage
    move_uploaded_file($_FILES['file']['tmp_name'], $path . basename($_FILES['file']['name']));
    $isFileLoaded = true;
}


?>

<!DOCTYPE html>’
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Contact reçu</title>
    <link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet"
>
</head>

<body>
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Message bien reçu !</h1>
        <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rappel de vos informations</h5>
            <p class="card-text"><b>Email</b> : <?php echo($postData['email']); ?></p>
            <p class="card-text"><b>Message</b> : <?php echo(strip_tags($postData['message'])); ?></p>
            <?php if ($isFileLoaded) : ?>
                    <div class="alert alert-success" role="alert">
                        L'envoi a bien été effectué !
                    </div>
            <?php endif; ?>
        </div>
    </div>
    <?=require_once('footer.php');?>
</body>
</html>