<?php
session_start();
$config = include 'config.php';

$servername = $config['host'];
$username = $config['user'];
$password = $config['password'];
$dbname = $config['database'];

function addMultiple($formData){
    if ($_SESSION['permission'] > 0) {
        echo "You do not have permission to perform this action.";
        return;
    }

    for($i=0; $i<count($formData['part_name']); $i++){
        add($formData['part_name'][$i], $formData['category'][$i], $formData['quantity'][$i]);
    }
    
    echo '<div class="alert alert-success" role="alert">';
    echo 'Record inserted successfully';
    echo '</div>';
}
function add($part_name, $category, $quantity){
    global $servername, $username, $password, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare a statement with a parameterized query
        $stmt = $conn->prepare("INSERT INTO `spare_part_diesel`
        (
            part_name,
            category,
            quantity
        )
        VALUES 
        (
            :part_name,
            :category,
            :quantity
        )
        ");
        
        $stmt->bindParam(':part_name', $part_name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':quantity', $quantity);
        // Execute the query
        $stmt->execute();
    } catch (PDOException $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }
}
function updateNote($formData){
    // var_dump($formData);
    global $servername, $username, $password, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a statement with a parameterized query
        $stmt = $conn->prepare("UPDATE `spare_part_diesel` SET 
        note=:note
        WHERE id=:id");

        $stmt->bindParam(':id', $formData['id']);
        $stmt->bindParam(':note', $formData['note']);
        
        // Execute the query
        $stmt->execute();
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record inserted successfully';
        echo '</div>';
    } catch (PDOException $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }
}
function updateQty($formData){
    global $servername, $username, $password, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a statement with a parameterized query
        if($formData['flow'] == 'in'){
            foreach($formData['quantity'] as $key => $x){
                $qty[] = $x + $formData['inout'][$key];
            }
        }
        elseif($formData['flow'] == 'out'){
            foreach($formData['quantity'] as $key => $x){
                $qty[] = $x - $formData['inout'][$key];
            }
        }
        $items = array_combine($formData['ids'], $qty);
        // var_dump($items);

        $sql = "UPDATE `spare_part_diesel` SET `quantity` = CASE id ";
        foreach ($items as $id => $value) {
            $sql .= "WHEN ? THEN ? ";
        }
        $sql .= "END WHERE id IN (" . implode(",", array_keys($items)) . ")";

        // Prepare and bind values
        $stmt = $conn->prepare($sql);
        $params = [];
        foreach ($items as $id => $value) {
            array_push($params, $id, $value);
        }
        
        // Execute the query
        $stmt->execute($params);
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record inserted successfully';
        echo '</div>';
    } catch (PDOException $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }
}
function delete($formData){
    if ($_SESSION['permission'] > 0) {
        echo "You do not have permission to perform this action.";
        return;
    }
    global $servername, $username, $password, $dbname;
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a statement with a parameterized query
        $stmt = $conn->prepare("DELETE FROM `spare_part_diesel` WHERE id=:id");

        $stmt->bindParam(':id', $formData['id']);
        // Execute the query
        $stmt->execute();
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record inserted successfully';
        echo '</div>';
    } catch (PDOException $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }
}
function history_log($formData){
    global $servername, $username, $password, $dbname;
    // var_dump($formData);
    update($formData, $formData['flow']);
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a statement with a parameterized query
        $stmt = $conn->prepare("INSERT INTO `logger` 
        (
            part_name, 
            logging, 
            quantity,
            issued_by
        )
        VALUES 
        (
            :part_name, 
            :logging, 
            :quantity,
            :issued_by
        )
        ");

        $stmt->bindParam(':part_name', $formData['part_name']);
        $stmt->bindParam(':logging', $formData['flow']);
        $stmt->bindParam(':quantity', $formData['quantity_move']);
        $stmt->bindParam(':issued_by', $formData['issued_by']);

        // Execute the query
        $stmt->execute();
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record inserted successfully';
        echo '</div>';
    } catch (PDOException $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }
}
function export_database(){
    global $servername, $username, $password, $dbname;
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get all table names
    $tables = [];
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }

    // Generate SQL dump
    $sqlDump = "-- Database Backup\n-- Created: " . date("Y-m-d H:i:s") . "\n\n";
    foreach ($tables as $table) {
        // Get CREATE TABLE statement
        $createTableQuery = $conn->query("SHOW CREATE TABLE `$table`")->fetch_assoc();
        $sqlDump .= $createTableQuery["Create Table"] . ";\n\n";
        
        // Get table data
        $result = $conn->query("SELECT * FROM `$table`");
        while ($row = $result->fetch_assoc()) {
            $values = array_map(fn($val) => "'" . $conn->real_escape_string($val) . "'", array_values($row));
            $sqlDump .= "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n";
        }
        $sqlDump .= "\n";
    }

    // Save to a file
    $fileName = "backup_" . date("Y-m-d_H-i-s") . ".sql";
    file_put_contents($fileName, $sqlDump);

    echo "Database exported as $fileName";

    // Close connection
    $conn->close();
}
function import_database(){
    $sqlFile = "backup.sql";
    global $servername, $username, $password, $dbname;
    try {
        // Create database connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Read the SQL file
        $sql = file_get_contents($sqlFile);
        if (!$sql) {
            die("Error reading the SQL file.");
        }

        // Split SQL statements
        $queries = explode(";", $sql);

        // Execute each query
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$conn->query($query)) {
                    echo "Error executing query: " . $conn->error . "<br>";
                }
            }
        }

        echo "Database successfully imported.";

        // Close connection
        $conn->close();
    } catch (Exception $e) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Error: " . $e->getMessage() . "</div>";
    }
}
?>