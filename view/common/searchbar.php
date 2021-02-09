<form method="post" action="<?= $vars['baseUrl']?>/<?= $vars['controllerSlug']?>/list" >

<div class="input-group mb-3 border rounded w-25  mt-2 searchBarContainer">
    <img src="<?= $vars['baseUrl'] ?>/public/images/search-svg.png" alt="search icon" id="searchbar" class="wen">
    <input type="text" class="form-control search-bar" aria-label="searchbar" aria-describedby="searchbar" name="search[<?= $vars['searchField']?>]" value="<?= @$_POST["search"][$vars['searchField']]?>">
</div>
</form>