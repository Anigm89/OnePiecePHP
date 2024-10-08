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

//paginacion
$itemsPag = 15;
$totalItems = count($data); //total de personajes
$totalPages= ceil($totalItems / $itemsPag);  //calcula nº pags con 15 persoanjes

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual, por defecto 1

//define el indice inicial  yfinal para los personajes a mostrar en esta pag
$startIndex = ($page -1) * $itemsPag;
$paginatedData = array_slice($data, $startIndex, $itemsPag);
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
        <?php foreach ($paginatedData as $personaje) : ?>
        <li>
            <h3><?= $personaje["name"] ?></h3>
            <p>Age: <?= isset($personaje['age']) ?  $personaje['age'] : 'undefined' ?></p>
            <p>Job: <?= $personaje['job'] ?> </p>
            <p>Bounty: <?= isset($personaje['bounty'] ) ?  $personaje['bounty'] : ' - '  ?></p>
        </li>
        <?php endforeach ; ?>
    </ul>
    
      <!-- Controles de paginación -->
      <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">Anterior</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
        
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>">Siguiente</a>
        <?php endif; ?>
    </div>
</section>