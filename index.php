<?php

require_once 'inc/header.php';

$resultat = executeRequete("SELECT * FROM product");

$products = $resultat -> fetchAll(PDO::FETCH_ASSOC);
// fetchAll() à utiliser systematiquement lorsque l'on a un jeu de résultat > 1 | renvoie un tableau

// debug($products);
// die;


?>

<div class="row justify-content-between">
    <?php foreach($products as $product): ?>
    <div class="card border-primary mb-3" style="max-width: 20rem;">
        <div class="card-header text-center">
            <img width="200" src="<?= $product['picture']; ?>" alt="">
        </div>
        <div class="card-body text-center">
            <h4 class="card-title"><?= $product['name']; ?></h4>
            <h4 class="card-title"><?= $product['price']; ?> €</h4>
            <p class="card-text"><?= $product['description']; ?></p>
        </div>
        <a href="<?= SITE . 'admin/ajoutProduit.php?id=' . $product['id'] ; ?>" class="btn btn-secondary">Modifier</a>
        <a href="" class="btn btn-danger">Supprimer</a>
    </div>

    <?php endforeach;?>
</div>


<?php require_once 'inc/footer.php';?>

