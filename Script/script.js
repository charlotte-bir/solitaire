let numbers=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]

function cardGeneration(){
    let index=Math.floor(Math.random() * (numbers.length) ); 
    let number=numbers[index];
    numbers.splice(index,1);
    return number;
}

function getNextSiblings(element){
    var arraySib = [];
    while ( element = element.nextElementSibling ){
        arraySib.push(element);
    }
    return arraySib;
}

let cardCorrespondance=[
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

let frontSideCardsCount=31;

let winMessage=document.querySelector("#winMessage");

let colomns=document.querySelectorAll("#bottom>div");

colomns.forEach(element => {
    element.addEventListener('dragover', function(e) {
        e.preventDefault(); // Annule l'interdiction de drop
    });
    element.addEventListener('drop', function(e) {
        e.preventDefault(); // Cette méthode est toujours nécessaire pour éviter une éventuelle redirection inattendue
        if(movingCard.className.includes("king") && !element.lastElementChild){
            let margin=0;
            let parent=movingCard.parentNode;
            if(movingCard==movingCard.parentElement.lastElementChild){
                movingCard.style.marginTop=margin+"px";
                element.appendChild(movingCard);
            }else{
                let nextSiblings=getNextSiblings(movingCard);
                movingCard.style.marginTop=margin+"px";
                element.appendChild(movingCard);
                nextSiblings.forEach(sibling => {
                    margin+=20;
                    sibling.style.marginTop=margin+"px";
                    element.appendChild(sibling);
                });
            }
            if(parent.lastElementChild && parent.lastElementChild.lastElementChild.style.display!="none" && parent!=fausse){           
                makeDraggable(parent.lastElementChild);
                parent.lastElementChild.lastElementChild.style.display="none";
                console.log("colomns");
                frontSideCardsCount+=1;
                if(frontSideCardsCount==52){
                    winMessage.style.display="block";
                }
            }  
        }  
        console.log(frontSideCardsCount);     
    });
});
        

let movingCard;

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

colomns.forEach(element => {
    let margin=0;
    element.querySelectorAll(".card").forEach(element => {
        element.style.marginTop=margin+"px";
        margin+=20;
        if(element!=element.parentNode.lastElementChild){
            element.lastElementChild.style.display="block";
        }else{
            makeDraggable(element);
        }
    });
});

let cards=document.querySelectorAll(".card");

cards.forEach(element => {
    let i=cardGeneration();
    element.className+=" "+cardCorrespondance[i-1][0];
    element.setAttribute("cardValue",cardCorrespondance[i-1][1]);
    element.setAttribute("cardColor",cardCorrespondance[i-1][2]);
    let cardClass="";
    if(cardCorrespondance[i-1][0].includes("clubs")){
        cardClass="clubs";
    }else if(cardCorrespondance[i-1][0].includes("hearts")){
        cardClass="hearts";
    }else if(cardCorrespondance[i-1][0].includes("spades")){
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
        if(element.lastElementChild.style.display!="block" 
        && element.parentElement.parentElement.id=="bottom" 
        && movingCard.attributes.cardColor.value!=element.attributes.cardColor.value 
        && movingCard.attributes.cardValue.value==element.attributes.cardValue.value-1){
            let margin=parseInt(element.parentElement.lastElementChild.style.marginTop.slice(0,-2))+20;
            let parent=movingCard.parentNode;
            if(movingCard==movingCard.parentElement.lastElementChild){
                movingCard.style.marginTop=margin+"px";
                element.parentElement.appendChild(movingCard);
            }else{
                let nextSiblings=getNextSiblings(movingCard);
                movingCard.style.marginTop=margin+"px";
                element.parentElement.appendChild(movingCard);
                nextSiblings.forEach(sibling => {
                    margin+=20;
                    sibling.style.marginTop=margin+"px";
                    element.parentElement.appendChild(sibling);
                });
            }
            console.log(parent);
            if(parent.lastElementChild && parent.lastElementChild.lastElementChild.style.display!="none" && parent!=fausse){ 
                makeDraggable(parent.lastElementChild);
                parent.lastElementChild.lastElementChild.style.display="none";
                console.log("cards");
                frontSideCardsCount+=1;
                if(frontSideCardsCount==52){
                    winMessage.style.display="block";
                }
            }  
        }
        console.log(frontSideCardsCount);
    });
});

let donneCards=document.querySelectorAll("#donne>div");

donneCards.forEach(element => {
    element.lastElementChild.style.display="block";
});

let donne=document.querySelector("#donne");
let fausse=document.querySelector("#fausse");

donne.addEventListener('click',function(){
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

let slots=document.querySelectorAll("#slots>div");

// let slotValues={clubs:0,hearts:0,spades:0,diamonds:0};

slots.forEach(element => {
    element.addEventListener('dragover', function(e) {
        e.preventDefault(); // Annule l'interdiction de drop
    });
    element.addEventListener('drop', function(e) {
        e.preventDefault(); // Cette méthode est toujours nécessaire pour éviter une éventuelle redirection inattendue
        if(element.id==movingCard.attributes.cardClass.value ){
            if((!element.lastElementChild &&  movingCard.attributes.cardValue.value==1) || (element.lastElementChild && movingCard.attributes.cardValue.value==parseInt(element.lastElementChild.attributes.cardValue.value)+1)){
                movingCard.style.marginTop="0px";
                let parent=movingCard.parentNode;
                element.appendChild(movingCard);
                console.log(parent);
                if(parent.lastElementChild && parent.lastElementChild.lastElementChild.style.display!="none" && parent!=fausse){ 
                    makeDraggable(parent.lastElementChild);
                    console.log(parent.lastElementChild.lastElementChild.style.display);
                    parent.lastElementChild.lastElementChild.style.display="none";
                    console.log("slots1");
                    frontSideCardsCount+=1;
                    if(frontSideCardsCount==52){
                        winMessage.style.display="block";
                    }
                }
            }
            // else if(element.lastElementChild && movingCard.attributes.cardValue.value==parseInt(element.lastElementChild.attributes.cardValue.value)+1){
            //     movingCard.style.marginTop="0px";
            //     let parent=movingCard.parentNode;
            //     element.appendChild(movingCard);
            //     if(parent.lastElementChild && parent.lastElementChild.lastElementChild.style.display!="none" && parent!=fausse){ 
            //         makeDraggable(parent.lastElementChild);
            //         parent.lastElementChild.lastElementChild.style.display="none";
            //         console.log("slots2");
            //         frontSideCardsCount+=1;
            //         if(frontSideCardsCount==52){
            //             winMessage.style.display="block";
            //         }
            //     }
            // } 
            // slotValues[movingCard.attributes.cardClass.value]=element.childElementCount;
            // if(slotValues["clubs"]==13 && slotValues["hearts"]==13 && slotValues["spades"]==13 && slotValues["diamonds"]==13){
            //     console.log("fin de partie!");
            // }
        }
        console.log(frontSideCardsCount);
    });
});