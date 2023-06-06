<?php

  require_once('database.php');

  // Database connexion.
  $db = dbConnect();
  if (!$db)
  {
    header ('HTTP/1.1 503 Service Unavailable');
    exit;
  }

  // Check the request.
  $requestMethod = $_SERVER['REQUEST_METHOD'];
  //les get ?url
  $request = substr($_SERVER['PATH_INFO'], 1);
  $request = explode('/', $request);
  $requestRessource = array_shift($request);


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
?>