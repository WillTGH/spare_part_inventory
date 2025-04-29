<!DOCTYPE html>
<html lang='en'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js';></script>
    <head>
        <title>Spare Part List</title>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
        <link rel='stylesheet' type='text/css' href='style.css'>
    </head>
    <body>
        <?php
        include 'sql_inoutflow.php';
        ?>
        <nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
            <div class='container' id='navbar'>
                <a class='navbar-brand' href='index.php'>BMS</a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarNav'>
                    <ul class='navbar-nav ms-auto'>
                        <li class="nav-item">
                            <a class="nav-link" href="list.php">List Item</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='in_log.php'>Log Masuk</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='out_log.php'>Log Keluar</a>
                        </li>
                    </ul>
                </div>
                <a class="navbar-brand" href="index.php"><?php echo $_SESSION['username']. $_SESSION['permission']; ?></a>
            </div>
        </nav>
        <div class='md-5 content'>
            <form method='post'>
                <div class='row'>
                    <div class='mb-3 col-md-3'>
                        <label for='issued_by' class='form-label text_bold text_bold'>Nama Admin</label>
                        <input class='form-control' type='text' name='issued_by' value='<?php echo $_SESSION['username'] ?>' required readonly>
                    </div>
                </div>
                <div class='empty-span-m'></div>
                <table>
                    <tr>
                        <td>
                            <input class='checkbox1 checkbox-medium' type='checkbox' name='flow' value='in' onclick='toggleCheckbox(this)' required> Barang Masuk
                            <div class='empty-span-s'></div>
                            <input class='checkbox2 checkbox-medium' type='checkbox' name='flow' value='out' onclick='toggleCheckbox(this)' required> Barang Keluar
                        </td>
                    </tr>
                </table>
                    
                <div class='row'>
                    <div class='mb-3'>
                        <table id='myTable' class='table'>
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Part Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Jumlah Keluar / Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $table = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach($table as $row):
                                ?>
                                    <tr>
                                        <td><input class='form-control' type='hidden' name='ids[]' value='<?php echo isset($row['id']) ? $row['id'] : '';?>'><?php echo isset($row['id']) ? $row['id'] : '';?></td>

                                        <td><input class='form-control' type='hidden' name='part_name' value='<?php echo isset($row['part_name']) ? $row['part_name'] : '';?>'><?php echo isset($row['part_name']) ? $row['part_name'] : '';?></td>

                                        <td><?php echo isset($row['category']) ? $row['category'] : '';?></td>

                                        <td><input class='form-control' type='hidden' name='quantity[]' value='<?php echo isset($row['quantity']) ? $row['quantity'] : '';?>'><?php echo isset($row['quantity']) ? $row['quantity'] : '';?></td>

                                        <td><input class='form-control' type='text' name='inout[]' value='0'></td>
                                        <!-- Add more table cells based on your database columns -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='container'>
                    <div class='row'>
                        <button type='submit' name='update' value='update' class='btn btn-success btn-sm btn-l'>
                            Update
                            <span class='glyphicon glyphicon-wrench'></span>
                        </button>
                    </div>
                </div>
            </form>
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
        function toggleCheckbox(selectedCheckbox) {
            let row = selectedCheckbox.closest("tr"); // Find the current row
            let checkbox1 = row.querySelector(".checkbox1");
            let checkbox2 = row.querySelector(".checkbox2");

            // Disable the other checkbox when one is selected
            if (selectedCheckbox === checkbox1) {
                checkbox2.disabled = checkbox1.checked;
            } else {
                checkbox1.disabled = checkbox2.checked;
            }

            // Remove 'required' from both checkboxes if one is selected
            if (checkbox1.checked || checkbox2.checked) {
                checkbox1.removeAttribute("required");
                checkbox2.removeAttribute("required");
            } else {
                checkbox1.setAttribute("required", true);
                checkbox2.setAttribute("required", true);
            }
        }

        // Validate before submission
        document.getElementById("myForm").addEventListener("submit", function(event) {
            let rows = document.querySelectorAll("tr");
            let valid = true;

            rows.forEach(row => {
                let checkbox1 = row.querySelector(".checkbox1");
                let checkbox2 = row.querySelector(".checkbox2");

                // If neither checkbox is checked, prevent form submission
                if (!checkbox1.checked && !checkbox2.checked) {
                    checkbox1.setAttribute("required", true);
                    checkbox2.setAttribute("required", true);
                    valid = false;
                }
            });

            if (!valid) {
                event.preventDefault(); // Stop form submission if validation fails
                alert("Please select at least one checkbox in each row.");
            }
        });
        </script>
    </body>
</html>
