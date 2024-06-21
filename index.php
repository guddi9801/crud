 <!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>SCP Web Application</title>
      <link href="css/style.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto+Slab:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
   </head>
   <body class="container">
      <?php
      include "connection.php"; 
      ?> 
      <!-- Kenworth Nav Menu --> 
      <div>
         <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                      </li>
                      <?php foreach($Result as $link): ?> 
                        <li> 
                           <a href="index.php?link='<?php echo $link['module']; ?>'" class="nav-link text-light"><?php echo $link['module']; ?></a> 
                        </li>
                        <?php endforeach; ?> 
                        <li class="nav-item active"> 
                           <a href="create.php" class="nav-link text-light">Add New SCP Record</a> 
                        </li>
                    </ul>
                  </div>
                </div>
              </nav>
          </div>
          <h1 class="display-1 text-center">Welcome to the SCP Web Application</h1>
          <div class="rounded border shadow p-5"> 
      
         <?php  
            if(isset($_GET['link'])) 
            { 
                // remove single quotes from returned get value 
                // value to trim, character to trim out 
                $module = trim($_GET['link'], "'"); 
                // run sql command to retrieve record based on $module 
                // $record = $connection->query("select * from kenworth where module='$module'"); 
                // save each field in record as an array 
                // $array = $record->fetch_assoc(); 
                // prepared statement 
                $statement = $connection->prepare("select * from kenworth where module = ?"); 
                if(!$statement) 
                { 
                    echo "<p>Error in preparing sql statement</p>"; 
                    exit; 
                } 
                // bind parameters takes 2 arguments the type of data and the var to bind to. 
                $statement->bind_param("s", $module);
                if($statement->execute()) 
                { 
                    $get_result = $statement->get_result(); 
                    // check if record has been retrieved 
                    if($get_result->num_rows > 0) 
                    { 
                        $array = array_map('htmlspecialchars', $get_result->fetch_assoc()); 
                        $update = "update.php?update=" . $array['id'];
                        $delete = "index.php?delete=" . $array['id'];
                         echo "<div>
                        <h2 class='display-2'>{$array['module']}</h2> 
                        <h3 class='display-3'>{$array['tagline']}</h3> 
                        <p class='text-center'> 
                        <img src='{$array['image']}' alt='{$array['module']}' class='img-fluid h-50'> 
                        </p> 
                        <p>{$array['content']}</p>
                        <p>
                                <a href='{$update}' class='btn btn-info'>Update Record</a>
                                <a href='{$delete}' class='btn btn-warning'>Delete Record</a>
                        </p>
                        </div>"; 
                    } 
                    else 
                    { 
                        echo "<p>No record found for module: {$module}</p>"; 
                    } 
                } 
                else 
                { 
                    echo "<p>Error executing statement.</p>"; 
                } 
            } 
            else 
            { 
                // this will display the first time a user visits the site 
                echo "<h3 class='display-3'>SCP-002.</h3>
                <p>SCP-002 is to remain connected to a suitable power supply at all times, to keep it in what appears to be a recharging mode. In case of electrical outage</p>"; 
            } 
            
            if(isset($_GET['delete']))
            {
                $delID = $_GET['delete'];
                $delete = $connection->prepare("delete from kenworth where id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning'>Recorded Deleted...</div>";
                }
                else
                {
                     echo "<div class='alert alert-danger'>Error deleting record {$delete->error}.</div>";
                }
            }
            ?> 
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
   </body>
</html>