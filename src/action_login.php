<?php
include 'sql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['login'])) {
        login($_POST);
    }
    elseif(isset($_POST['register'])){
        register($_POST);
    }
    elseif(isset($_POST['toregister'])){
        header("Location: register.php");
        exit();
    }
    

}
function register($formData){
    if ($_SESSION['permission'] == -1) {
        echo "You do not have permission to perform this action.";
        return;
    }
    global $servername, $username, $password, $dbname;
    
    $hashed = password_hash($formData['pass'], PASSWORD_DEFAULT);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare a statement with a parameterized query
        $stmt = $conn->prepare("INSERT INTO `users`
        (
            user,
            pass,
            permission
        )
        VALUES 
        (
            :user,
            :pass,
            :permission
        )
        ");
        
        $stmt->bindParam(':user', $formData['user']);
        $stmt->bindParam(':pass', $hashed);
        $stmt->bindParam(':permission', $formData['permission']);

        // Execute the query
        $stmt->execute();
    } catch (PDOException $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }

    header("Location: login.php");
    exit();
}
function login($formData){
    global $servername, $username, $password, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a statement to retrieve the user data
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE user = :user");
        $stmt->bindParam(':user', $formData['user']);
        $stmt->execute();

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($formData['pass'], $user['pass'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $user['user'];
            $_SESSION['loggedin'] = true;
            $_SESSION['permission'] = $user['permission'];
            header("Location: index.php"); // Redirect to the main page
            exit;
        } else {
            // Invalid username or password
            echo "
            <div class='alert alert-danger' role='alert'>
                Error: " . $e->getMessage() . "</div>";
        }

        // Close the database connection
        $conn = null;
    } catch (PDOException $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }
}
function logout(){

}
?>