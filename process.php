<?php
if(!isset($_SESSION))
{
    session_start();
}

$mysqli = new mysqli('localhost', 'root', '', 'phpaste') or die(mysqli_error($mysqli));

$id_paste = 0;
$update = false;
$nom = '';
$paste = '';

if(isset($_POST['paste'])) {
    $nom = $_POST['nom'];
    $paste = $_POST['paste'];

    $mysqli->query("INSERT INTO paste (nom, paste) VALUES('$nom','$paste')") or die($mysqli->error);
   
   
    $_SESSION['message'] = "Votre paste a bien été enregistée";
    $_SESSION['msg_type'] = "success";

    header("Location: newpaste.php");
}

if(isset($_GET['delete'])){
    $id_paste = $_GET['delete'];
    $mysqli->query("DELETE FROM paste WHERE id_paste = $id_paste") or die($mysqli->error);
    
    $_SESSION['message'] = "Votre paste a bien été supprimée";
    $_SESSION['msg_type'] = "danger";

    header("Location: newpaste.php");

}

if(isset($_GET['edit'])){
    $id_paste = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM paste WHERE id_paste= $id_paste") or die($mysqli->error);
    if($result)
    {
        $row = $result->fetch_array();
        $nom = $row['nom'];
        $paste = $row['paste'];
    }
}

if(isset($_POST['redo'])){
    $id_paste = $_POST['id_paste'];
    $nom = $_POST['nom'];
    $paste = $_POST['paste'];

    $mysqli->query("UPDATE paste SET nom='$nom', paste='$paste' WHERE id_paste=$id_paste") or die($mysqli->error);

    $_SESSION['message'] = "Modifications enregistrées";
    $_SESSION['msg_type'] = "warning";

    header('Location: newpaste.php');
}