<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pizzeria</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div id="navigation"></div>
        <script src="js/loadnav.js"></script>
    
        <div id="container">
            <div id="header">
                <h1>Aggiungi/Modifica pizza</h1>
            </div>
        <?php 

            require_once "db.php";
            if(isset($_GET["idPizza"])){
                $idPizza=$_GET['idPizza'];
                $query = mysqli_prepare($conn, "Select * from pizza where idPizza= ?");
                $query->bind_param("i",$idPizza);
                $query->execute();
                $res = $query -> get_result();
                $row = $res-> fetch_assoc();
                $query = mysqli_prepare($conn, "Select nome from ingrediente natural join composta where idPizza= ?");
                $query->bind_param("i",$idPizza);
                $query->execute();
                $res = $query -> get_result();
                $ingredients = $res-> fetch_all(MYSQLI_ASSOC);
                $nome = $row['nome'];
                $prezzo = $row['prezzo'];
            }
        ?>
        <form method="get" action="addPizza.php">
            <label for="nome">Nome</label>
            <input type="hidden" name="idPizza" value="<?php echo $idPizza ?>">
            <input type="text" name="nome" id="nome" value="<?php echo $nome?>" required>

            <label for="prezzo">Prezzo</label>
            <input type="number" step="0.01" name="prezzo" id="prezzo" value= "<?php echo $prezzo?>" required>
                <option value="">Seleziona gli ingredienti</option>
                <?php
                $query = mysqli_prepare($conn, "Select nome from ingrediente order by nome");
                $query->execute();
                $res = $query -> get_result();
                $rows = $res-> fetch_all(MYSQLI_ASSOC);
                foreach($rows as $row){
                    $checked = "";
                    foreach($ingredients as $ingredient){
                        if($ingredient['nome'] == $row['nome']){
                            $checked = "checked";
                            break;
                        }
                    }
                    echo "<input ".$checked." type='checkbox' name='ingredienti[]' id='ingredienti' value='".$row['nome']."'>".$row['nome']."<br>";
                }
                ?>
            <input type="submit" value="Conferma">

        </form>
        </div>
        
    </body>