<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ffb984, #f6edaa);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .panel {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .opciones {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .opciones a {
            background-color: #0074d9;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .opciones a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="panel">
        <h1>Panel de Administrador</h1>
        <div class="opciones">
            <a href="Insertar.php">Insertar Nueva Marca</a>
            <a href="verTabla.php">Consultar Tabla de Marcas</a>
        </div>
    </div>
</body>
</html>
