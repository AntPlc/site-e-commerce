<?php

require_once 'inc/header.php';

if(isset($_GET['unset'])):
    unset($_SESSION['user']);

    header('location:./');
    exit();
endif;

if(isset($_GET['add'])):
    add($_GET['add']);

    header('location:./');
    exit();
endif;

if(isset($_GET['remove'])):
    remove($_GET['remove']);

    header('location:./');
    exit();
endif;


$resultat = executeRequete("SELECT * FROM product");

$products = $resultat -> fetchAll(PDO::FETCH_ASSOC);
// fetchAll() à utiliser systematiquement lorsque l'on a un jeu de résultat > 1 | renvoie un tableau

// debug($products);
// die;
if(isset($_GET['id'])):
    executeRequete("DELETE FROM product WHERE id=:id", array(
        ':id' => $_GET['id']
    ));

    $_SESSION['messages']['danger'][]='Votre produit a bien été supprimé !';
    // besoin d'une entrée vide à la fin pour ne pas écraser l'entrée success et permettre de créer autant d'entrée vide que de message
    // success change la couleur du message qui apparait


    header('location: ./');
    exit();
endif;

// $_SESSION['messages']['success'][]='Votre produit a bien été supprimé';
// debug($_SESSION);
// die();
?>

<div class="font-italic">
    <h1 class="">Nouveaux articles :</h1>
</div>
<hr>
<div class="row justify-content-between">
    <?php foreach($products as $product): 
    $quant = 0;
        foreach($_SESSION['cart'] as $id => $quantity):
            if($product['id'] == $id):
                $quant = $quantity;
            endif;
        endforeach;
    ?>

    <div class="card border-primary mb-3 shadow p-3 mb-5 bg-white rounded" style="max-width: 20rem;">
        <div class="card-header text-center">
            <img width="200" src="<?= $product['picture']; ?>" alt="">
        </div>
        <div class="card-body text-center">
            <h4 class="card-title"><?= $product['name']; ?></h4>
            <h4 class="card-title"><?= $product['price']; ?> €</h4>
            <p class="card-text"><?= $product['description']; ?></p>
        </div>
        <?php  if (admin()): ?> 
            <a href="<?=  SITE.'admin/ajoutProduit.php?id='.$product['id']; ?>" class="btn btn-secondary">Modifier</a>
            <a href="?id=<?=  $product['id']; ?>" onclick="return confirm('Etes  vous sûr?')" class="btn btn-danger">Supprimer</a>
        <?php  else: ?>
        <div>
            <div class="text-center mb-3">
                <a href="?remove= <?= $product['id']; ?>" class="btn btn-primary">-</a>
                <input class="text-center ps-3 pe-0" disabled style="width: 15%" type="number" value="<?= $quant; ?>">
                <a href="?add= <?= $product['id']; ?>" class="btn btn-primary">+</a>
            </div>
        </div>
        <?php  endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<hr>

<!-- pour charger des infos en GET on déclare avec ? le chargement de $_GET suivie de l'indice (le name a appeler en $_GET et on lui affecte sa valeur avec =saValeur. ex: ?prenom='Antoine'&nom='Plantec'; le debug de $_GET nous renvoie 'nom'=>'Plantec',-->
<!-- 'prenom'=>'Antoine'. Pour y accéder on appelle $_GET['nom'] qui nous retourne 'Plantec' -->

<?php require_once 'inc/footer.php';?>