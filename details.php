<?php 
    include ('config/db_connect.php');

    if(isset($_POST['delete'])) {
        $id_to_delete =  mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM _food WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)) {
            //success
            header('Location: index.php');
        } else {
            //failure
            echo 'query error: ' . mysqli_error($conn);

        }
    }

    //check GET requset id param
    if(isset($_GET['id'])) {
         $id = mysqli_real_escape_string($conn, $_GET['id']);

    //make sql
    $sql = "SELECT * FROM _food WHERE id = $id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $food = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
    }

    
?>

<!DOCTYPE html>

    <?php include('templates/header.php'); ?> <br> <br>

    <div class="container center grey-text">
        <?php if($food): ?>

        <img src="<?php echo 'uploads/' . $food['picture'];?>" width="200px" height="150px">    

        <h4>
            <?php echo htmlspecialchars($food['title']);  ?>
        </h4>
        <p>
            Created by: <?php echo htmlspecialchars($food['email']); ?>
        </p>
        <p>
            At:  <?php echo htmlspecialchars($food['created_at']) ?>  
        </p>
        <h5> Ingredients:</h5>
        <p>
            <?php echo htmlspecialchars($food['ingredients']); ?>
        </p>

         <!-- DELETE FORM -->
         <form action="details.php" method="POST">
             <input type="hidden" name="id_to_delete" value="<?php echo $food['id'] ?>">
             <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
         </form>
     

        <?php else: ?>
        <h5 style="color: red !important;">
            No such food exists!
        </h5>
        <?php endif; ?>
    </div>


    <?php include ('templates/footer.php'); ?> 

</html>