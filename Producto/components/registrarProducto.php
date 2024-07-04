<?php 

    // var_dump($_POST);

    $newProduct = array(
        "nombre" => $_POST["nombre"],
        "precio" => $_POST["precio"],
        "stock" => $_POST["stock"]
    );
    
    $filePath = "../db/productos.json";

    // Check if the file exists
    if (file_exists($filePath)) {
        // Read the existing content of the JSON file
        $jsonData = file_get_contents($filePath);
        
        // Decode the JSON content into a PHP array
        $products = json_decode($jsonData, true);
        
        // Check if the decoded data is an array
        if (!is_array($products)) {
            $products = [];
        }
    } else {
        // If the file does not exist, initialize an empty array
        $products = [];
    }

    // Append the new data to the PHP array
    $products[] = $newProduct;

    // Encode the updated array back into JSON
    $jsonData = json_encode($products, JSON_PRETTY_PRINT);

    // Write the new JSON content back to the file
    file_put_contents($filePath, $jsonData);

    echo "Product added successfully.";

?>


<script>
    location.href = '../misProductos.php';
</script>