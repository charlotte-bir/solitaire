//tableau d'indice
let numbers=[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51]

//fonction de génération d'indice unique dans le tableau de valeur
//servant dans le tableau de correspondance des cartes
function cardGeneration(){
    let index=Math.floor(Math.random() * (numbers.length) ); 
    let number=numbers[index];
    numbers.splice(index,1);
    return number;
}

//fonction de récupération des cartes empilées à déplacer
function getNextSiblings(element){
    var arraySib = [];
    while ( element = element.nextElementSibling ){
        arraySib.push(element);
    }
    return arraySib;
}

//tableau servant à appliquer les classes et les attributs à chaque carte
const cardCorrespondance=[
    ["ace_clubs",1,"black"],
    ["two_clubs",2,"black"],
    ["three_clubs",3,"black"],
    ["four_clubs",4,"black"],
    ["five_clubs",5,"black"],
    ["six_clubs",6,"black"],
    ["seven_clubs",7,"black"],
    ["eight_clubs",8,"black"],
    ["nine_clubs",9,"black"],
    ["ten_clubs",10,"black"],
    ["jack_clubs",11,"black"],
    ["queen_clubs",12,"black"],
    ["king_clubs",13,"black"],
    ["ace_hearts",1,"red"],
    ["two_hearts",2,"red"],
    ["three_hearts",3,"red"],
    ["four_hearts",4,"red"],
    ["five_hearts",5,"red"],
    ["six_hearts",6,"red"],
    ["seven_hearts",7,"red"],
    ["eight_hearts",8,"red"],
    ["nine_hearts",9,"red"],
    ["ten_hearts",10,"red"],
    ["jack_hearts",11,"red"],
    ["queen_hearts",12,"red"],
    ["king_hearts",13,"red"],
    ["ace_spades",1,"black"],
    ["two_spades",2,"black"],
    ["three_spades",3,"black"],
    ["four_spades",4,"black"],
    ["five_spades",5,"black"],
    ["six_spades",6,"black"],
    ["seven_spades",7,"black"],
    ["eight_spades",8,"black"],
    ["nine_spades",9,"black"],
    ["ten_spades",10,"black"],
    ["jack_spades",11,"black"],
    ["queen_spades",12,"black"],
    ["king_spades",13,"black"],
    ["ace_diamonds",1,"red"],
    ["two_diamonds",2,"red"],
    ["three_diamonds",3,"red"],
    ["four_diamonds",4,"red"],
    ["five_diamonds",5,"red"],
    ["six_diamonds",6,"red"],
    ["seven_diamonds",7,"red"],
    ["eight_diamonds",8,"red"],
    ["nine_diamonds",9,"red"],
    ["ten_diamonds",10,"red"],
    ["jack_diamonds",11,"red"],
    ["queen_diamonds",12,"red"],
    ["king_diamonds",13,"red"]
]

let firework=document.querySelector(".pyro");

//nombre de cartes retournées en début de partie (24 dans la pioches + 7 dans les colonnes = 31)
let frontSideCardsCount=31;

//récupération du message de fin de jeu
let winMessage=document.querySelector("#winMessage");

//récupération des 7 emplacements sur le tapis de jeu
let colomns=document.querySelectorAll("#bottom>div");

//retournement de la carte qui était sous la movingCard si elle était face cachée et incrémentation du nombre de cartes retournées
function flipAndCount(parent){
    if(parent.lastElementChild && parent.lastElementChild.lastElementChild.style.display!="none" && parent!=fausse){           
        makeDraggable(parent.lastElementChild);
        parent.lastElementChild.lastElementChild.style.display="none";
        frontSideCardsCount++;
        if(frontSideCardsCount==52){
            winMessage.style.display="block";
            firework.style.display="block";
            clearInterval(interval);
            // c'est la que ca se passe
            const xhr = new XMLHttpRequest();
            const uri = 'http://solitaire.local/players';
            const datas = {
                name: 'Le jooueur',
                time: '00.13.20'
            }
            // Definir les en-tetes de la requete
            xhr.open('post', uri);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=utf-8');
            xhr.onload = () => {
                // your logic hereafter request was completed
            }
            // Envoyer la requete elle meme
            xhr.send(JSON.stringify(datas))
        }

        const trigger = document.getElementById('fakeBackend')
        trigger.addEventListener(
            'click',
            send
        )
    }  
}

