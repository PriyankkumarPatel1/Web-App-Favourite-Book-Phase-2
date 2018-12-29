<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Lovers</title>
      <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    
<?php
  
  //initializing variables 
  $ID_Number = null;
  $book_title = null; 
  $book_genre = null; 
  $book_review = null; 
  $full_name = null; 
  $email = null; 
  $link_to_website = null;
  //$photo = null;
  
 if(!empty($_GET['ID_Number'])  && (is_numeric($_GET['ID_Number'])))
  {
    //grab the movie id from the URL string 
    $ID_Number = $_GET['ID_Number'];
    
    //connect to the db
    require('db.php');
    
    //set up your query 
    $sql = "SELECT * FROM books WHERE ID_Number = :ID_Number";
    
    //prepare 
    $cmd = $conn->prepare($sql);
    
    //bind 
    $cmd->bindParam(':ID_Number', $ID_Number);
    
    //execute 
    $cmd->execute(); 
    
    //use fetchAll method to store info in an array 
    $books = $cmd->fetchAll(); 
    
    //loop through array using foreach and set variables
    foreach ($books as $book) {
      $book_title = $book['book_title']; 
      $book_genre = $book['book_genre'];
      $book_review = $book['book_review'];
      $full_name = $book['full_name'];
      $email = $book['email'];
      $link_to_website = $book['link_to_website'];
      //$photo = $book['photo'];
    }
    
    //close the database connection 
    
    $conn = null; 
  }

?>

<!-- HTML form to allow uesr to input data -->
  <div class="container">
     <h1> Book Lovers </h1>
     <!--link to database information-->
     <a href="books.php"> View All Books </a>
                     
     <form method="post" action="save_book.php" enctype="multipart/form-data">
      
        <div class="form-group">
          <label> Title of Book: </label>
          <input type="text" name="book_title" class="form-control" value="<?php echo $book_title ?>">
        </div> 
       
        <div class="form-group">
          <label> Genre of Book: </label>
          <input type="text" name="book_genre" class="form-control"  value="<?php echo $book_genre ?>">
        </div> 
       
        <div class="form-group">
          <label> Review: </label>
          <input type="text" name="book_review" class="form-control"  value="<?php echo $book_review ?>">
        </div> 
       
        <div class="form-group">
          <label> Your Full Name: </label>
          <input type="text" name="full_name" class="form-control"  value="<?php echo $full_name ?>">
        </div> 

        <div class="form-group">
          <label> email: </label>
          <input type="text" name="email" class="form-control"  value="<?php echo $email ?>">
        </div> 
      
        <div class="form-group">
          <label> Link to buy a book: </label>
          <input type="text" name="link_to_website" class="form-control"  value="<?php echo $link_to_website ?>">
        </div> 

        <div class="form-group">
    
          <label for="photo"> Photo:</label>
          <input type="file" id="photo" name="photo" class="form-control">
        </div>
        

        <!-- <div class="form-group">
          <label for="photo"> Photo:</label>
          <input type="file" name="photo" class="form-control">
        </div> -->

     <input name="ID_Number" type="hidden" value="<?php echo $ID_Number ?>">
      <!--Sun=bmit button of the form-->
      <input type="submit" name="submit" value="Submit Book Details" class="btn btn-primary">
          
     </form>

  </div>

</body>
</html>