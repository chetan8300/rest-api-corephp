<?php

    //Adding Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods', 'GET');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/Post.php';

    // Instantiate Database and Connect 
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Blog Post Query
    $result = $post->read();

    //Get Row Count
    $num = $result->rowCount();

    // Check if any post available 
    if($num > 0) {
        // Post Array
        $posts_arr = array();
        $posts_arr['data'] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            // Push to ['data'] in Array
            array_push($posts_arr['data'], $post_item);
        }

        // Convert Array to JSON & Output
        echo json_encode($posts_arr);
        
    } else {
        // No Posts
        echo json_encode(
            array('message' => 'No Posts Found')
        );
    }
?>