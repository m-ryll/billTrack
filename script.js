

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

function getUser(){
	var user = "";

	return user;
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
	var bill_type;
	var date;
	var cost;
	var custom;
	var name;
}

function handleError(error, message) {
    setTimeout(function() {
        error.textContent = message;
    }, 200);
}

function handleSignup(signupForm) {
    var username = signupForm.querySelector("input[name=username]");
    var passOne = signupForm.querySelector("input[name=password]");
    var passTwo = signupForm.querySelector("input[name=confirmPassword]");
    var email = signupForm.querySelector("input[name=email]");
    var error = signupForm.querySelector(".error");

    error.textContent = "";

    if (!username.value || username.value == "" ||
        !passOne.value || passOne.value == "" ||
        !passTwo.value || passTwo.value == "") {
        handleError(error, "Both username and passwords are required");
        return false;
    }

    if (passOne.value !== passTwo.value) {
        handleError(error, "Passwords do not match.");
        return false;
    }

    if (email.value.indexOf("@") == -1){
    	handleError(error, "Must enter a valid email address.");
    }

    var user = new Parse.User();
    user.set("username", username.value);
    user.set("password", passOne.value);
    user.set("email", email.value);

    user.signUp(null, {
        success: function(user) {
            window.location.href = "./index.html";
        },
        error: function(user, errorRes) {
            if (errorRes.code === Parse.Error.USERNAME_TAKEN) {
                console.dir(errorRes);
                handleError(error, "Username already taken");
            } else {
                var msg = "We failed to create you account. Please try again later";
                handleError(error, msg);
            }
        }
    });

} //end of handleSignup

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

	//document.querySelector("#add").onclick = addbill;
}

window.onload = init;




