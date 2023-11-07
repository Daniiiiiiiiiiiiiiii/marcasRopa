<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro DR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #3498db, #e74c3c);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: #fff;
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        label {
            font-size: 18px;
            color: #333;
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 12px;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error{ color: black; font-weight: bold;}
    </style>
</head>
<body>
    <?php
        include_once 'Conexion.php';

        session_start();
        $errUsu = $errClave = $errCred = '';
        //verificamos que se de al botón de enviar
        if (isset($_POST['Enviar'])) {
            //verificamos que todos los campos no estén vacios
            if (empty($_POST['usr']))
                $errUsu = "Debe introducir usuario";
            if (empty($_POST['contra']))
                $errClave = "Debe introducir contraseña";

            if (!empty($_POST['usr']) && !empty($_POST['contra'])) { 
                //verificamos que los campos sean del tipo que queremos (en este caso String)
                if(!is_string($_POST['usr']) && !is_string($_POST['contra'])){
                    $errCred = "Usuario y contraseña no válidos";
                } else if (!is_string($_POST['usr'])){
                    $errCred = "Usuario no válido";
                } else if(!is_string($_POST['contra'])){
                    $errCred = "Contraseña no válida";
                } else{
                    $_SESSION['usr'] = $_POST['usr'];
                    $_SESSION['contra'] = sha1($_POST['contra']);

                    $BD = new Conectar();
                    $conn = $BD->getConexion();
                    $stmt = $conn->prepare('SELECT * FROM users WHERE nombre = :usr AND contraseña = :pwd');
                    $stmt->execute(array(':usr' => $_SESSION['usr'], ':pwd' => $_SESSION['contra']));

                    $result = $stmt->fetch();

                    if ($result) {
                        $_SESSION['rol'] = $result['rol'];
                        if ($_SESSION['rol'] == 'Administrador') {
                            header('Location: MenuAdmin.php');
                        } else {
                            header('Location: verTabla.php');
                        }
                    } else {
                        $errCred = "Usuario o contraseña incorrectos";
                    }
                }
            }
        }

    ?>
    <h1>Inicio de sesión</h1>
    <form action="" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usr" id="usr"value='<?php if (isset($_POST['usr'])) echo $_POST['usr']; ?>' />
            <span class="error"><?php echo $errUsu; ?></span>
        <label for="contra">Contraseña:</label>
        <input type="password" name="contra" id="contra" value='' />
        <span class="error"><?php echo $errClave; ?></span>
        
        <input type="submit" value="Acceder" name="Enviar">
    </form>    
    <span class="error"><?php echo $errCred ?></span>
</body>
</html>