<?php

    class Category {
        //DB Stuff

        private $conn;
        private $table = "categories";

        // Post Properties 
        public $id;
        public $category_name;
        
        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Categories
        public function read() {
            // Create a Query
            $query = "SELECT `id`, `name`, `created_at` FROM ".$this->table;

            // Create Prepared Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Category
        public function read_single() {
            // Create a Query
            $query = "SELECT `id`, `name`, `created_at` FROM ".$this->table." WHERE id=?";

            // Create Prepared Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind Param
            $stmt->bindParam(1, $this->id);

            // Execute Query
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Properties
            $this->category_name = $row['name'];
            
            return $stmt;
        }

        // Create Category
        public function create() {
            $query = "INSERT INTO ".$this->table." 
                    SET name=:category_name";
        
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->category_name = htmlspecialchars(strip_tags($this->category_name));

            // Bind Data
            $stmt->bindParam(":category_name", $this->category_name);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }

            // Print Error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            
            return false;
        }

        // Delete Category
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