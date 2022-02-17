<?php 

$pdo = new PDO('mysql:host=localhost;dbname=site_ecommerce', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
// (dsn, username, password, )

// initiation de la session
session_start();

$_SESSION['message'] = [];

// chemin du site
define('SITE', '/projet/');

// variable d'affichage
$contenu = '';

// Note: 
// => : pour les tableau, = associée à cette valeure du tableau /// -> : pour les objets, = accède à la propriété (directement nommée) ou à la méthode (entre parenthèse)


function executeRequete($requete, $param = array()){
// le parametre $requete reçois une requete SQL | le parametre $param reçoit un tableau array avec les marqueurs associés a leur valeur
    // Echappement des données avec htmlspecialchars()
    foreach($param as $marqueur => $valeur){
        $param[$marqueur] = htmlspecialchars($valeur);
        // on transforme les cheuvrons en entité html qui neutralise les balises <style> et <script> eventuellement injectés en formulaire. Evite les failles XSS et CSS
    }

    global $pdo; // permet d'acceder à la variable $pdo de manière globale

    $resultat = $pdo -> prepare($requete); // on prepare la requete reçue
    $succes = $resultat -> execute($param); // on execute en lui passant un tableau des marqueurs associés à la valeur

    // execute() renvoie toujours un booleen: true en cas de succes et false en cas d'echec

    if($succes){ // si succes == true donc la requete a fonctionné
        return $resultat;
    } else {
        return false;
    }
}

function debug($var) {
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

function connect(){
    if(isset($_SESSION['user'])):
        return true;
    else:
        return false;
    endif;
}

function admin(){
    if(connect() && $_SESSION['user']['roles'] == 'ROLE_ADMIN'):
        return true;
    else:
        return false;
    endif;
}

if(!isset($_SESSION['cart'])):
    $_SESSION['cart']=[];
endif;

require_once 'cart.php';


?>