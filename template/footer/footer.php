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

function add_default_footer($pre_link=""){
    add_footer(["politique de confidentialité", "Contact", "Mes autres projets", "reporter un problème"],["https://www.cyu.fr/mentions-legales","https://cytech.cyu.fr/nous-contacter-1","https://liro-u.github.io/portfolio/",$pre_link."content/report/report.php"],["https://cytech.cyu.fr/images/logo.png", "https://www.cti-commission.fr/wp-content/uploads/2016/01/cti-logo-cmjn.png"],["https://www.cyu.fr/", "https://www.cti-commission.fr/"],"https://upload.wikimedia.org/wikipedia/commons/4/4a/CY_Tech.png","https://cytech.cyu.fr/");
}

//faire en sorte que le footer colle au bas de la page meme quand il n'y a rien dedans
//!!  --FACULTATIF--  !!\\      faire en sorte que les images du footer soit a la bonne taille (responsive)
?>
