<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nesti</title>

  
    <link rel="stylesheet" href="<?=$vars['baseUrl'] ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$vars['baseUrl'] ?>public/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?=$vars['baseUrl'] ?>public/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?=$vars['baseUrl'] ?>public/css/style.css">
    <link rel="stylesheet" href="<?=$vars['baseUrl'] ?>public/css/<?=$vars['stylesheet'] ?>.css">
   

<?php 
//permettrait de mettre un stylesheet unique par controller en mettant un nom de stylesheet dans les actions => redefinit le template vars pour l'ajouter

if(isset($vars['stylesheet'])){
echo ' <link rel="stylesheet" href='.$vars['baseUrl'].'public/css/'.$vars['stylesheet'].'.css">';
} ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
   
</head>
