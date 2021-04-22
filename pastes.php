<?php 
    session_start();
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
        die();
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Vos Pastes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>      
        <div class="container">
            <div class="col-md-12">

                <div class="text-center">
                    <h1 class="p-5">Paste Something</h1>
                    <hr />

                    <p>Ajoute un Paste à ta liste</p>
                    <?php require_once 'process.php'; ?>

                    <?php
                        if(isset($_SESSION['message'])):
                    ?>
                    <div class="alert alert-<?=$_SESSION['msg_type']?>">
                            <?php
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            ?>
                    </div>
                    <?php
                        endif
                    ?>


                    <div class="container">
                        <?php
                            $mysqli = new mysqli('localhost','root','','phpaste') or die(mysqli_error($mysqli));
                            $result = $mysqli->query("SELECT * FROM paste") or die($mysqli->error);
                            //pre_r($result);

                        ?>
                        
                        <div class="row justify-content-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>paste</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>

                                <?php
                                    while($row = $result->fetch_assoc()):
                                ?>

                                <tr>
                                    <td><?php echo $row['nom']; ?></td>
                                    <td><?php echo $row['paste']; ?></td>
                                    <td>
                                        <a href="newpaste.php?edit=<?php echo $row['id_paste'];?>" class="btn btn-info">Update</a>
                                        <a href="process.php?delete=<?php echo $row['id_paste'];?>" class="btn btn-danger">Delete</a>
                                        
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                        
                        <?php   
                            function pre_r($array) {
                                echo '<pre>';
                                print_r($array);
                                echo '</pre>';
                            }
                        ?>
                         <div class="deco">
							<p class="text-center"><a href="newpaste.php" >Paste Something</a></p>
                            <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
                         </div>
   
                    </div>
                </div>
            </div>
        </div>
        <style>

            .form-group input {
                width: 1000px;
            }
			.container {
                width: 340px;
                margin: 50px auto;
            }
            .table {
                margin-bottom: 15px;
                background:WHITE;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
			.deco {
                margin-bottom: 15px;
                background:WHITE;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
			
            .deco a {
                margin-bottom: 50px;
            }
			body {
                background-image: url(images/paste.jpg);
            }

        </style>
  </body>
</html>