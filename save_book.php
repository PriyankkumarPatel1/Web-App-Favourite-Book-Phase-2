<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Saving your book information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
</head>
<body>

<?php
// store the form inputs in variables
$book_title = filter_input(INPUT_POST, 'book_title');
$book_genre =  filter_input(INPUT_POST, 'book_genre');
$book_review =  filter_input(INPUT_POST, 'book_review');
$full_name = filter_input(INPUT_POST, 'full_name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$link_to_website = filter_input(INPUT_POST, 'link_to_website');
$photo = filter_input(INPUT_POST, 'photo');

  
// add the movie id in case you are editing 

$ID_Number = NULL; 
$ID_Number = $_POST['ID_Number'];
  
//set up a flag variable 
  
$ok = true; 

//checking if name is filled in
  
if(empty($book_title)) {
  echo "<p> Book title is required.</p>";
  $ok = false; 
}
if(empty($book_genre)) {
    echo "<p> Book genre is required.</p>";
    $ok = false; 
}
if(empty($book_review)) {
    echo "<p> Your Review will be very useful.</p>";
    $ok = false; 
}
if(empty($full_name)) {
    echo "<p> Full name is required.</p>";
    $ok = false; 
}
if(empty($link_to_website)) {
    echo "<p> Link to website for is required.</p>";
    $ok = false; 
}
  
//check if user has provided email 
  
if(empty($email)) {
  echo "<p> Email is required.</p>";
  $ok = false; 
}

  
//check that email is valid 
  
if($email === FALSE ) {
  echo "<p> Email is not valid.</p>";
  $ok = false; 
}
  
//check that movie was filled out 
  
if($ok == TRUE) {

    // connecting to the database
    require_once('db.php'); 
    require_once('appvars.php'); 
    
    if(isset($_POST['submit'])){

      $photo = $_FILES['photo']['name'];
      $photo_type = $_FILES['photo']['type'];
      $photo_size = $_FILES['photo']['size']; 

      $target = UPLOADPATH . $photo;
      if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){
        echo '<div class="container"><div class="alert alert-success"><center>
    <strong>Success!</strong> Your all data including image is successfully stored in database!</center>
  </div></div>';
      }
      else{
        echo '<div class="container"><div class="alert alert-danger"><center>
    <strong>Sorry!</strong> Error saving your image!</center></div></div>';
      }

    //add this for update 
    if(!empty($ID_Number)) {
      $sql = "UPDATE books SET book_title = :book_title, book_genre = :book_genre, book_review = :book_review, full_name = :full_name, email = :email, link_to_website = :link_to_website, photo = :photo WHERE ID_Number = :ID_Number";  
        
      }
      //take out else and start with insert 
     else {
      
      // set up an SQL command to save the new game
      $sql = "INSERT INTO books (book_title, book_genre, book_review, full_name, email, link_to_website, photo) VALUES (:book_title, :book_genre, :book_review, :full_name, :email, :link_to_website, :photo)";
      
      }
    }

    // set up a command object
    $cmd = $conn->prepare($sql);

    // fill the placeholders with the 4 input variables
    $cmd->bindParam(':book_title', $book_title);
    $cmd->bindParam(':book_genre', $book_genre);
    $cmd->bindParam(':book_review', $book_review);
    $cmd->bindParam(':full_name', $full_name);
    $cmd->bindParam(':email', $email);
    $cmd->bindParam(':link_to_website', $link_to_website);
    $cmd->bindParam(':photo', $photo);
  
    if(!empty($ID_Number)) {
      $cmd->bindParam(':ID_Number', $ID_Number);   
    }

    // execute the insert
    $cmd->execute();

    // disconnecting
    $cmd->closeCursor();
  }
  

?>

<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><h2>User Guide</h2></button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Basic Instructions for you</h4>
        </div>
        <div class="modal-body">
          <p>Here by directly viewing books you can see all the detalis of books but can't edit or delete the entries from database.</p>
          <p>For that you have to login / Sign up by clicking Pro Version button... Cheers </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<p><a href="index.php">Add new BOOK to database</a></p>
<p><a href="books.php"> View All Books </a></p>
    
</body>
</html>