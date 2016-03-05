// JOSHY TYPE HERE


// user constructor
function user(){
	var name;
	var bills;
}
// bill constructor
function bill(){
	var type;
	var cost;
	var date;
	var name;
}
// returns the 'average of [type]' bill cost
function average(myarray){
	var size = myarray.length;
	var sum = 0;
	for(var i = 0; i < size; i++){
		sum = sum + myarray[i].cost;
	}
	return console.log("Average of " + myarray[0].type + " = " + sum/size);
}

function addbill(){
	var prompt = window.prompt("What type of bill would you like to add?");
	var prompt2 = window.prompt("You would like to add an " + prompt + " bill.");
}



function init() {
	// test data
	/*var user1 = new user();
	user1.name = "Jimmy";
	user1.bills = [];
	var bill1 = new bill();
	var bill2 = new bill();
	var bill3 = new bill();
	bill1.type = "electric";
	bill1.cost = 100;
	bill1.date = 1 + "/" + 16;
	bill1.name = "Electric-Home";
	bill2.type = "electric";
	bill2.cost = 200;
	bill2.date = 2 + "/" + 16;
	bill2.name = "Electric-Home";
	bill3.type = "electric";
	bill3.cost = 125;
	bill3.date = 3 + "/" + 16;
	bill3.name = "Electric-Home";
	user1.bills.push(bill1, bill2, bill3);
	average(user1.bills);*/

	document.querySelector("#add").onclick = addbill;
	//addbill();



	
}

window.onload = init;




