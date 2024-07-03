<!doctype html>
<html lang="en">
  <head>
    <?php include 'imports.php'; ?>
    <title>Login Page</title>
  </head>
  <body>

    <?php include 'navbar.php'; ?>

    <div class="d-flex full-window">
        <div class="card m-auto" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Login</h5>
                <form action="login.php" method="post">
                    <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
          </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>