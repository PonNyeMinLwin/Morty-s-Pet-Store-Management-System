<?php
    // Starting the session
    session_start();

    // Assigning values to the variables
    $table_name = $_SESSION['table'];

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $encrypted = password_hash($password, PASSWORD_DEFAULT);

    // Adding the values to the database
    try {
        $insert_method = "INSERT INTO $table_name(first_name, last_name, email, password, created_at, last_updated_at) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$encrypted."', NOW(), NOW())";
        
        include('connector.php');

        $conn->exec($insert_method);

        $response = [
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' has been added to the database!'
        ];
    } catch(PDOException $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }

    $_SESSION['response'] = $response;
    header('Location: ../add-users.php');
?>