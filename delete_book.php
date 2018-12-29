<?php ob_start(); 

$person_id = $_GET['ID_Number'];

//connect

require_once('db.php'); 

// set up sql query 

$sql = "DELETE FROM books WHERE ID_Number = $person_id";

//prepare 

$cmd = $conn->prepare($sql); 

//bind 

$cmd->bindParam(':ID_Number', $ID_Number, PDO::PARAM_INT);

//execute 

$cmd->execute(); 

// close the connection 

$conn = NULL; 

header('location:home.php'); 


ob_flush(); 

?>