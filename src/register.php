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
        <div class='md-5 login-container'>
            <form method='post' class='login-form' action='action_login.php'>
                <div class='mb-3 row'>
                    <label for='username' class='form-label text_bold text_bold'>Username</label>
                    <input class='form-control' type='text' name='user' value='' required>
                </div>
                <div class='mb-3 row'>
                    <label for='password' class='form-label text_bold text_bold'>Password</label>
                    <input class='form-control' type='pass' name='pass' value='' required>
                </div>
                <div class='mb-3 row'>
                    <label for='password' class='form-label text_bold text_bold'>Permission</label>
                    <input class='form-control' type='permission' name='permission' value='' required>
                </div>
                <div class='mb-3 row'>
                    <button type='submit' name='register' value='0' class='btn btn-info btn-sm'> Register
                        <span class='glyphicon glyphicon-log-in'></span>
                    </button>
                </div>
            </form>
        </div>
        
        <script>

        </script>
    </body>
</html>
