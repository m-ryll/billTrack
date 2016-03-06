<!DOCUMENT html>
<html lang="en">
	<head>
		<title>Bill | Greentility</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic' rel='stylesheet' type='text/css'>	
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="https://www.parsecdn.com/js/parse-1.4.2.min.js"></script>
		<script src="Chart.min.js"></script>		
		<script src="script.js"></script>
		<script type="text/javascript">
			var averageData;
			var averageText;
			var data = {
			    labels: ["January", "February", "March", "April", "May", "June", "July"],
			    datasets: [
			        {
			            label: "My First dataset",
			            fillColor: "rgba(220,220,220,0.2)",
			            strokeColor: "rgba(220,220,220,1)",
			            pointColor: "rgba(220,220,220,1)",
			            pointStrokeColor: "#fff",
			            pointHighlightFill: "#fff",
			            pointHighlightStroke: "rgba(220,220,220,1)",
			            data: [65, 59, 80, 81, 56, 55, 40]
			        }
			    ]
			};
			var billId = getUrlVars()["id"];
			function BillInit() {
				Parse.initialize("FsgP7xe2NyaWPGWQocZBErGeHZgTrQg6ohYAx4BX", "D2KxvroTInGt3aW4SEmovGOTr8U6x1BksU6Jhpiw");
				var logOutButton = document.querySelector("#logOutButton");
				logOutButton.onclick = function(){
					Parse.User.logOut();
					window.location.href = "./home.html";
					console.log("clicked!");
				}; 
				var currentUser = Parse.User.current();
				var myBills = Parse.Object.extend("Bills");
	            var query = new Parse.Query(myBills);
	            if(currentUser){
	            	query.equalTo("userId", currentUser.id);
	            }
	            else{
	            	window.location.href = "./home.html";
	            	throw new Error("Must be logged in!");

	            }
				query.find({
					success: function(results) {
						// Do something with the returned Parse.Object values
						for (var i = 0; i < results.length; i++) {
							var object = results[i];
							var sidebarList = document.querySelector("#sidebar ul");
							var newListItem = document.createElement("li");
							if (object.id == billId) {
								newListItem.setAttribute("class", "active");
							}
							var newLinkItem = document.createElement("a");
							newLinkItem.setAttribute("href", "./bill.php?id=" + object.id);
							var newText = document.createTextNode(object.get("name"));
							newLinkItem.appendChild(newText);
							newListItem.appendChild(newLinkItem);
							sidebarList.insertBefore(newListItem, document.querySelector("#newBill"));
						}
					},
					error: function(error) {
						alert("Error: " + error.code + " " + error.message);
					}
				});
				var average = 0;
				var sum = 0;
				var mySmallBills = Parse.Object.extend("SmallBills");
	            var query = new Parse.Query(mySmallBills);
	            query.equalTo("billId", billId);
				query.find({
					success: function(results) {
						// Do something with the returned Parse.Object values
						for (var i = 0; i < results.length; i++) {

							var object = results[i];
							var dateData = document.createElement("td");
							var dateText = document.createTextNode(object.get("date"));
							dateData.appendChild(dateText);
							var costData = document.createElement("td");
							var costText = document.createTextNode("$" + object.get("cost"));
							costData.appendChild(costText);
							var row = document.createElement("tr");
							row.appendChild(dateData);
							row.appendChild(costData);
							var tbody = document.querySelector("tbody");
							tbody.appendChild(row);
							
							sum += parseFloat(object.get("cost"));
							if(i == results.length - 1){
								average = sum/results.length;
								averageData = document.createElement("p");
								averageText = document.createTextNode("Average monthly cost: $" + Math.round(average * 100) / 100);	
							}
						}
						averageData.appendChild(averageText);
						document.querySelector("#main").appendChild(averageData);
					},
					error: function(error) {
						alert("Error: " + error.code + " " + error.message);
					}
				});

				var link = document.createElement("a");
				var text = document.createTextNode("add this month's bill");
				link.setAttribute("href", "./addMonthlyBill.php?id=" + billId);
				link.appendChild(text);
				document.querySelector("#main").appendChild(link);

				// Make a line chart.
				
				var ctx = document.getElementById("myChart").getContext("2d");
				var myLineChart = new Chart(ctx).Line(data, {
					bezierCurve: true
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
				<p id="pageTitle">Add a new bill</p>
				<p id="logOutButton">Log Out</p>
			</header>
			<div id="sidebar">
				<ul>
					<li><a href="index.html">Dashboard</a></li>
					<li id="newBill"><a href="addbill.html">Add a new bill</a></li>
				</ul>
			</div>
			<div id="main">
				<canvas id="myChart" width="400" height="400"></canvas>
				<table>
					<thead>
						<tr>
							<th>Date</th>
							<th>Cost</th>
						</tr>	
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>