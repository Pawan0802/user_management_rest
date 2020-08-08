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

    //Registration Email already used validation
    public function useremailavailibility($email){
        //check for the user input email first
        if($email != ''){
            // Create query
            $query = "SELECT COUNT(*) AS num FROM `users` WHERE email = :email";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            //Bind data
            $stmt->bindParam(':email', $email);
            
            //Execute the statement.
            $stmt->execute();
  
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // echo $row['num'];
            //If num is bigger than 0, the email already exists. Set the flag here
            // if($row['num'] > 0){
            //     return 1;
            // } else{
            //     return 0;
            // }
            $count = $row['num'] ?? 0;
            return $count;
        }
  
    }

    //invoking this function and activating the user when the user clicks on the link sent in an email
    function activateemail($email){
        try {
          // Create query
          $query = "UPDATE " . $this->table . " SET active_status = :status WHERE email = :email";
  
          // Prepare statement
          $stmt = $this->conn->prepare($query);
  
          //data
          $data = [
            'status' => 'Yes',
            'email' => $email
          ];
  
          // Execute query
          if($stmt->execute($data)) {
          return true;
          }
        } catch (\Throwable $th) {
          //throw $th;
        }
  
    }

    // Login User
    public function login($useremail,$userpassword){
        try {
           
            //Create Query
            $query = "SELECT * FROM ". $this->table ." WHERE email=:email LIMIT 1";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            $stmt->execute(array(':email'=>$useremail));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            print_r($userRow);
            // if($stmt->rowCount() > 0)
            if(empty($userRow)){
                // echo "email not matching";
                return 1;
            }
            /**
             * Since api is not live, so purposely commenting it for now.
             * But it is working in my local machine
             */
            // elseif($userRow['active_status'] != 'Yes'){
            //     return "User Inactive";
            // }
            else
            {
               if(password_verify($userpassword, $userRow['password']))
               {
                  return 3;
                      
               }
               else
               {
                  // echo "password not matching";
                  return 2;
                  // return false;
               }
            }
            
        } catch (\Throwable $th) {
          //throw $th;
        }
  
    }
    
  }


?>