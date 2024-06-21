<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update a record</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto+Slab:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  </head>
  <body class="container">
      
     <?php
     
            // Enable error reporting
            error_reporting(E_ALL);

            // Display errors
            ini_set('display_errors', 1);
     
            include "connection.php";
            
            // initialise $row as empty array
            $row = [];
            
            // directed from index page record [update] button
            if(isset($_GET['update']))
            {
                $id = $_GET['update'];
                // based on id select appropriate record from db
                $recordID = $connection->prepare("select * from kenworth where id = ?");
                
                if(!$recordID)
                {
                    echo "<div class='alert alert-danger p-3 m-2'>Error preparing record for updating.</div>";
                    exit;
                }
                
                $recordID->bind_param("i", $id);
                
                if($recordID->execute())
                {
                    echo "<div class='alert alert-success p-3 m-2'>Record ready for updating.</div>";
                    $temp = $recordID->get_result();
                    $row = $temp->fetch_assoc();
                }
                else
                {
                    echo "<div alert alert-danger p-3 m-2>Error: {$recordID->error}</div>";
                }
            }
            
           if(isset($_POST['update']))
           {
                // write a prepare statement to update data
                $update = $connection->prepare("update kenworth set module=?, tagline=?, content=?, image=?  where id=?");
            
                $update->bind_param("ssssi", $_POST['module'], $_POST['tagline'], $_POST['content'], $_POST['image'], $_POST['id']);
                
                if($update->execute())
                {
                    echo "<div class='alert alert-success p-3 m-2'>Record updated successfully</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger p-3 m-2'>Error: {$update->error}</div>";
                }
           }
      ?>
    <h1>Update record</h1>
    <p><a href="index.php" class="btn btn-dark">Back to index page.</a></p>
    <form method="post" action="update.php" class="form-group">
        <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
        <label>Item Name:</label>
        <br>
        <input type="text" name="module" placeholder="Enter Item..." class="form-control" value="<?php echo isset($row['module']) ? $row['module'] : ''; ?>">
        <br><br>
        
        <label>Class:</label>
        <br>
        <input type="text" name="tagline" placeholder="Tagline..." class="form-control" value="<?php echo isset($row['tagline']) ? $row['tagline'] : ''; ?>">
        <br><br>
        
        <label>Image:</label>
        <br>
        <input type="text" name="image" placeholder="images/name_of_image.png" class="form-control" value="<?php echo isset($row['image']) ? $row['image'] : ''; ?>">
        <br><br>
        
        <label>Description:</label>
        <br>
        <textarea name="content" class="form-control"><?php echo isset($row['content']) ? $row['content'] : ''; ?></textarea>
        <br><br>
        <input type="submit" name="update" value="Update Record" class="btn btn-primary">
        
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>