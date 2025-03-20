<?php
include 'sql.php';

$ids = $_SESSION['ids'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_POST['search'])){
        try {
            header("Location: inoutflow.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    elseif(isset($_POST['update'])){
        // var_dump($_POST);
        updateQty($_POST);
    }
}
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "
    <div class='alert alert-danger' role='alert'>
        Error: " . $e->getMessage() . "</div>";
}

$placeHolder = implode(',', array_fill(0, count($ids), '?'));

$stmt = $conn->prepare(
    "SELECT spare_part_diesel.id, spare_part_diesel.part_name, category_table.category, spare_part_diesel.quantity
    FROM spare_part_diesel 
    INNER JOIN category_table ON spare_part_diesel.category=category_table.id
    WHERE spare_part_diesel.id IN ($placeHolder);"
    );


$stmt->execute($ids);

// category
$stmt2 = $conn->prepare("SELECT * FROM category_table");
$stmt2->execute();

// Close the database connection
$conn = null;

?>