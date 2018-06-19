<?php

    //Adding Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods', 'DELETE');
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

    $category->id = $data->id;

    // Delete Category
    if($category->delete()) {
        echo json_encode(
            array('message' => 'Category Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );
    }