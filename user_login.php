<?php

   define('DB_SERVER', 'localhost:8889');
   define('DB_USERNAME', 'admin');
   define('DB_PASSWORD', 'admin');
   define('DB_DATABASE', 'myMovies');
   $link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   // Check connection
   if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }

   $username = $password = "";
   $username_err = $password_err = "";

   if($_SERVER["REQUEST_METHOD"] == "POST") {
   
      // Check if username is empty
       if(empty(trim($_POST["username"]))){
           $username_err = "Please enter username.";
       } else{
           $username = trim($_POST["username"]);
       }
       
       // Check if password is empty
       if(empty(trim($_POST["password"]))){
           $password_err = "Please enter your password.";
       } else{
           $password = trim($_POST["password"]);
       }
       
       // Validate credentials
       if(empty($username_err) && empty($password_err)){
           
           // Prepare a select statement
           $sql = "SELECT userID, username, password, designation, fullname FROM users WHERE username = ?";
           
           if($stmt = mysqli_prepare($link, $sql)){
               // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt, "s", $param_username);
               
               // Set parameters
               $param_username = $username;
               
               // Attempt to execute the prepared statement
               if(mysqli_stmt_execute($stmt)){
                   // Store result
                   mysqli_stmt_store_result($stmt);
                   
                   // Check if username exists, if yes then verify password
                   if(mysqli_stmt_num_rows($stmt) == 1){                    
                       // Bind result variables
                       mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $designation, $fullname);
                       if(mysqli_stmt_fetch($stmt)){
                           if(password_verify($password, $hashed_password)){
                               // Password is correct, so start a new session
                               session_start();
                               
                               // Store data in session variables
                               $_SESSION["loggedin"] = true;
                               $_SESSION["id"] = $id;
                               $_SESSION["username"] = $username; 
                               $_SESSION["user"] = $designation; 
                               $_SESSION["fullname"] =  $fullname;

                               if(strcmp($designation, "user") == 0)  
                                 header("location: myMovies/myMovies.php");
                                  else if(strcmp($designation, "dev") == 0 || strcmp($designation, "admin") == 0)  
                                 header("location: admin_account/myMovies.php");                
                               
                               // Redirect user to welcome page
                               
                           } else{
                               // Display an error message if password is not valid
                               $password_err = "The password you entered was not valid.";
                           }
                       }
                   } else{
                       // Display an error message if username doesn't exist
                       $username_err = "No account found with that username.";
                   }
               } else{
                   echo "Oops! Something went wrong. Please try again later.";
               }
           }
           
           // Close statement
           mysqli_stmt_close($stmt);
       }
       else {
         echo "$username_err, $password_err";
       }
       
       // Close connection
       mysqli_close($link);
   }
?>