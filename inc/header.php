<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projet e-commerce</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.3/cerulean/bootstrap.min.css" integrity="sha512-CVn5BJ6vue0EG9CDO6yfg3hOvzQ43xEXOSUEkUtiV3pDy2S7O0saUZ0vbDkZYVX30NvqLLZo51JBzUyreGyqvg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

  <?php require_once 'init.php'; ?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= SITE; ?>">Mon site E-commerce</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= SITE; ?>">Accueil</a>
          </li>
          <?php if (admin()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= SITE . 'admin/ajoutProduit.php'; ?>">Ajout Produit</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?= SITE . 'front/fullCart.php'; ?>">
              <button type="button" class="rounded btn btn-outline-warning position-relative p-2">
                <i class="fa-solid fa-cart-arrow-down fa-2xl "></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= getQuantity();?>+</span>
              </button>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-sm-2" type="text" placeholder="Search">
          <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
        <?php if (!connect()) : ?>
          <div class="text-center">
            <a href="<?= SITE . 'security/login.php'; ?>" class="btn btn-success">Se connecter</a>
            <a href="<?= SITE . 'security/register.php'; ?>" class="btn btn-primary">S'inscrire</a>
          </div>
        <?php else : ?>
          <div class="text-center">
            <a href="<?= SITE . '?unset=1'; ?>" class="btn btn-primary"><i class="fa-solid fa-power-off"></i></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <div class="container">
    <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) :
      foreach ($_SESSION['messages'] as $type => $mess) :
        foreach ($mess as $key => $message) :
    ?>

          <div class="alert alert-<?= $type; ?> text-center">
            <p><?= $message; ?></p>
          </div>
          <?php unset($_SESSION['messages'][$type][$key]); ?>
    <?php endforeach;
      endforeach;
    endif; ?>