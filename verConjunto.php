<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Conjunto</title>
    <style>
        body {
            background-color: #03d8fc;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        div{
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            border-radius: 20px;
        }

        img {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 520px;
            height: 640px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        a {
            margin-top: 20px;
            text-decoration: none;
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }

        .descarga {
            background-color: #28a745;
        }

        .descarga:hover {
            background-color: #1f862d;
        }
    </style>
</head>

<body>
    <div>
        <?php
        include_once 'Conexion.php';
        session_start();

        if (isset($_GET['id'])) {
            try {
                $_SESSION['id'] = $_GET['id'];
                $BD = new Conectar();
                $conn = $BD->getConexion();
                $stmt = $conn->prepare('SELECT * FROM marcas WHERE id = :id');
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $marca = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo '<h1>' . $marca['nombre'] . '</h1>';
                    echo '<p>Año de Creación: ' . $marca['añoCreacion'] . '</p>';
                    echo '<p>Lugar de Creación: ' . $marca['lugarCreacion'] . '</p>';
                    $imagenBlob = $marca['prenda'];
                    $imagenMIME = 'image/jpeg';
                    echo '<img src="data:' . $imagenMIME . ';base64,' . base64_encode($imagenBlob) . '" alt="Conjunto de la marca">';
                } else {
                    echo 'Conjunto no encontrado.';
                }
            } catch (PDOException $ex) {
                echo 'Error: ' . $ex->getMessage();
            }
        } else {
            echo 'ID de conjunto no proporcionado.';
        }
        ?>
        <a href="../<?php echo $marca['logo']?>" class="descarga">Ver logo de la marca</a>
        <a href="../verTabla.php">Volver</a>        
    </div>
</body>

</html>