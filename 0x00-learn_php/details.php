<?php
require 'config/db_connect.php';

//check POST request id param
if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    //delete from DB
    $sql = "DELETE FROM pizzas WHERE id=$id_to_delete";
    if(mysqli_query($conn, $sql)){
        header('Location: index.php');
    } else {
        echo "query error: " . mysqli_error($conn);
    }
}

//check GET request id param
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //fetch details from DB
    $sql = "SELECT * FROM pizzas WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $pizza = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en-GB">
<?php require 'templates/header.php';?>
<div class="container center grey-text">
    <?php if ("pizza"): ?>
        <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
        <p>Created by: <?php echo htmlspecialchars($pizza['email']) ;?></p>
        <p>Created at: <?php echo date($pizza['created_at']) ;?></p>
        <h5>Ingredients</h5>
        <ul><?php foreach($pizza['ingredients'] as $ingredient): ?>
            <li><?php echo htmlspecialchars($ingredient);?></li>
        <?php endforeach?></ul>
    <?php else: ?>
        <h5>No such pizza exists</h5>
    <?php endif ?>

    <!-- delete form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>"/>
        <input type="submit" name="delete" vallue="Delete" class="btn brand z-depth-0"/>
    </form>
</div>
<?php require 'templates/footer.php';?>
</html>