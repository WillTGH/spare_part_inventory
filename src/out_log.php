<?php include 'sql_inoutflow.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js";></script>
    <head>
        <title>Spare Part List</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" type='text/css' href='style.css'>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container" id='navbar'>
                <a class="navbar-brand" href="index.php">BMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="list.php">List Item</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="in_log.php">Log Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="out_log.php">Log Keluar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
                <a class="navbar-brand" href="index.php"><?php echo $_SESSION['username']. $_SESSION['permission']; ?></a>
            </div>
        </nav>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){

                if(isset($_POST['search'])){
                    $sort = -1;
                    $x = "%".$_POST['part_name']."%";
                    $category = null;
                }
                elseif(isset($_POST['refresh'])){
                    try {
                        header("Location: #.php");
                        exit();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                elseif(isset($_POST['category'])){
                    $category = $_POST['category'];
                    $x = null;
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
            
            if (isset($x)) {
                $stmt = $conn->prepare("SELECT * FROM logger WHERE `logging` = 'Out' AND part_name LIKE '$x';");
            } 
            elseif(isset($category)){
                $stmt = $conn->prepare("SELECT * FROM logger WHERE `logging` = 'Out' AND category = '$category';");
            }
            else{
                $stmt = $conn->prepare("SELECT * FROM logger WHERE `logging` = 'Out';");
            }
            
            $stmt->execute();

            $stmt2 = $conn->prepare("SELECT * FROM category_table");
            $stmt2->execute();
            // Close the database connection
            $conn = null;
        ?>
        <div class='md-5 content'>
            <form method="post">
                <div class='row'>
                    <div class='row'>
                        <label for="part_name" class='form-label text_bold text_bold'>Nama Part</label>
                        <div class='mb-3 col-md-3'>
                            <input class="form-control" type="text" name="part_name" value=''>
                        </div>
                        
                        <div class='mb-3 col-md-3'>
                            <button type="submit" name='search' value='0' class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                            
                            <button type="submit" name='refresh' value='0' class="btn btn-warning btn-sm">
                                <span class="glyphicon glyphicon-repeat"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='mb-3 col-md-3'>
                        <?php
                        $category = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        foreach($category as $cat){
                            echo "
                            <button type='submit' name='category' value='{$cat['category']}' class='btn btn-info btn-sm'>
                                {$cat['category']}
                            </button>
                            ";
                        }
                        ?>
                    </div>
                </div>
            </form>
            <div class='row'>
                <div class='mb-3'>
                    <table id="myTable" class='table'>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Part Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Nama Admin</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $table = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($table as $row):
                            ?>
                                <tr>
                                    <form method='post'>
                                        <td><?php echo isset($row['id']) ? $row['id'] : '';?></td>

                                        <td><?php echo isset($row['part_name']) ? $row['part_name'] : '';?></td>

                                        <td><?php echo isset($row['category']) ? $row['category'] : '';?></td>

                                        <td><?php echo isset($row['quantity']) ? $row['quantity'] : '';?></td>

                                        <td><?php echo isset($row['issued_by']) ? $row['issued_by'] : '';?></td>

                                        <td><?php echo isset($row['created_on']) ? $row['created_on'] : '';?></td>
                                        
                                    </form>
                                    <!-- Add more table cells based on your database columns -->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            
        </script>
    </body>
</html>
