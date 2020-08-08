<?php
class User {
    // DB stuff
    private $conn;
    private $table = 'users';

    // User Properties
    public $id;
    public $name;
    public $email;
    public $password;
    public $dob;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    
    // Register User
    public function register() {
        
        try {
          $hash_password = password_hash($this->password, PASSWORD_DEFAULT);
          // Create query
          $query = "INSERT INTO " . $this->table . "(name,email,password,dob) VALUES(:name, :email, :password, :dob)";

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $hash_password = htmlspecialchars(strip_tags($hash_password));
          $this->dob = htmlspecialchars(strip_tags($this->dob));

          //data
          $data = [
          'name' => $this->name,
          'email' => $this->email,
          'password' => $hash_password,
          'dob' => $this->dob,
          ];

          // Execute query
          if($stmt->execute($data)) {
            //return "testing";
            return true;
          }

          // Print error if something goes wrong
          // printf("Error: %s.\n", $stmt->error);
          // return false;
        
        } catch (PDOException $e) {
                //throw $th;
                echo $e->getMessage();
        }
      
    }
    
  }


?>