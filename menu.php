<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pizzeria - Menu</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/menu.css">
    </head>

    <body>
        <div id="navigation"></div>
        <script src="js/loadnav.js"></script>

        <div id="container">
            <div id="header">
                <h1>Menu</h1>
            </div>

            <?php
            require_once "db.php";
            $query = mysqli_prepare($conn, "Select * from pizza");
            $query->execute();
            $res = $query -> get_result();
            $rows = $res-> fetch_all(MYSQLI_ASSOC);
            ?>
        
            <div id="menu">
                <table>
                    <tr>
                        <th>Nome</th>
                        <th>Prezzo</th>
                        <th>Ingredienti</th>
                    <?php
                    foreach($rows as $row){
                        echo "<tr>";
                        $idPizza = $row["idPizza"];
                        echo "<td>".$row['nome']."</td>";
                        echo "<td>".$row['prezzo']."€</td>";

                        $query = mysqli_prepare($conn, "Select nome from ingrediente natural join composta where idPizza= (select idPizza from pizza where nome= ?)");
                        $query->bind_param("s",$row['nome']);
                        $query->execute();
                        $res = $query -> get_result();
                        $ingredients = $res-> fetch_all(MYSQLI_ASSOC);
                        echo "<td>";
                        foreach($ingredients as $ingredient){
                            echo $ingredient['nome'].",";
                        }
                        echo "</td>";
                        echo"<td>"."<a style='color:red;' href='deletePizza.php?idPizza=".$idPizza."'>Elimina</a>"."</td>";
                        echo"<td>"."<a href='pizza_adder.php?idPizza=".$idPizza."'>Modifica</a>"."</td>";
                        echo "</tr>";
                    }

                    ?>
                </table>
            </div>
            <div>
                <form>
                    <input style="background-color: green; color:white" type="button" value="Aggiungi pizza" onclick="window.location.href='pizza_adder.php'">

                </form>
            </div>
        </div>
    </body>
</html>