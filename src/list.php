<?php include 'sql_list.php'; ?>
<!DOCTYPE html>
<html lang="en">
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
        if ($_SESSION['permission'] < 0) {
            echo "
            <form method='POST'>
                <div class='container'>
                    <div class='row'>
                        <button type='submit' name='database' value='export' class='btn-s btn btn-warning'>
                            Back Up Database
                            <span class='glyphicon glyphicon-wrench'></span>
                        </button>
                        <div class='empty-span-s'></div>
                        <button type='submit' name='database' value='import' class='btn-s btn btn-info'>
                            Restore Database
                            <span class='glyphicon glyphicon-wrench'></span>
                        </button>
                    </div>
                </div>
            </form>";
        }
        ?>

        <!-- Form to submit all IDs -->
        <form method="POST">
            <table class='table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currentCategory = '';
                    // Generate table rows
                    if(isset($data)) {
                        foreach ($data as $row) {
                        
                        if ($row['category'] !== $currentCategory) {
                            $currentCategory = $row['category'];
                            echo "<tr><th colspan='7' style='background: #f0f0f0;'>{$currentCategory}</th></tr>";
                        }
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['part_name']}</td>
                                <td>{$row['category']}</td>
                                <td><input class='checkbox-medium' type='checkbox' name='selected[]' value='{$row['id']}'></td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class='container'>
                <div class='row'>
                    <button type='submit' name='update' value='update' class='btn btn-success btn-sm btn-l'>
                        Update
                        <span class='glyphicon glyphicon-wrench'></span>
                    </button>
                </div>
            </div>
            <!-- Submit Button -->
        </form>

    </body>
</html>
