<?php
//import the db connection file
require_once('config/db_connect.php');

//query for getting all data from database
$sql = 'SELECT title, ingredients, id, picture FROM _food ORDER BY created_at';

//get results
$result = mysqli_query($conn, $sql);

//fetching the resulting rows as an array
$_food = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory'
mysqli_free_result($result);

// close connection
mysqli_close($conn);


?>
<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<h4 class="center grey-text">Food!</h4>

<div class="container">
    <div class="row">

        <?php foreach ($_food as $food) : ?>
            <div class="col s6 md3">
                <div class="card z-depth-0">

                    <div class="card-content center">
                        <img class="center" src="<?php echo 'uploads/' . $food['picture']; ?>" width="100px" height="64px">
                        <h6><?= htmlspecialchars($food['title']); ?></h6>
                        <ul><?php foreach (explode(',', $food['ingredients']) as $ing) : ?>
                                <li><?= htmlspecialchars($ing); ?> </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="card-action right-align">
                        <a href="details.php?id=<?= $food['id'] ?>" class="brand-text">more info</a>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>
    </div>
</div>


<?php include('templates/footer.php'); ?>



</html>