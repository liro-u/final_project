<?php
echo "<style>";
include 'footer.css';
echo "</style>";

function add_footer($list = [], $link = [], $logo = [], $logo_link = [], $main_logo = "", $main_link = "", $copyright = "Copyright © CY-Tech. All Rights Reserved."){
    echo "<div class='--footer-wrap'>";

    echo "<a class='--footer-link' href='$main_link'><img class='--footer-main-logo' src='$main_logo'></img></a>";

    echo "<ul class='--footer-link-box'>";
    foreach ($list as $key => $value) {
        echo "<li class='--footer-li'><a class='--footer-link' href='$link[$key]'>$value</a></li>";
    }
    echo "</ul>";

    echo "<ul class='--footer-logo-box'>";
    foreach ($logo as $key => $value) {
        echo "<li class='--footer-li'><a class='--footer-link' href='$logo_link[$key]'><img class='--footer-logo' src='$value'></img></a></li>";
    }
    echo "</ul>";

    echo "<p class='--footer-cp'>$copyright</p>";
    echo "</div>";
}

function add_default_footer(){
    add_footer(["politique de confidentialité", "Accord utilisateur", "Qui sommes-nous ?", "Contact", "Mes autres projets"],["","","","","https://liro-u.github.io/portfolio/"],["https://cytech.cyu.fr/images/logo.png", "https://www.cti-commission.fr/wp-content/uploads/2016/01/cti-logo-cmjn.png"],["", ""],"https://upload.wikimedia.org/wikipedia/commons/4/4a/CY_Tech.png","");
}

//faire en sorte que le footer colle au bas de la page meme quand il n'y a rien dedans
//!!  --FACULTATIF--  !!\\      faire en sorte que les images du footer soit a la bonne taille (responsive)
?>
