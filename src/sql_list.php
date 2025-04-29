<?php
include 'sql.php';

try{
    // Database connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from MySQL
    $stmt = $conn->prepare(
        "SELECT spare_part_diesel.id, spare_part_diesel.part_name, category_table.category, spare_part_diesel.quantity, spare_part_diesel.note, spare_part_diesel.note
        FROM spare_part_diesel 
        INNER JOIN category_table ON spare_part_diesel.category=category_table.id
        ORDER BY category_table.category;"
        );
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "
    <div class='alert alert-danger' role='alert'>
        Error: " . $e->getMessage() . "</div>";
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['update'])){
        // $_SESSION['ids'] = $_POST['selected'];
        // header("Location: inoutflow.php");
        // exit();
    }
    if(isset($_POST['database'])){
        if($_POST['database'] == 'export'){
            export_database();
        }
        elseif($_POST['database'] == 'import'){
            import_database();
            header("Location: #.php");
            exit();
        }
    }
}
?>