//déplacement et positionnement en cascade de la ou des carte(s) déplacée(s) 
function placeMovingCard(origin,margin,element){
    let appendDestination;
    if(origin=="cards"){
        appendDestination=element.parentElement;
    }else if(origin=="colomns"){
        appendDestination=element;
    }
    if(movingCard==movingCard.parentElement.lastElementChild){
        movingCard.style.marginTop=margin+"px";
        appendDestination.appendChild(movingCard);
    }else{
        let nextSiblings=getNextSiblings(movingCard);
        movingCard.style.marginTop=margin+"px";
        appendDestination.appendChild(movingCard);
        nextSiblings.forEach(sibling => {
            margin+=20;
            sibling.style.marginTop=margin+"px";
            appendDestination.appendChild(sibling);
        });
    }
}

//poser un roi dans une case vide
colomns.forEach(element => {
    element.addEventListener('dragover', function(e) {
        e.preventDefault(); // Annule l'interdiction de drop
    });
    element.addEventListener('drop', function(e) {
        e.preventDefault(); // Cette méthode est toujours nécessaire pour éviter une éventuelle redirection inattendue
        if(movingCard.className.includes("king") && !element.lastElementChild){
            startChrono();
            let margin=0;
            let parent=movingCard.parentNode;
            placeMovingCard("colomns",margin,element);
            flipAndCount(parent);
        }  
    });
});
        
//variable pour stocker la carte en mouvement
let movingCard;

//fonction pour rendre une carte déplaçable
function makeDraggable(element){
    element.setAttribute("draggable","true");
    element.addEventListener('dragstart', function(e) {
        movingCard=element;
        setTimeout(function(){
            movingCard.style.display="none";
            let nextSiblings=getNextSiblings(movingCard);
            nextSiblings.forEach(sibling => {
                sibling.style.display="none";
            });
        })
    });
    element.addEventListener('dragend', function(e) {
        movingCard=element;
        setTimeout(function(){
            movingCard.style.display="block";
            let nextSiblings=getNextSiblings(movingCard);
            nextSiblings.forEach(sibling => {
                sibling.style.display="block";
            });
        })
    });
}

//décalage des cartes dans les colonnes au début de la partie
colomns.forEach(element => {
    let margin=0;
    element.querySelectorAll(".card").forEach(element => {
        element.style.marginTop=margin+"px";
        margin+=20;
        if(element!=element.parentNode.lastElementChild){
            element.lastElementChild.style.display="block";
        }else{
            element.lastElementChild.style.display="none";
            makeDraggable(element);
        }
    });
});

//récupération de toutes les cartes du jeu
let cards=document.querySelectorAll(".card");

