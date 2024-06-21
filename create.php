<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto+Slab:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  </head>
  <body class="container">
      <?php
      
            include "connection.php";
            
            // Enable error reporting
            error_reporting(E_ALL);

            // Display errors
            ini_set('display_errors', 1);
            
            if(isset($_POST['submit']))
            {
                // write a prepared statement to insert data
                $insert = $connection->prepare("insert into kenworth(module, image, tagline, content) values(?,?,?,?)");
                $insert->bind_param("ssss", $_POST['module'], $_POST['image'], $_POST['tagline'], $_POST['content']);
                
                if($insert->execute())
                {
                    echo "
                        <div class='alert alert-success p-3 m-3'>Record successfully created</div>
                    ";
                }
                else
                {
                    echo "
                    <div class='alert alert-danger p-3 m-3'>Error: {$insert->error}</div>
                    ";
                }
            }
      
      ?>
    <h1>Create a new record.</h1>
    <p><a href="index.php" class="btn btn-dark">Back to index page.</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action="create.php" class="form-group">
            <label>Item Name:</label>
        <br>
        <input type="text" name="module" placeholder="Enter Item..." class="form-control">
        <br><br>
        
        <label>Class:</label>
        <br>
        <input type="text" name="tagline" placeholder="Class name..." class="form-control">
        <br><br>
        
        <label>Image:</label>
        <br>
        <input type="text" name="image" placeholder="images/name_of_image.png" class="form-control">
        <br><br>
        
        <label>Description:</label>
        <br>
        <textarea name="content" class="form-control" placeholder="Description..."></textarea>
        <br><br>
            <input type="submit" name="submit" class="btn btn-primary">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>