<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Personal Portfolio Web</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link rel='stylesheet' type='text/css' media='screen' href='assets/css/main.css'>
</head>

<body>
    <!-- Home Section Begins-->
    <section id="home" class="content-section">
        <!-- Header section -->
        <header class="home">
            <div class="container">
                <div class="header-content">
                    <h1>I'm <span class="typed"></span></h1>
                    <p>Entrepreneur, Cybersecurity, Analyst</p>

                    <ul class="list-unstyled list-social">
                        <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                        <li><a href="https://www.instagram.com/fp.porras/?hl=en"><i class="ion-social-instagram"></i></a>
                        </li>
                        <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                        <li><a href="https://github.com/EfrenFloresPorras"><i class="ion-social-github"></i></a>
                        </li>
                        <li><a href="https://www.linkedin.com/in/efren-flores-p" class="ion-social-linkedin" ></a>
                        </li>
                    </ul>

                    <div class="row mt-4">
                        <div class="col-md-2 col-sm-4 mb-2">
                            <button type="button" class="btn btn-outline-light btn-sm w-100" data-section="about">About
                                Me</button>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <button type="button" class="btn btn-outline-light btn-sm w-100" data-section="education">Education</button>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <button type="button" class="btn btn-outline-light btn-sm w-100" data-section="experience">Experience</button>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <button type="button" class="btn btn-outline-light btn-sm w-100" data-section="projects">Projects</button>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <button type="button" class="btn btn-outline-light btn-sm w-100" onclick="DownloadCV()">Curriculum</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </section>
    <!-- Home Section Ends-->

    <!-- About Section Begins-->
    <section id="about" class="content-section d-none">
        <?php include './components/common/navbar.php'; ?>
        <?php include './components/about.php'; ?>
        <?php include './components/common/footer.php'; ?>
    </section>

    <section id="education" class="content-section d-none">
        <?php include './components/common/navbar.php'; ?>
        <?php include './components/education.php'; ?>
        <?php include './components/common/footer.php'; ?>

    </section><!-- /Resume Section -->

    <section id="experience" class="content-section d-none">
        <?php include './components/common/navbar.php'; ?>
        <?php include './components/experience.php'; ?>
        <?php include './components/common/footer.php'; ?>
    </section>

    <section id="projects" class="content-section d-none">
        <?php include './components/common/navbar.php'; ?>
        <?php include './components/projects.php'; ?>
        <?php include './components/common/footer.php'; ?>
    </section>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="assets/lib/typed/typed.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>