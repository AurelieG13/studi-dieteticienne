window.onload = () =>{
    //on va chercher toutes les étoiles
    const stars = document.querySelectorAll(".star-custom");
    //on va chercher l'input
    const note = document.querySelector("#note");
    //on boucle sur les étoiles pour leur ajouter des écouteurs d'évenements
    for (star of stars) {
        //on écoute le survol
        star.addEventListener("mouseover", function(){
            resetStars();
            this.style.color = "#2E8B57";

            // l'élement précédent dans le DOM (de meme niveau = balise soeur)
            let previousStar = this.previousElementSibling;
            while(previousStar){
                //on passe l'étoile qui précède en couleur
                previousStar.style.color = "#2E8B57";
                //on récupère l'étoile qui la précède
                previousStar = previousStar.previousElementSibling;
            }
        });

        //evenement sur le clic
        star.addEventListener("click", function(){
            note.value = this.dataset.value;
        });

        star.addEventListener("mouseout", function(){
            resetStars(note.value);
        });
    }

    function resetStars(note = 0){
        for (star of stars) {
                if(star.dataset.value > note){
                    star.style.color = "#605a7e";
                }else{
                    star.style.color = "#2E8B57";
                }
            }
    }
}


