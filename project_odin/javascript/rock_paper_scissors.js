function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

function computerPlay(){
	let computerOption = getRandomInt(3);
	if (computerOption == 0){
		return "scissors";
	} else if (computerOption == 1){
		return "paper";
	} else {
		return "rock";
	}
}

function userPlay(){
	let userInput = prompt("Select either rock, paper or scissors");
	return userInput.toLowerCase();

}

function gameRound(computerSelection, playerSelection){
	if (computerSelection == 'rock') {
		if (playerSelection == "paper"){
			return "You win!"; //+ playerSelection + " beats " + computerSelection;
		} else if (playerSelection == 'scissors'){
			return "You Lose!";// + computerSelection + " beats " + playerSelection;
		} else {
			return "It is a draw";
		}
	} else if (computerSelection == 'paper') {
		if (playerSelection == "rock"){
			return "You Lose!"; // + computerSelection + " beats " + playerSelection;
		} else if (playerSelection == 'scissors'){
			return "You win!" ; //+ playerSelection + " beats " + computerSelection;
		} else {
			return "It is a draw";
		}
	} else if (computerSelection == 'scissors') {
		if (playerSelection == "rock"){
			return "You win!"; // + playerSelection + " beats " + computerSelection;
		} else if (playerSelection == 'paper'){
		return "You Lose!"; // + computerSelection + " beats " + playerSelection;
		} else {
			return "It is a draw";
		}
	}
}

function game(){
	let computerCount =  0;
	let playerCount  = 0;
	for (var i = 1; i < 6; i++){
		if (gameRound(computerPlay(), userPlay()) == "You win!"){
			playerCount += 1;
		} else {
			computerCount += 1;
		}
	}
	return "At the end of 5 games the computer won: " + 
	computerCount.toString() + 
	" games while the " + 
	"player won: " +  playerCount.toString() + " games";
}


console.log(game());



