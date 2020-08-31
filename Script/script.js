let numbers=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]

function cardGeneration(){
    let index=Math.floor(Math.random() * (numbers.length) ); 
    let number=numbers[index];
    numbers.splice(index,1);
    return number;
}

let cardCorrespondance=[
    "ace_clubs",
    "two_clubs",
    "three_clubs",
    "four_clubs",
    "five_clubs",
    "six_clubs",
    "seven_clubs",
    "eight_clubs",
    "nine_clubs",
    "ten_clubs",
    "jack_clubs",
    "queen_clubs",
    "king_clubs",
    "ace_hearts",
    "two_hearts",
    "three_hearts",
    "four_hearts",
    "five_hearts",
    "six_hearts",
    "seven_hearts",
    "eight_hearts",
    "nine_hearts",
    "ten_hearts",
    "jack_hearts",
    "queen_hearts",
    "king_hearts",
    "ace_spades",
    "two_spades",
    "three_spades",
    "four_spades",
    "five_spades",
    "six_spades",
    "seven_spades",
    "eight_spades",
    "nine_spades",
    "ten_spades",
    "jack_spades",
    "queen_spades",
    "king_spades",
    "ace_diamonds",
    "two_diamonds",
    "three_diamonds",
    "four_diamonds",
    "five_diamonds",
    "six_diamonds",
    "seven_diamonds",
    "eight_diamonds",
    "nine_diamonds",
    "ten_diamonds",
    "jack_diamonds",
    "queen_diamonds",
    "king_diamonds",
]

let cardsInColomn=document.querySelectorAll("#bottom>div");

cardsInColomn.forEach(element => {
    let margin=0;
    element.querySelectorAll(".card").forEach(element => {
        element.style.marginTop=margin+"px";
        margin+=20;
        if(element!=element.parentNode.lastElementChild){
            element.lastElementChild.style.display="block";
        }
    });
});

let cards=document.querySelectorAll(".card");

cards.forEach(element => {
    let i=cardGeneration()
    element.className+=" "+cardCorrespondance[i-1];
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
        fausse.appendChild(card);
    }else{
        let fausseCards=document.querySelectorAll("#fausse>div");
        for (let index = fausseCards.length-1; index >=0; index--) {
            fausseCards[index].firstElementChild.display="block";
            donne.appendChild(fausseCards[index]);
        }
    }
});