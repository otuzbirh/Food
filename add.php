<?php

include('config/db_connect.php');

$email = $title = $ingredients = '';
$image;
$errors = array('email' => '', 'title' => '', 'ingredients' => '', 'image' => '');

if (isset($_POST['submit'])) {

    //email validation
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required <br />';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'email must be a valid email address';
        }
    }

    //title validation
    if (empty($_POST['title'])) {
        $errors['title'] = 'Title is required <br />';
    } else {
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = "Title must be letters and spaces only";
        }
    }


    //ingredients validation
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'Ingredients are required <br />';
    } else {
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors['ingredients'] = 'Ingredients must be a comma separated list';
        }
    }

    // IMAGES SETTINGS //


    if (isset($_FILES['imageToUpload'])) {
        $imgFile = $_FILES['imageToUpload'];
        // File Properties
        $fileName = $imgFile['name'];
        $fileTmpDir = $imgFile['tmp_name'];
        $fileSize = $imgFile['size'];
        $fileError = $imgFile['error'];

        // File Extension Properties
        $fileExt = explode('.', $fileName);
        $fileExt = strtolower(end($fileExt));

        $allowedFiles = array('jpg', 'png');

        if (in_array($fileExt, $allowedFiles)) {
            if ($fileError == 0) {
                if ($fileSize <= 2097152) {
                    $fileNewName = $_food['id'] . uniqid('img_') . '.' . $fileExt;
                    $fileDestination = 'uploads/' . $fileNewName;
                    if (move_uploaded_file($fileTmpDir, $fileDestination)) {
                        $image = $fileNewName;
                    }
                } else {
                    echo "File is too large";
                }
            } else {
                echo "File has errors";
            }
        } else {
            echo "Unknown errors!";
        }
    }

 


    if (array_filter($errors)) {
        echo "Errors ???";
    } else {

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
        //$image = mysqli_real_escape_string($conn, $_POST['imageToUpload']);
        global $image;
        //create sql
        $sql = "INSERT INTO _food(title, email, ingredients, picture) VALUES ('$title', '$email', '$ingredients', '$image' )";

        //save to db and check
        if (mysqli_query($conn, $sql)) {
            //success
            header('Location: index.php');
        } else {
            //error
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}



//END OF POST CHECK

?>
<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">
        Add a food
    </h4>

    <form class="white" action="add.php" method="POST" id="hadzo" enctype="multipart/form-data">
        <label>Your Email: </label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"> <?php echo $errors['email']; ?> </div>
        <label>Food Title: </label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"> <?php echo $errors['title']; ?> </div>
        <label>Ingredients (comma separated): </label>
        <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
        <div class="red-text"> <?php echo $errors['ingredients']; ?> </div>
        <label>Image (.png / .jpg): </label> <br> <br>
        <input type="file" name="imageToUpload">
        <span id="selectedFileText"></span> 
        <div class="red-text"> <?php echo $errors['image']; ?> </div> <br>
        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-3">
        </div>
    </form>

</html>

<script>
    $('#hadzo').bind('change', function() {
        var fileName = '';
        fileName = $(this).val();
        //$('#selectedFile').html(fileName);
        $('#selectedFileText').html('Selected File: ' + fileName);

    });
</script>