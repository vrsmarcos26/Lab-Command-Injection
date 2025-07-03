<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TESTE DE IP</title>
        <style>
            body {
                background-color: #f5f5f5;
                font-family: Arial, sans-serif;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 40px;
            }

            h2 {
                color: #333;
            }

            form {
                background: #fff;
                padding: 20px 30px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin-bottom: 20px;
                text-align: center;
            }

            input[type="text"] {
                padding: 10px;
                width: 300px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-bottom: 10px;
            }

            button {
                padding: 10px 20px;
                background-color: #3498db;
                border: none;
                color: white;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                background-color: #2980b9;
            }

            pre {
                background-color: #eee;
                padding: 15px;
                border-radius: 5px;
                width: 90%;
                max-width: 800px;
                overflow-x: auto;
                white-space: pre-wrap;
            }
        </style>
    </head>
    <body>
        <h2>Digite um IP para executar ping</h2>
        <form method="GET">
            <input type="text" name="ip" placeholder="Digite o IP ou hostname">
            <button type="submit">Executar Ping</button>
        </form>

        <pre>
            <?php
            if(isset($_GET['ip'])){
                $ip = $_GET['ip'];
                echo "Executando comando: ping ". htmlspecialchars($ip) . "\n\n";
                system("powershell -Command \"ping -n 4 $ip\"");
            }
            ?>
        </pre>
    </body>

</html>
