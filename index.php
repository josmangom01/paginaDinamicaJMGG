<!---
    Autor: José Manuel Gómez García
    Fecha: 9 de Septiembre del 2023
--->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div id="contenedor">
        <h1>Quenas Artesanales</h1>
        <div class="texto catalogo">

            <h2>Catalogo</h2>
            <table>
                <tr>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Imagen<th>
                </tr>
                <?php
                    $servername = "127.0.0.1";
                    $database = "quenas";
                    $username = "User1";
                    $password = "123";

                    // Create connection
                    $conn = mysqli_connect($servername, $username, $password, $database);
                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    //echo "Connected successfully" . "<br>";

                    $result = $conn->query("select * from flautas order by precio asc");
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>\n";
                            echo "<td>".$row["modelo"]."</td>";
                            echo "<td>$".$row["precio"]."</td>";
                            echo "<td><img class=\"imagen\" src=\"" . $row["imagen"]. "\"></td>\n";
                            echo "</tr>\n";
                        }
                    } else {
                        echo "0 results";
                    }
                    mysqli_close($conn);
                ?>
            </table>
        </div>

        <div>
            <h2>pedidos</h2>
            <form action="#fin" method="post">
                <table>
                    <tr>
                        <td>
                            <p>Nombre:</p>
                        </td>
                        <td>
                            <input type="text" name="nombre">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Modelo:</p>
                        </td>
                        <td>
                            <input type="text" name="modelo">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Cantidad:</p>
                        </td>
                        <td>
                            <input type="number" name="cantidad" value="0">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit">
                        </td>
                    </tr>
                </table>
            </form>
            <table class="resultado">
                <tr>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
                <tr>
                <?php
                    $conn = mysqli_connect($servername, $username, $password, $database);
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    if(isset($_POST['nombre']) &&  isset($_POST['modelo']) && isset($_POST['cantidad']))  {
                        $result = $conn->query("select precio from flautas where modelo=\"".$_POST["modelo"]."\"");
                        if ($result->num_rows > 0) {
                            $val = $result -> fetch_row();
                            echo "<td>".$_POST['nombre']."</td>";
                            echo "<td>".$_POST['modelo']."</td>";
                            echo "<td>".$_POST['cantidad']."</td>";
                            echo "<td>$ ".$val[0]."</td>";
                            echo "<td>$ ".($val[0]*$_POST["cantidad"])."</td>";
                        }
                        $insertSQL = "insert into pedidos VALUES (null  , '{$_POST['nombre']}', '{$_POST['modelo']}', {$_POST['cantidad']})";
                        if (($result = mysqli_query($conn, $insertSQL)) === false) {
                            die(mysqli_error($conn));
                        }
                    }
                    mysqli_close($conn);
                ?>
                </tr>
            </table>
        </div>
        <br>
        <br id="fin">
    </div>
</body>
</html>
