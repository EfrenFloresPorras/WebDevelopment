<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
</head>

<body>
  <div class="d-flex full-window">
    <form class="m-auto card p-3" action="./components/registrarProducto.php" method="post">
      <h3 class="mb-3">Nuevo Producto</h3>
      <div class="input-group mb-3">
        <span class="input-group-text">Nombre</span>
        <input type="text" class="form-control" name="nombre" id="nombre" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text">Precio</span>
        <input type="text" class="form-control" name="precio" id="precio" required>
        <span class="input-group-text">$</span>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text">Stock</span>
        <input type="text" class="form-control" name="stock" id="stock" required>
      </div>
      <div class="row m-0 py-3">
        <button type="submit" class="m-auto w-fit btn btn-primary">Añadir</button>
        <a href="misProductos.php" class="m-auto w-fit btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>