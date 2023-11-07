<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inserción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #FF6B6B, #6078EA);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: linear-gradient(90deg, #FFC3A0, #FFAFBD);
        }

        input[type="file"] {
            background: linear-gradient(90deg, #A0E8B7, #8EF9F3);
        }

        input[type="submit"] {
            background: linear-gradient(45deg, #4D00E1, #8E2DE2);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: linear-gradient(45deg, #8E2DE2, #4D00E1);
        }

        h1 {
            color: #8E2DE2;
        }
        .error{ color: black; font-weight: bold;}
    </style>
</head>
<body>
    <?php
    $errCred = '';
    if(isset($_POST['Enviar'])){
        if (!empty($_POST['nombre'])) {
            if(!empty($_POST['año'])){
                if(!empty($_POST['lugar'])){
                    if(!is_string($_POST['nombre'])) {
                        $errCred = 'Nombre de la marca no válido';
                    }
                    if(!is_string($_POST['lugar'])) {
                        $errCred = ' lugar de creación no válido';
                    }
                    $nombre = $_POST['nombre'];
                    $año = $_POST['año'];
                    $lugar = $_POST['lugar'];
                    //Verificamos que se haya introducido un archivo como logo
                    if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
                        $nombreDirectorio = 'imgs/';
                        $nombreFichero = $_FILES['logo']['name'];
                        $nombreCompleto = $nombreDirectorio . $nombreFichero;
                        $tipo = $_FILES['logo']['type'];
                        //Verificamos que sea una imagen
                        if (in_array($tipo, ['image/png', 'image/jpeg'])) {
                            if (is_dir($nombreDirectorio)) {
                                //Movemos la imagen a la carpeta de imágenes llamada imgs
                                if (move_uploaded_file($_FILES['logo']['tmp_name'], $nombreCompleto)) {
                                    if (is_uploaded_file($_FILES['conjunto']['tmp_name'])) {
                                        $tipoConjunto = $_FILES['conjunto']['type'];
                                        if (in_array($tipoConjunto, ['image/png', 'image/jpeg'])) {
                                            $conjunto = file_get_contents($_FILES['conjunto']['tmp_name']);
                                            include_once 'Conexion.php';
                                            $BD = new Conectar();
                                            $conn = $BD->getConexion();

                                            $stmt = $conn->prepare('INSERT INTO marcas (id, nombre, añoCreacion, lugarCreacion, logo, prenda)
                                                VALUES (0, :nombre, :anoCreacion, :lugarCreacion, :logo, :prenda)');

                                            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                                            $stmt->bindParam(':anoCreacion', $año, PDO::PARAM_INT);
                                            $stmt->bindParam(':lugarCreacion', $lugar, PDO::PARAM_STR);
                                            $stmt->bindParam(':logo', $nombreCompleto, PDO::PARAM_STR);
                                            $stmt->bindParam(':prenda', $conjunto, PDO::PARAM_LOB);

                                            if ($stmt->execute()) {
                                                echo 'La inserción se realizó con éxito.';
                                                header('Location: verTabla.php');
                                            }
                                        } else {
                                            $errCred = ' el conjunto introducido no es un formato de imagen válido';
                                        }
                                    }
                                }
                            }
                        } else {
                            $errCred = ' el logo introducido no es un formato de imagen válido';
                        }
                    }
                } else {
                    $errCred = ' debe introducir un lugar para la marca';
                }
            } else {
                $errCred = ' debe introducir un año para la marca';
            }
        } else {
            $errCred = ' debe introducir un nombre para la marca';
        }
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Formulario de Inserción</h1>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">

        <label for="año">Año de creación:</label>
        <input type="number" name="año" id="año">

        <label for="lugar">Lugar de creación:</label>
        <input type="text" name="lugar" id="lugar">

        <label for="logo">Logo:</label>
        <input type="file" name="logo" id="logo">

        <label for="conjunto">Conjunto:</label>
        <input type="file" name="conjunto" id="conjunto">

        <input type="submit" value="Añadir marca" name="Enviar">
    </form>
    <span class="error"><?php echo $errCred ?></span>
</body>
</html>

