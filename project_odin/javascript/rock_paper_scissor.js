function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

function computerPlay(){
	let computerOption = getRandomInt(3);
	if (computerOption == 0){
		return "Scissors";
	} else if (computerOption == 1){
		return "Paper";
	} else {
		return "Scissors";
	}
}


