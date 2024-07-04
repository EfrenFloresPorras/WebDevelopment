<?php

$content = file_get_contents('db/productos.json');
$products = json_decode($content, true);



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'>
</head>

<body>

    <?php include './components/navbar.php'; ?>
    <div class="d-flex full-window">
        <div class="m-auto card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($products); $i++) {
                        echo "<tr>";
                        echo "<td>" . $products[$i]["nombre"] . "</td>";
                        echo "<td>" . $products[$i]["precio"] . "</td>";
                        echo "<td>" . $products[$i]["stock"] . "</td>";
                        echo "<td class='d-flex'><button class='m-auto btn btn-sm btn-secondary' type='button' onclick='addProduct(".$i.")'><i class='fas fa-cart-plus'></i></button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="row m-0 py-3">
                <a href="producto.php" class="m-auto btn btn-primary w-fit">Añadir</a>
            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/shoppingCart.js"></script>
</body>

</html>