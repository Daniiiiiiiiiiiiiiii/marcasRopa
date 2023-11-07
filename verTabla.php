<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #d8d4bc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            max-width: 800px;
            border: 2.5px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #c2c292;
        }

        tr:hover {
            background-color: #c2b698;
        }

        a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        a:hover {
            color: #877678;
            
        }
        img{
            max-width: 60px;
        }
    </style>
</head>
<body>
    <h1>Tabla de Marcas</h1>
    <table>
        <thead>
            <th>Nombre</th>
            <th>Año de Creación</th>
            <th>Lugar de Creación</th>
            <th>Logo</th>
            <th>Conjunto</th>
            <th>Más detalles</th>
        </thead>
        <tbody>
            <tr>
                <?php
                    session_start();
                    try{
                        include_once 'Conexion.php';

                        $BD = new Conectar();
                            $conn = $BD->getConexion();
                            $stmt = $conn->prepare('SELECT * FROM marcas');
                            $stmt->execute();
                            $stmt->setFetchMode(PDO::FETCH_ASSOC);

                            while($marca = $stmt->fetch()){
                                echo "<td>" . $marca['nombre'] . "</td>". 
                                    "<td>" . $marca['añoCreacion'] . "</td>".
                                    "<td>" . $marca['lugarCreacion'] . "</td>". 
                                    "<td><img src='" . $marca['logo'] . "' alt=''</td>".
                                    '<td><img src="data:image/jpeg;base64,' . base64_encode($marca['prenda']) . '" alt="Conjunto de la marca"></td>'.
                                    "<td><a href='verConjunto/". $marca['id'] ."'>Ver detalles</a></td>";
                                echo "</tr>";
                            }                            
                    } catch (PDOException $ex){
                        print "¡Error!: " . $ex->getMessage() . "<br/>";
                        exit;
                    }                    
                ?>
            </tr>
        </tbody>
    </table>
    
    <?php
        if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 'Administrador'){
            echo "<a href='MenuAdmin.php'>Volver</a>";   
            echo '<a href="Bienvenida.html">Cerrar Sesión</a>';
        } else{
            echo '<a href="Bienvenida.html">Cerrar Sesión</a>';
        }
    ?>
</body>
</html>