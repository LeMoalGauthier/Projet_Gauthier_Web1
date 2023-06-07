<?php

require_once('database.php');

// Database connexion.
$db = dbConnect();
if (!$db) {
  header('HTTP/1.1 503 Service Unavailable');
  exit;
}

// Check the request.
$requestMethod = $_SERVER['REQUEST_METHOD'];
//les get ?url
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);
$requestRessource = array_shift($request);


if ($requestMethod == 'GET' && $requestRessource == 'liste') {
  if (isset($_COOKIE['limit'])) {
    // Le cookie "limit" existe
    $limit = $_COOKIE['limit'];
  }else{
    $limit = "1000";
  }
  $request = 'SELECT *,DATE_FORMAT(date_heure,"%d\/%m\/%Y %H:%i:%s") AS date_heure FROM grande_table_accidents ORDER BY RAND() limit '.$limit;
  $statement = $db->prepare($request);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if ($requestMethod == 'GET' && $requestRessource == 'liste2') {
  if (isset($_COOKIE['limit'])) {
    // Le cookie "limit" existe
    $limit = $_COOKIE['limit'];
  }else{
    $limit = "1000";
  }
  $request = 'SELECT *, ville.ville as ville, DATE_FORMAT(accidents.date_heure, "%d\/%m\/%Y %H:%i:%s") AS date_heure FROM accidents JOIN ville ON accidents.id_code_insee = ville.id_code_insee ORDER BY RAND() LIMIT '.$limit;

  $statement = $db->prepare($request);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if ($requestMethod == 'GET' && $requestRessource == 'cluster') {
  $request = 'SELECT * FROM culster';
  $statement = $db->prepare($request);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}


if ($requestMethod == 'POST' && $requestRessource == 'filtre') {
  $mois = $_POST['mois'];
  $descr_grav = $_POST['descr_grav'];
  $age = $_POST['age'];
  $choix = $_POST['choix'];
  $limit = $_POST['limit'];

  // Définir la durée de validité du cookie (1 heure)
  $expiration = time() + 3600;

  // Enregistrer la valeur dans un cookie
  setcookie('limit', $limit, $expiration);


  $request = "";

  if ($choix == "0") {
    $request = 'SELECT *,DATE_FORMAT(date_heure,"%d\/%m\/%Y %H:%i:%s") AS date_heure FROM grande_table_accidents WHERE 1=1';
  } else {
    $request = 'SELECT *, ville.ville as ville, DATE_FORMAT(accidents.date_heure, "%d\/%m\/%Y %H:%i:%s") AS date_heure FROM accidents JOIN ville ON accidents.id_code_insee = ville.id_code_insee WHERE 1=1';
  }

  if (!empty($mois)) {
    $request .= " AND MONTH(`date_heure`) = '$mois'";
  }

  if (!empty($descr_grav)) {
    $request .= " AND descr_grav = '$descr_grav'";
  }

  if (!empty($age)) {
    if ($age === '0-20') {
      $request .= " AND age >= 0 AND age <= 20";
    } elseif ($age === '20-40') {
      $request .= " AND age > 20 AND age <= 40";
    } elseif ($age === '40-60') {
      $request .= " AND age > 40 AND age <= 60";
    } elseif ($age === '60-80') {
      $request .= " AND age > 60 AND age <= 80";
    } elseif ($age === '80-90') {
      $request .= " AND age > 80 AND age <= 90";
    }
  }


  $request .= " ORDER BY RAND() LIMIT " . $limit;
  $statement = $db->prepare($request);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}
//fonction pour recupérer les données de la table accidents et ville
if ($requestMethod == 'GET' && $requestRessource == 'liste_new_base') {
  $request = "SELECT *, ville.ville as ville, DATE_FORMAT(accidents.date_heure,'%d\/%m\/%Y %H:%i:%s') AS date_heure FROM accidents JOIN ville ON accidents.id_code_insee = ville.id_code_insee";
  $statement = $db->prepare($request);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

/***********************************************/
/*liste des requettes pour les selecte du form*/
/*********************************************/

if($requestMethod =='GET'&& $requestRessource == 'meteos'){
  $request = 'SELECT descr_athmo FROM meteo';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if($requestMethod =='GET'&& $requestRessource == 'ville'){
  $request = 'SELECT * FROM ville ORDER BY ville';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if($requestMethod =='GET'&& $requestRessource == 'luminosites'){
  $request = 'SELECT descr_lum FROM luminosite';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if($requestMethod =='GET'&& $requestRessource == 'ceintures'){
  $request = 'SELECT descr_dispo_secu FROM ceinture';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if($requestMethod =='GET'&& $requestRessource == 'routes'){
  $request = 'SELECT descr_etat_surf FROM etat_route';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if($requestMethod =='GET'&& $requestRessource == 'agglos'){
  $request = 'SELECT descr_agglo FROM agglomeration';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if($requestMethod =='GET'&& $requestRessource == 'vehicules'){
  $request = 'SELECT descr_cat_veh FROM cat_vehicule';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

if($requestMethod =='GET'&& $requestRessource == 'collisions'){
  $request = 'SELECT descr_type_col FROM type_collision';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = $result;
}

// Send data to the client.
header('Content-Type: application/json; charset=utf-8');
header('Cache-control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('HTTP/1.1 200 OK');
echo json_encode($data);
exit;