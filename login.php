<?php
    // Starting the session
    session_start();
    
    $error_message = '';

    if($_POST){
        include('database/connector.php');
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = 'SELECT * FROM users WHERE users.email="'. $username .'" AND users.password="'. $password .'"';
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetchAll()[0];

            // Captures data of the user currently logged in
            $_SESSION['user'] = $user;

            header('Location: dashboard.php');
        } else {
            $error_message = 'Login details does not match any records in our database. Please try again.';
        }
    }
?>

<html>
    <head>
        <title>Login Page - Morty's Pet Store Management System</title>

        <link rel="stylesheet" type="text/css" href="css/login.css">
    </head>
    <body id="loginBody">
        <?php if(!empty($error_message)) { ?>
            <div id="errorMessage">
                <strong>ERROR:</strong></p><?= $error_message ?></p>
            </div>
        <?php } ?>
        <div class="container">
            <div class="loginHeader">
                <h1>MORTY'S</h1>
                <p>Pet Store Management System<p>
            </div>
            <div class="loginMenu">
                <form action="login.php" method="POST">
                    <div class="inputContainer">
                        <label for="">Username</label>
                        <input placeholder="username" name="username" type="text" />
                    </div>
                    <div class="inputContainer">
                        <label for="">Password</label>
                        <input placeholder="password" name="password" type="password" />
                    </div>
                    <div class="buttonContainer">
                        <button>Enter</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>