<h1 class="h1">Mes recettes</h1>

<?php

foreach ($vars['entities'] as $recipe) {
    echo "<p>" .$recipe->getName() . "</p>";
}

?>