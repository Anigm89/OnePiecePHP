<?php
const API_URL = 'https://api.api-onepiece.com/v2/characters/en';

#inicializar una nueva sesión de cURL, ch = cUrl handle
$ch=curl_init(API_URL);

// indicar que queremos recibir el resultado de la peticion sin mostrarla en pantalla
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);    //ejecutar la peticion y guarda el resultado

/* alternativa mas sencilla para obtner el json. solo para peticiones get a api
$result = file_get_contents(API_URL);
*/
$data = json_decode($result, true);
curl_close($ch);

//var_dump($data);


?>

<head>
    <title>One Piece</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Personajes de One piece">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<section>
    <h1>Personajes de One Piece</h1>
    <ul>
        <?php foreach ($data as $personaje) : ?>
        <li>
            <h3><?= $personaje["name"] ?></h3>
            <p>Age: <?= $personaje['age'] ?></p>
            <p>Job: <?= $personaje['job'] ?> </p>
            <p>Bounty: <?= $personaje['bounty']; ?></p>
        </li>
        <?php endforeach ; ?>
    </ul>

</section>