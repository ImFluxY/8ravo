"use strict";
(function () {

    document.addEventListener("DOMContentLoaded", initialiser);
    let lesEtoiles = document.getElementsByClassName("user-star");
    let blocEtoiles = document.querySelector(".note-module-img");
    var nbEnfants, etoilePrecedante, etoileSuivante, premiereEtoile, compteur = 0;

    function initialiser(evt) {
        console.log("script etoile");
        nbEnfants = 5;
        console.log(lesEtoiles[1]);
        for (let uneEtoile of lesEtoiles) {
            console.log("test");
            uneEtoile.src = "./img/star-empty.png";
            //uneEtoile.addEventListener('click', cliquerEtoiles);
            //uneEtoile.addEventListener('mouseover', afficherEtoiles);
        }
    }

    function cliquerEtoiles(evt) {
        for(var i = 0; i < nbEnfants; i++){
            etoilePrecedante = this.previousElementSibing;
            if(etoilePrecedante.classlist.contains("user-star")){
                compteur ++;
            }
        }

        premiereEtoile = blocEtoiles.firstChild;
        premiereEtoile.src = "./img/star.png";
        etoileSuivante = premiereEtoile.nextElementSibing;
        for(var j = 0; j < compteur; j++){
            etoileSuivante.src = "./img/star.png";
            etoileSuivante = etoileSuivante.nextElementSibing;
        }
    }

    function afficherEtoiles(evt) {

        this.src = "./img/star.png";
    }

    function afficherEtoiles(evt) {

        this.src = "./img/star.png";
        for (let uneEtoile of lesEtoiles) {
            uneEtoile.addEventListener('mouseover', afficherEtoiles);
        }
    }

})();
