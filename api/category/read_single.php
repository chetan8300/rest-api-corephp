<?php

    //Adding Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/Category.php';

    // Instantiate Database and Connect 
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $category = new Category($db);

    // Get ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Post
    $category->read_single();

    // Create Array
    if($category->category_name != NULL) {
        $category_arr = array(
            'id' => $category->id,
            'name' => $category->category_name
        );
    
        // Make JSON
        print_r(json_encode($category_arr));
    } else {
        print_r(json_encode(array(
            'message' => 'No Categories Found'
        )));
    }

?>