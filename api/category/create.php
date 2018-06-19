<?php

    //Adding Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods', 'POST');
    header('Access-Control-Allow-Header', 'Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Category.php';

    // Instantiate Database and Connect 
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $category = new Category($db);

    //Get Raw Posted Data
    $data = json_decode(file_get_contents("php://input"));

    $category->category_name = trim($data->category_name);

    if(trim($data->category_name) == NULL) {
        echo json_encode(
            array('message' => 'Please Fill Category')
        );
        return false;
    }

    // Create Category
    if($category->create()) {
        echo json_encode(
            array('message' => 'Category Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Created')
        );
    }