//asignation des classes et des attributs à chaque carte
//gestion de la superposition des cartes
cards.forEach(element => {
    let i=cardGeneration();
    element.className+=" "+cardCorrespondance[i][0];
    element.setAttribute("cardValue",cardCorrespondance[i][1]);
    element.setAttribute("cardColor",cardCorrespondance[i][2]);
    let cardClass="";
    if(cardCorrespondance[i][0].includes("clubs")){
        cardClass="clubs";
    }else if(cardCorrespondance[i][0].includes("hearts")){
        cardClass="hearts";
    }else if(cardCorrespondance[i][0].includes("spades")){
        cardClass="spades";
    }else{
        cardClass="diamonds";
    }
    element.setAttribute("cardClass",cardClass);
    element.addEventListener('dragover', function(e) {
        e.preventDefault(); // Annule l'interdiction de drop
    });
    // Gestion des conditions de superposition des cartes
    element.addEventListener('drop',function dropOnCard(e){
        e.preventDefault(); // Cette méthode est toujours nécessaire pour éviter une éventuelle redirection inattendue
        startChrono();
        if(element.lastElementChild.style.display!="block" 
        && element.parentElement.parentElement.id=="bottom" 
        && movingCard.attributes.cardColor.value!=element.attributes.cardColor.value 
        && movingCard.attributes.cardValue.value==element.attributes.cardValue.value-1
        && movingCard.parentElement!=element.parentElement){
            let margin=parseInt(element.parentElement.lastElementChild.style.marginTop.slice(0,-2))+20;
            let parent=movingCard.parentNode;
            placeMovingCard("cards",margin,element);
            flipAndCount(parent);
        }
    });
    //placement au double clic de la carte dans le slot correspondant
    element.addEventListener('dblclick',function(){
        if(element.lastElementChild.style.display!="block" && element==element.parentElement.lastElementChild){
            startChrono();
            let cardClass=element.attributes.cardClass.value;
            let slot=document.querySelector("#"+cardClass);
            if((!slot.lastElementChild && element.attributes.cardValue.value==1) 
            || (slot.lastElementChild && slot.lastElementChild.attributes.cardValue.value==element.attributes.cardValue.value-1)){
                element.style.marginTop="0px";
                let parent=element.parentNode;
                slot.appendChild(element);
                flipAndCount(parent);
            }
            else if(element.className.includes("king")){
                for (let i = 0; i < colomns.length; i++) {
                    if(!colomns[i].lastElementChild){
                        element.style.marginTop="0px";
                        let parent=element.parentNode;
                        colomns[i].appendChild(element);
                        flipAndCount(parent);
                        break;
                    }
                    
                };
            }
        }
        
    });
});

//récupération des cartes dans la donne
let donneCards=document.querySelectorAll("#donne>div");

//afficher le dos de toutes les cartes dans la donne
donneCards.forEach(element => {
    element.lastElementChild.style.display="block";
});

//récupération de la donne et de la fausse
let donne=document.querySelector("#donne");
let fausse=document.querySelector("#fausse");

//gestion du passages des cartes entre la donne et la fausse et retournage des cartes
donne.addEventListener('click',function(){
    startChrono();
    if(donne.lastElementChild){
        let card=donne.lastElementChild;
        card.firstElementChild.style.display="none";
        makeDraggable(card);
        fausse.appendChild(card);
    }else{
        let fausseCards=document.querySelectorAll("#fausse>div");
        for (let index = fausseCards.length-1; index >=0; index--) {
            fausseCards[index].firstElementChild.style.display="block";
            fausseCards[index].setAttribute("draggable","false");
            donne.appendChild(fausseCards[index]);
        }
    }
});

//récupération des slots
let slots=document.querySelectorAll("#slots>div");

//gestion du placement des cartes dans les slots en ordre croissant et par trèfle/coeur/carreau/pique
slots.forEach(element => {
    element.addEventListener('dragover', function(e) {
        e.preventDefault(); // Annule l'interdiction de drop
    });
    element.addEventListener('drop', function(e) {
        e.preventDefault(); // Cette méthode est toujours nécessaire pour éviter une éventuelle redirection inattendue
        startChrono();
        if(element.id==movingCard.attributes.cardClass.value ){
            if((!element.lastElementChild &&  movingCard.attributes.cardValue.value==1) || (element.lastElementChild && movingCard.attributes.cardValue.value==parseInt(element.lastElementChild.attributes.cardValue.value)+1)){
                movingCard.style.marginTop="0px";
                let parent=movingCard.parentNode;
                element.appendChild(movingCard);
                flipAndCount(parent);
            }
        }
    });
});

let chrono=document.querySelector("#chrono");

let time=0;

let interval;

function startChrono(){
    if(time==0){
        interval=setInterval(function(){
            time++;
            let sec;
            let min;
            let hours;
            hours=Math.floor(time/3600);
            if(hours<10){
            hours="0"+hours;
            }
            min=Math.floor(time%3600/60);
            if(min<10){
            min="0"+min;
            }
            sec=Math.floor(time%3600%60);
            if(sec<10){
            sec="0"+sec;
            }
            chrono.innerText="temps écoulé : "+hours +" : "+min+" : "+sec;
        }, 1000);  
    }
}