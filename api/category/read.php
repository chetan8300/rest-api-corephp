<?php

    //Adding Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods', 'GET');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/Category.php';

    // Instantiate Database and Connect 
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Category Object
    $category = new Category($db);

    // Blog Category Query
    $result = $category->read();

    //Get Row Count
    $num = $result->rowCount();

    // Check if any post available 
    if($num > 0) {
        // Category Array
        $categories_arr = array();
        $categories_arr['data'] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'name' => $name
            );

            // Push to ['data'] in Array
            array_push($categories_arr['data'], $category_item);
        }

        // Convert Array to JSON & Output
        echo json_encode($categories_arr);
        
    } else {
        // No Categories
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }
?>