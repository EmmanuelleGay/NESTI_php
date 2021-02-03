<?php
define('PATH_CTRL','src/controller/');
define('PATH_MODEL','src/model/');
define('PATH_ENTITY','src/model/entity/');
define('PATH_TOOLS','src/tools/');
define('PATH_TEMPLATE','src/view/template/');
define('PATH_CONFIG','config/');

/*
acces a la bb
peut contenir aussi les chemins a "include" => ex : app/controller/CtrlRecette => la partie appp/controller va être 
répétée plusiuers fois, donc on va le mettre dans 
 une variable globale => et on fera include PATH_CTRL.'CtrlRecette.php'
 => la constante globale doit être écris en MAJ
 pour définir une variable globale : define('PATH_CTRL', 'app/controller/');
 Il faudra évidemment du coup inclure le confoig.php en haut de fichier

on peut aussi le faire pour la base URL : define('BASE_URL','127.0.0.1/www/nesti');
autre variable a utiliser pour debug : define('DEBUG',true) => on ferait 
if(DEBUG){
var_dump($variable) => elle ne sera affichée que si on est en mode débug.
En prod, on passerait le DEBUG à false 
}

dans notre dossier app on ajoute un index.php
=> on fera une redirection vers une page error 403
=> pour faire la redirection : header('location:'.BASE_URL.'public/error403.html)

*/

?>

