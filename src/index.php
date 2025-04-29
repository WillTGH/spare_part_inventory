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
        <?php
        include 'sql_index.php';
        ?>
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
        <div class='md-5 content'>
            
            <form method='POST'>
                <div class='mb-3'>
                    <table class='table partList'>
                        <thead>
                            <tr>
                                <th>Part Name</th>
                                <th>Category</th>
                                <th>quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($newRows as $row): ?>
                                <tr>
                                    <td><input class="form-control" type="text" name="part_name[]" value="<?php echo htmlspecialchars($row['part_name']); ?>" required></td>
                                    <td>
                                        <select class="form-control" name="category[]">
                                            <?php 
                                            try {
                                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                // Fetch categories
                                                $stmt2 = $conn->prepare("SELECT id, category FROM category_table");
                                                $stmt2->execute();

                                                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                    $selected = ($row2['id'] == $row['category']) ? 'selected' : '';
                                                    echo "<option value='{$row2['id']}' $selected>{$row2['category']}</option>";
                                                }
                                            } catch (PDOException $e) {
                                                echo "Connection failed: " . $e->getMessage();
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input class="form-control" type="text" name="quantity[]" value="<?php echo htmlspecialchars($row['quantity']); ?>"></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td><input class="form-control" type="text" name="part_name[]" value='' required></td>
                                <td>
                                    <select class="form-control" name="category[]">
                                        <?php 
                                        try {
                                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                            // Fetch categories
                                            $stmt2 = $conn->prepare("SELECT id, category FROM category_table");
                                            $stmt2->execute();

                                            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='{$row2['id']}'>{$row2['category']}</option>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "Connection failed: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" name="quantity[]" value=''></td>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" name="addRow" value="addRow" class="btn btn-primary" onclick="removeRequiredAttributes()">Add Row</button>
                    <button type="submit" name="add" value="add" class="btn btn-success">Submit</button>
                </div>
            </form>
            
            <div class='empty-span-l'></div>

            <form method='POST'>
                <div class='row'>
                    <div class='row'>
                        <label for='search' class='form-label text_bold text_bold'>Nama Part</label>
                        <div class='mb-3 col-md-3'>
                            <input class='form-control' type='text' name='search_item' value=''>
                        </div>
                        
                        <div class='mb-3 col-md-3'>
                            <button type='submit' name='search' value='search' class='btn btn-primary btn-sm'>
                                <span class='glyphicon glyphicon-search'></span>
                            </button>
                            <button type='submit' name='refresh' value='refresh' class='btn btn-info btn-sm'>
                                <span class='glyphicon glyphicon-refresh'></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class='mb-3'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Part Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $currentCategory = '';
                        $table = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($table as $row):
            
                            if($_SESSION['permission'] <= 0){
                                $permission = "
                                <button type='submit' name='delete' value='delete' class='btn btn-danger btn-sm' onclick='removeRequiredAttributes()'>
                                    <span class='glyphicon glyphicon-trash'></span>
                                </button>
                                ";
                            }
                            else{
                                $permission = "";
                            }
                            if ($row['category'] != $currentCategory) {
                                $currentCategory = $row['category'];
                                echo "<tr><th colspan='7' style='background: #f0f0f0;'>{$currentCategory}</th></tr>";
                            }
                            echo
                            "
                            <tr>
                                <form method='POST'>
                                    <td><input type='hidden' name='id' value='{$row['id']}'>{$row['id']}</td>
                                    <td>{$row['part_name']}</td>
                                    <td>{$row['category']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td><input class='form-control' type='text' name='note' value='{$row['note']}'></td>
                                    <td>
                                        <button type='submit' name='row' value='row' class='btn btn-warning btn-sm' onclick='removeRequiredAttributes()'>
                                            <span class='glyphicon glyphicon-pencil'></span>
                                        </button>". $permission ."
                                    </td>
                                </form>
                            </tr>
                            ";
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
        function removeRequiredAttributes() {
            // Get all input elements with the 'required' attribute
            var requiredInputs = document.querySelectorAll('input[required], select[required], textarea[required]');
            // Remove the 'required' attribute from each input
            requiredInputs.forEach(function(input) {
                input.removeAttribute('required');
            });
        }
        </script>
    </body>
</html>