<?php 
        // Including the database connection file
        include("database.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Glassmorphism Login Form | CodingNepal</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <div class="wrapper">
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h2>Login</h2>
      <div class="input-field">
        <input type="text" name="emial" required>
        <label>Emial</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" required>
        <label>password</label>
      </div>
      <div class="forget">
        <a href="#">Forgot password?</a>
      </div>
      <button type="submit" name="login">Log In</button>
    </form>
  </div>
</body>
</html>


<?php 

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input to avoid HTML or SQL injection
            $email = filter_input(INPUT_POST, "emial", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

            if(empty($email)){
                echo "Username is required";
            }
            elseif(empty($password)){
                echo "Password is required";
            }
            else{
                    // Hash the password for secure storage
               $hash = password_hash($password, PASSWORD_DEFAULT);

                // Check if the email already exists in the database
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                
                if($count > 0){
                    echo "That username already exists";
                }
                // SQL query to insert the new user's username and hashed password into the 'users' table
               $sql = "INSERT INTO users (email, password)
                VALUES ('$email', '$hash')";

            try {
              // Attempt to execute the query and insert the new user into the database
              mysqli_query($conn, $sql);
              // If successful, redirect to the successful registration page
              header("Location: application_successful_registration.php");
              exit(); // Ensure no further code is executed after the redirection
            } catch (mysqli_sql_exception) {
              // If an error occurs (e.g., duplicate username), display an error message
              echo "That username already exists";
            }

               
                
            
            }
        }




        // Close the database connection after the registration attempt
        mysqli_close($conn);
?>