<?php

require __DIR__ . '/vendor/autoload.php';
require "../assets/php/request.php";
require "./setHeader.php";

$router = new \Bramus\Router\Router();

$router->mount('/contacts',function() use($router){
    $defaultRequest='SELECT contacts.name, contacts.email, contacts.phone, contacts.created_at, companies.name AS name FROM contacts JOIN companies ON companies.id = contacts.company_id';
    $router->get('/five',function() use ($defaultRequest)
    {
        echo json_encode(createRequest($defaultRequest.' order by created_at DESC limit 5 '));
    });
    $router->get('/all', function () use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' order by created_at DESC'));
    });
    $router->get('/(\d+)', function ($id) use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' WHERE id='.$id));
    });
    $router->post('/add', function(){
        $payload = json_decode(file_get_contents('php://input'), true);
        $name = $payload['name'];
        $company_id= $payload['company_id'];
        $email= $payload['email'];
        $phone= $payload['phone'];
        $created_at= $payload['created_at'];
        $update_at= $payload['update_at'];

        //connect to sql and request
        try { $bdd = new PDO('mysql:host=127.0.0.1;dbname=cogip;charset=utf8', 'root', ''); }
        catch(Exception $e) { die('Erreur : '.$e->getMessage()); }
        $requestAdd= "INSERT INTO `contacts`(`name`, `company_id`, `email`, `phone`, `created_at`, `update_at`) VALUES ('".$name."','".$company_id."','".$email."','".$phone."','".$created_at."','".$update_at."')";
        $ps=$bdd->prepare($requestAdd);
        $ps->execute();

        echo json_encode([
            'success' => true,
            'message' => 'GG BRO'
        ]);
    });
    $router->patch('/update', function(){
        $payload = json_decode(file_get_contents('php://input'), true);
        $name = $payload['name'];
        $company_id= $payload['company_id'];
        $email= $payload['email'];
        $phone= $payload['phone'];
        $created_at= $payload['created_at'];
        $update_at= $payload['update_at'];

        //connect to sql and request
        // try { $bdd = new PDO('mysql:host=127.0.0.1;dbname=cogip;charset=utf8', 'root', ''); }
        // catch(Exception $e) { die('Erreur : '.$e->getMessage()); }

        $requestUpdate='UPDATE contacts SET name='.$name.' company_id='.$company_id.' email='.$email.' phone='.$phone.' created_at='.$created_at.'update_at='.$update_at;
        // $ps=$bdd->prepare($requestUpdate);
        // $ps->execute();

        echo json_encode([
            'success' => true,
            'message' => $requestUpdate,
        ]);

    });
});

$router->mount('/factures', function () use ($router) {
    $defaultRequest = 'SELECT invoices.ref, invoices.created_at, companies.name AS name FROM invoices JOIN companies ON companies.id = invoices.id_company';
    $router->get('/five', function () use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' order by created_at DESC limit 5 '));
    });
    $router->get('/all', function () use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' order by created_at DESC'));
    });
    $router->get('/(\d+)', function ($id) use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' WHERE id='.$id));
    });
    $router->post('/add', function(){
        $payload = json_decode(file_get_contents('php://input'), true);
        $ref = $payload['ref'];
        $id_company= $payload['id_company'];
        $created_at= $payload['created_at'];
        $update_at= $payload['update_at'];

        //connect to sql and request
        try { $bdd = new PDO('mysql:host=127.0.0.1;dbname=cogip;charset=utf8', 'root', ''); }
        catch(Exception $e) { die('Erreur : '.$e->getMessage()); }
        $requestAdd= "INSERT INTO `contacts`(`name`, `company_id`, `email`, `phone`, `created_at`, `update_at`) VALUES ('".$ref."','".$id_company."','".$created_at."','".$update_at."')";
        $ps=$bdd->prepare($requestAdd);
        $ps->execute();

        echo json_encode([
            'success' => true,
            'message' => 'GG BRO'
        ]);
    });
});

$router->mount('/compagnies', function () use ($router) {
    $defaultRequest = 'SELECT companies.name, companies.TVA, companies.country, companies.created_at, types.name AS type FROM companies JOIN types ON companies.type_id = types.id';
    $router->get('/five', function () use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' order by created_at DESC limit 5 '));
    });
    $router->get('/all', function () use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' order by created_at DESC'));
    });
    $router->get('/(\d+)', function ($id) use ($defaultRequest) 
    {
        echo json_encode(createRequest($defaultRequest.' WHERE id='.$id));
    });
    $router->post('/add', function(){
        $payload = json_decode(file_get_contents('php://input'), true);
        $name = $payload['name'];
        $type_id= $payload['type_id'];
        $country= $payload['country'];
        $tva= $payload['tva'];
        $created_at= $payload['created_at'];
        $update_at= $payload['update_at'];

        //connect to sql and request
        try { $bdd = new PDO('mysql:host=127.0.0.1;dbname=cogip;charset=utf8', 'root', ''); }
        catch(Exception $e) { die('Erreur : '.$e->getMessage()); }
        $requestAdd= "INSERT INTO `contacts`(`name`, `company_id`, `email`, `phone`, `created_at`, `update_at`) VALUES ('".$name."','".$type_id."','".$country."','".$tva."','".$created_at."','".$update_at."')";
        $ps=$bdd->prepare($requestAdd);
        $ps->execute();

        echo json_encode([
            'success' => true,
            'message' => 'GG BRO'
        ]);
    });
});



$router->run();
