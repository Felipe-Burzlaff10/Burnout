<?php
session_start();

if (isset($_SESSION['id_usuario']))
{
    if ($_SESSION['root'])
            echo "<a href='listar_users.php'>
                      <button>listar</button>
                  </a>";
}
else
    echo "<script>window.location.href='login.php';</script>";
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


     <style>
        /* Estilo para o menu de navegação */
        .nav {
            background-color: #39bf00;
            padding: 10px 0;
        }

        .nav-link {
            color: black;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
            margin: 0 15px;
        }

        .nav-link:hover {
            color: #ffffff;
        }

        .nav-link.active {
            border-bottom: 2px solid black;
        }
        </style>
<body>

        <a href="logout.php">
            <button>logout</button>
        </a>

    <!-- Bootstrap js -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    
     <header style="background-color: #39bf00; padding: 10px 20px 0;">

    <!-- Parte superior -->
    <div class="container-fluid">
        <div class="row align-items-center">

            <!-- Logo -->
            <div class="col-3">
                <img src="img/logo.png" alt="Logo Burnout" style="width: 170px;">
            </div>

            <!-- Título -->
            <div class="col-6 text-center">
                <h1 style="
                    font-family: Georgia, 'Times New Roman', serif;
                    font-size: 70px;
                    font-weight: bold;
                    margin: 0;
                    color: black;">
                    BURNOUT
                </h1>
            </div>

            <!-- Ícones e login -->
            <div class="col-3 d-flex justify-content-end align-items-center gap-3">

                <!-- Pesquisa -->
                <a href="pesquisa.php" style="color: black; font-size: 32px;">
                    <i class="bi bi-search"></i>
                </a>

                <!-- Carrinho -->
                <a href="carrinho.php" style="color: black; font-size: 32px;">
                    <i class="bi bi-cart3"></i>
                </a>

                <!-- User -->
                <span style="font-weight: bold; font-size: 18px; line-height: 1.1; color: black;">
                    <a href="perfil.php"><?php echo $_SESSION['nome']; ?></a>
                </span>

            </div>

        </div>
    </div>


    <!-- Menu de navegação -->
    <ul class="nav justify-content-center">
  <li class="nav-item">
    <a class="nav-link" aria-current="page" href="home.php">HOME</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="catalogo.php">CATALOGO</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="lancamentos.php">LANÇAMENTOS</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" aria-disabled="true">PINTO</a>
  </li>
</ul>
</header>


<div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/imagemPromocional.png" class="d-block w-100" alt="..." width="500px" height="750px">
    </div>
    <div class="carousel-item">
      <img src="img/imagemLançamento.png" class="d-block w-100" alt="..." width="500px" height="750px">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</head>
<body>
