<html>
    <body>

    <?php 

        function update_ingredients($conn,$ingredienti,$idPizza){
            foreach($ingredienti as $ingrediente){
                $query = mysqli_prepare($conn, "Select idIngrediente from ingrediente where nome= ?");
                $query->bind_param("s",$ingrediente);
                $query->execute();
                $res = $query -> get_result();
                $rows = $res-> fetch_row();
                $idIngrediente = $rows[0];
                $query = mysqli_prepare($conn, "Insert into composta (idPizza, idIngrediente) values (?,?)");
                $query->bind_param("ii",$idPizza,$idIngrediente);
                $query->execute();
            }
        }
        
        require_once "db.php";
        $nome = $_GET["nome"];
        $prezzo = $_GET["prezzo"];
        $ingredienti = $_GET["ingredienti"];
        if (isset($_GET["idPizza"])){
            $idPizza = $_GET["idPizza"];
            $query = mysqli_prepare($conn, "Update pizza set nome= ?, prezzo= ? where idPizza= ?");
            $query->bind_param("sdi",$nome,$prezzo,$idPizza);
            $query->execute();
            $query = mysqli_prepare($conn, "Delete from composta where idPizza= ?");
            $query->bind_param("i",$idPizza);
            $query->execute();
            update_ingredients($conn,$ingredienti,$idPizza);
        }
        else{
            $query = mysqli_prepare($conn, "Insert into pizza (nome, prezzo) values (?,?)");
            $query->bind_param("sd",$nome,$prezzo);
            $query->execute();
            $idPizza = $query->insert_id;
            update_ingredients($conn,$ingredienti,$idPizza);
        }
        header("Location: menu.php");
    ?>

    </body>
</html>