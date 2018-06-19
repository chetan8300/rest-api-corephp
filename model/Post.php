<?php

    class Post {
        //DB Stuff

        private $conn;
        private $table = "posts";

        // Post Properties 
        public $id;
        public $category_id;
        public $category_name;
        public $body;
        public $author;
        public $created_at;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Posts / Read Posts
        public function read() {

            // Create a Query
            $query = 'SELECT
                        c.name as category_name,
                        p.id,
                        p.category_id,
                        p.title,
                        p.body,
                        p.author,
                        p.created_at
                    FROM
                         '.$this->table.' p
                    LEFT JOIN
                        categories c ON p.category_id=c.id
                    ORDER BY
                        p.created_at DESC'    
                ;
            
            // Create Prepared Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Post
        public function read_single() {
            
            // Create a Query
            $query = 'SELECT 
                        c.name as category_name,
                        p.id,
                        p.category_id,
                        p.title,
                        p.body,
                        p.author,
                        p.created_at
                    FROM
                         '.$this->table.' p
                    LEFT JOIN
                        categories c ON p.category_id=c.id
                    WHERE
                        p.id = ?
                    LIMIT 0,1';

            // Create Prepared Statement
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $this->id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }

        // Create Post
        public function create() {
            $query = "INSERT INTO ".$this->table." 
                SET
                    title=:title,
                    body=:body,
                    author=:author,
                    category_id=:category_id";
        
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":body", $this->body);
            $stmt->bindParam(":author", $this->author);
            $stmt->bindParam(":category_id", $this->category_id);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }

            // Print Error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            
            return false;
        }

        // Update Post
        public function update() {
            $query = "UPDATE ".$this->table." 
                SET
                    title=:title,
                    body=:body,
                    author=:author,
                    category_id=:category_id
                WHERE
                    id=:id";
        
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":body", $this->body);
            $stmt->bindParam(":author", $this->author);
            $stmt->bindParam(":category_id", $this->category_id);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }

            // Print Error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            
            return false;
        }

        // Delete Data
        public function delete() {
            $query = "DELETE FROM ".$this->table." 
                WHERE 
                    id=:id";

            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":id", $this->id);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }

            // Print Error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            
            return false;
        }
        
    }

?>