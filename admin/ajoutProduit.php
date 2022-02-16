<?php 
require_once '../inc/header.php';

if(!empty($_POST)): // si le formulaire a été soumis

    if(!empty($_FILES['picture']['name'])): // vérification avec 'name' pour être sûr qu'un fichier a bien été déposé

        // debug($_FILES);
        //     die; // permet d'arreter la lecture du code

        $picture_name = date_format(new DateTime(), 'dmYHis') . uniqid() . $_FILES['picture']['name'];
        // dmY = date month Year | His = Hour minute seconde | uniqid() permet de donner un nom unique à la photo

        $picture_bdd = 'upload/' . $picture_name;
        // permet de mettre les photos uploadées dans un dossier 'upload'

        if (!file_exists('../upload/')):
            mkdir('../upload', 0777, true);
        endif;
        copy($_FILES['picture']['tmp_name'], '../' . $picture_bdd);
        // permet de créer le dossier 'upload' à l'endroit indiqué
    endif;

    // insert en BDD :

    $requete = executeRequete("REPLACE INTO product VALUES (:id, :name, :price, :picture, :description)", array(
        ':id' => $_POST['id'],
        ':name' => $_POST['name'],
        ':price' => $_POST['price'],
        ':picture' => $picture_bdd,
        ':description' => $_POST['description']
    ));

endif; // endif !empty($_POST)

if(isset($_GET['id'])): // si l'id est dans l'url = nous sommes en train de modifier | $_GET lit ce qui est derriere le '?' dans l'url
    $resultat = executeRequete('SELECT * FROM product WHERE id= :id', array(
        ':id' => $_GET['id']
    ));

    // --- autre méthode en passant par une variable ---
    // $requete="SELECT * FROM $product WHERE id= ':id';
    // $param=array(':id'=>$_GET['id']);
    // $resultat=executeRequete($requete, $param);

    $product = $resultat -> fetch(PDO::FETCH_ASSOC);

    // debug($product);
    // die();
endif;

?>

<form action="" method="post" enctype="multipart/form-data"> <!-- 'multipart/form-data' permet de lui donner du type FILES et du type POST -->
    <fieldset>

       <input type="hidden" name="id" value="<?= $product['id'] ?? 0; ?>">
       <!-- ici c'est '?? 0' car l'id attend un integer | pour le reste des attributs ca sera '?? "" ' car ils attendent des string -->
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label mt-4">Nom</label>
            <input type="text" name="name" value="<?= $product['name'] ?? ""; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Entrez le nom du produit">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4">Prix</label>
            <input type="number" name="price" value="<?= $product['price'] ?? 0; ?>" class="form-control" id="exampleInputPassword1" placeholder="Entrez le prix du produit">
        </div>
<!--        <div class="form-group">-->
<!--            <label for="exampleSelect1" class="form-label mt-4">Example select</label>-->
<!--            <select class="form-select" id="exampleSelect1">-->
<!--                <option>1</option>-->
<!--                <option>2</option>-->
<!--                <option>3</option>-->
<!--                <option>4</option>-->
<!--                <option>5</option>-->
<!--            </select>-->
<!--        </div>-->
  
        <div class="form-group">
            <label for="exampleTextarea" class="form-label mt-4">Description</label>
            <textarea name="description" class="form-control" id="exampleTextarea" rows="3"><?= $product['description'] ?? ""; ?></textarea>
        </div>

        <?php if(isset($product)): ?> 
            <div class="form-group">
            <label for="formFile" class="form-label mt-4">Photo</label>
            <input name="pictureEdit" class="form-control" type="file" id="formFile">
        </div>
        <input type="hidden" value="<?= $product['picture'] ;?>">
        <div>
            <img width="200" src="<?= '../' . $product['picture'] ;?>" alt="">
        </div>
        
        <?php else: ?>
        <div class="form-group">
            <label for="formFile" class="form-label mt-4">Photo</label>
            <input name="picture" class="form-control" type="file" id="formFile">
        </div>
        <?php endif; ?>

           
        <br>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </fieldset>
</form>

<?php require_once '../inc/footer.php';?>
