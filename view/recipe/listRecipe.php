<h1>titre</h1>

<?php



foreach ($vars['recipes'] as $recipe) {
    echo "<p>" .$recipe->getName() . "</p>";
}


?>