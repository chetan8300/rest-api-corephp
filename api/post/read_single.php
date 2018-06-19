<?php

    //Adding Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/Post.php';

    // Instantiate Database and Connect 
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Get ID
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Post
    $post->read_single();

    // Create Array
    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    // Make JSON
    print_r(json_encode($post_arr));
?>