<?php
include 'sql.php';
$newRows = [];

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "
    <div class='alert alert-danger' role='alert'>
        Error: " . $e->getMessage() . "</div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['search'])) {
        if(isset($_POST['search_item']) && $_POST['search_item'] != "") {
            var_dump($_POST['search_item']);
            $search = '%'.$_POST['search_item'].'%';
        }
        else{
            header("Location: #.php");
            exit();
        }
    }
    elseif(isset($_POST['add'])){
        try {
            addMultiple($_POST);
            header("Location: #.php");
            exit();
        } catch (PDOException $e) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Error: " . $e->getMessage() . "</div>";
        }
    }
    elseif(isset($_POST['refresh'])){
        try {
            header("Location: #.php");
            exit();
        } catch (PDOException $e) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Error: " . $e->getMessage() . "</div>";
        }
    }
    elseif(isset($_POST['addRow'])){
        $partNames = $_POST['part_name'];
        $categories = $_POST['category'];
        $quantities = $_POST['quantity'];

        for ($i = 0; $i < count($partNames); $i++) {
            $newRows[] = [
                'part_name' => $partNames[$i],
                'category' => $categories[$i],
                'quantity' => $quantities[$i]
            ];
        }
    }
    elseif(isset($_POST['delete'])){
        try {
            delete($_POST); 
            header("Location: #.php");
            exit();
        } catch (PDOException $e) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Error: " . $e->getMessage() . "</div>";
        }
    }
    // SP_data
    elseif(isset($_POST['row'])){
        try {
            updateNote($_POST);
            header("Location: #.php");
            exit();
        } catch (PDOException $e) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Error: " . $e->getMessage() . "</div>";
        }
    }
    elseif(isset($_POST['test'])){
        // var_dump($_POST);
    }
}

if(isset($search)){
    $stmt = $conn->prepare(
        "SELECT spare_part_diesel.id, spare_part_diesel.part_name, category_table.category, spare_part_diesel.quantity, spare_part_diesel.note, spare_part_diesel.note
        FROM spare_part_diesel 
        INNER JOIN category_table ON spare_part_diesel.category=category_table.id
        WHERE spare_part_diesel.part_name LIKE '$search';"
        );
}
else{
    $stmt = $conn->prepare(
        "SELECT spare_part_diesel.id, spare_part_diesel.part_name, category_table.category, spare_part_diesel.quantity, spare_part_diesel.note, spare_part_diesel.note
        FROM spare_part_diesel 
        INNER JOIN category_table ON spare_part_diesel.category=category_table.id
        ORDER BY category_table.category;"
        );
}

$stmt->execute();
// category
$stmt2 = $conn->prepare("SELECT * FROM category_table");
$stmt2->execute();

// Close the database connection
$conn = null;

?>