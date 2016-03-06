<!DOCUMENT html>
<html lang="en">
	<head>
		<title>Bill | Greentility</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic' rel='stylesheet' type='text/css'>	
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="https://www.parsecdn.com/js/parse-1.4.2.min.js"></script>		
		<script src="script.js"></script>
		<script type="text/javascript">
			"use strict";
			var billId;
			var myBills;
			var array;
			function handleMonthlyAdd(AddMonthlyForm) {
				var cost = AddMonthlyForm.querySelector("input[name=cost]").value;
				var date = AddMonthlyForm.querySelector("input[name=date]").value;

				var SmallBills = Parse.Object.extend("SmallBills");
	            var mySmallBills = new SmallBills();
	            mySmallBills.set("cost", cost);
	            mySmallBills.set("date", date);
	            mySmallBills.set("billId", billId);

	            mySmallBills.save(null, {
					success: function(mySmallBills) {
						// Execute any logic that should take place after the object is saved.
						console.log("saved!!");
						window.location.href="./bill.php?id=" + billId;
					},
					error: function(myBills, error) {
						// Execute any logic that should take place if the save fails.
						// error is a Parse.Error with an error code and message.
						console.log('Failed to create new object, with error code: ' + error.message);
					}
				});

				/*
				if(cost == "" || date == ""){
					//handleError(error, "Both cost and date are required");
				}

				/*var bill1 = new bill();
				bill1.cost = cost;
				bill1.date = date;
				console.log(bill1);
				if (typeof array === 'undefined') {
					array = [];
    
				}
				array.push(cost + " " + date);
				myBills.set("allBills", array);
				myBills.save(null, {
				  success: function(mybills) {
				    // Execute any logic that should take place after the object is saved.
				    alert('you did it');
				  },
				  error: function(mybills, error) {
				    // Execute any logic that should take place if the save fails.
				    // error is a Parse.Error with an error code and message.
				    alert('Failed to create new object, with error code: ' + error.message);
				  }
				});

				/*query.get(billId, {
					success: function(myBills){
						array = myBills.get("allBills");
						var bill1 = new bill();
						bill1.cost = cost;
						bill1.date = date;
						array.push(bill1);
						myBills.set("allBills") = array;
					},
					error: function(error) {
						alert("Failed to get billID");
					}
				});
				
				myBills.save(null, {
					success: function(myBills) {
						//

						console.log("saved!!");
						window.location.href="./index.html";
					},
					error: function(myBills, error) {
						// Execute any logic that should take place if the save fails.
						// error is a Parse.Error with an error code and message.
						console.log('Failed to create new object, with error code: ' + error.message);
					}
				});
				array.save(null, {
					success: function(data) {
						//

						console.log("saved!!");
						window.location.href="./index.html";
					},
					error: function(myBills, error) {
						// Execute any logic that should take place if the save fails.
						// error is a Parse.Error with an error code and message.
						console.log('Failed to create new object, with error code: ' + error.message);
					}
				});*/
			}


			function BillInit() {
				var AddMonthlyForm = document.querySelector("#addSpecificBill");
				var AddMonthlySubmit = document.querySelector("#submitSpecificBill");
				Parse.initialize("FsgP7xe2NyaWPGWQocZBErGeHZgTrQg6ohYAx4BX", "D2KxvroTInGt3aW4SEmovGOTr8U6x1BksU6Jhpiw");
				var currentUser = Parse.User.current();
				myBills = Parse.Object.extend("Bills");
	            var query = new Parse.Query(myBills);
	            if(currentUser){
	            	query.equalTo("userId", currentUser.id);
	            }
	            else{
	            	window.location.href = "./home.html";
	     			throw new Error("Must be logged in!");
	            }
				que
				query.find({
					success: function(results) {
						// Do something with the returned Parse.Object values
						for (var i = 0; i < results.length; i++) {
							var object = results[i];
							var sidebarList = document.querySelector("#sidebar ul");
							var newListItem = document.createElement("li");
							var newLinkItem = document.createElement("a");
							newLinkItem.setAttribute("href", "./bill.php?id=" + object.id);
							var newText = document.createTextNode(object.get("name"));
							newLinkItem.appendChild(newText);
							newListItem.appendChild(newLinkItem);
							sidebarList.insertBefore(newListItem, document.querySelector("#newBill"));
						}
					},
					error: function(error) {
						alert("Failed to locate object ID.");
					}
				});
				billId = getUrlVars()["id"];
				var query = new Parse.Query(myBills);
				query.get(billId, {
				  success: function(result) {
				  	console.log(result.get("type"));
				    if (result.get("allBills") != undefined) {
				    	array = result.get("allBills");
				    }
				  },
				  error: function(object, error) {
				    // The object was not retrieved successfully.
				    // error is a Parse.Error with an error code and message.
				  }
				});

				AddMonthlySubmit.addEventListener("click", function(e) {
					handleMonthlyAdd(AddMonthlyForm);
					e.preventDefault();
					return false;
				});

				
				var header = document.createElement("p");
				var query2 = new Parse.Query(myBills);
				query2.get(billId, {
					success: function(myBills){
						var headerText = document.createTextNode("Add a New " + myBills.get("name") + " Bill");
						header.appendChild(headerText);
						document.querySelector("#pageTitle").appendChild(headerText);
					},
					error: function(error) {
						alert("Failed to location billID.");
					}
				});
			}

			window.onload = BillInit;
		</script>
	</head>
	<body>
		<div id="container">
			<div id="logo">
                <h2>greentility</h2>
            </div>
			<header>
				<p id="pageTitle"></p>
				<p id="logOutButton">Log Out</p>
			</header>
			<div id="sidebar">
				<ul>
					<li><a href="index.html">Dashboard</a></li>
					<li id="newBill"><a href="addbill.html">Add a new bill</a></li>
				</ul>
			</div>
			<div id="main">
				<form id="addSpecificBill" action="#" method="POST">
					<label for="date">Date of bill:</label><br />
					<input type="date" name="date" /><br />
					<label for="cost">Cost:</label><br />
					<input type="text" name="cost" /><br />
					<input id="submitSpecificBill" type="submit" value="Create Bill" />
				</form>
			</div>
		</div>
	</body>
</html>