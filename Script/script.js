function cardGeneration(){
    return Math.floor(Math.random() * (52) + 1);   
}

let cardCorrespondance=[
    "ace_clubs",
    "two_clubs",
    "three_clubs"
]

let cardsInColomn=document.querySelectorAll("#bottom>div");

cardsInColomn.forEach(element => {
    let margin=0;
    element.querySelectorAll("div").forEach(element => {
        element.style.marginTop=margin+"px";
        margin+=20;
    });
});

let cards=document.querySelectorAll(".card");

cards.forEach(element => {
    let i=cardGeneration()
    element.className+=" "+cardCorrespondance[i];
});