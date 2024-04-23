<?php
require 'config/db_connect.php';



$email = $title = $ingredients = "";
$errors = [
    "email"=>"",
    "title"=>"",
    "ingredients"=>"",
];

if(isset($_POST['submit'])){
    //check email
    if(empty($_POST["email"])){
        $errors['email'] = "An email is required <br/>";
    } else {
        $email = $_POST["email"];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Enter a valid email address";
        }
    }

    //check title
    if(empty($_POST["title"])){
        $errors['title'] = "A title is required <br/>";
    } else {
        $title = $_POST["title"];
        if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
            $errors['title'] = "Use letters and spaces only" ;
        }
    }

    //check ingredients
    if(empty($_POST["ingredients"])){
        $errors['ingredients'] = "At least one ingredient is required <br/>";
    } else {
        $ingredients = $_POST["ingredients"];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
            $errors['ingredients'] = "Ingredients must be a comma-seperated list" ;
        }
    }

    //no errors: redirect user, store data to DB
    if(!array_filter($errors)){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        //data to DB
        $sql = "INSERT INTO pizzas (email, title, ingredients) VALUES ('$email', '$title', '$ingredients')";
        if(mysqli_query($conn, $sql)){
            header('Location: index.php');
        } else {
            echo "query error " . mysqli_error($conn); 
        }
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en-GB">
    <?php require 'templates/header.php';?>
    <section class="container grey-text">
        <h4 class="center">Add a pizza</h4>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="white">
            <label for="email"> Your email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"/>
            <div class="red-text"> <?php echo $errors['email'];?></div>
            <label for="title">Give your pizza a title</label>
            <input type="text" name="title" value=<?php echo htmlspecialchars($title); ?>/>
            <div class="red-text"> <?php echo $errors['title'];?></div>
            <label for="ingredients">Add your ingredients (comma-seperated)</label>
            <input type="text" name="ingredients" value=<?php echo htmlspecialchars($ingredients); ?>/>
            <div class="red-text"> <?php echo $errors['ingredients'];?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>
    <?php require 'templates/footer.php';?>
</html>