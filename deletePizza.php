<!DOCTYPE html>
<html>
    <body>

    <?php 
        require_once "db.php";
        $idPizza = $_GET["idPizza"];
        $query = mysqli_prepare($conn, "Delete from pizza where idPizza= ?");
        $query->bind_param("i",$idPizza);
        $query->execute();
        header("Location: menu.php");
    ?>
    </body>
</html>