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
			return "You win! " + playerSelection + " beats " + computerSelection;
		} else if (playerSelection == 'scissors'){
			return "You Lose! " + computerSelection + " beats " + playerSelection;
		} else {
			return "It is a draw";
		}
	} else if (computerSelection == 'paper') {
		if (playerSelection == "rock"){
			return "You Lose! " + computerSelection + " beats " + playerSelection;
		} else if (playerSelection == 'scissors'){
			return "You win! " + playerSelection + " beats " + computerSelection;
		} else {
			return "It is a draw";
		}
	} else if (computerSelection == 'scissors') {
		if (playerSelection == "rock"){
			return "You win! " + playerSelection + " beats " + computerSelection;
		} else if (playerSelection == 'paper'){
		return "You Lose! " + computerSelection + " beats " + playerSelection;
		} else {
			return "It is a draw";
		}
	}
}

//console.log(gameRound(computerPlay(),userPlay()));



