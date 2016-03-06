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
			var averageData;
			var averageText;
			function BillInit() {
				Parse.initialize("FsgP7xe2NyaWPGWQocZBErGeHZgTrQg6ohYAx4BX", "D2KxvroTInGt3aW4SEmovGOTr8U6x1BksU6Jhpiw");
				var currentUser = Parse.User.current();
				var myBills = Parse.Object.extend("Bills");
	            var query = new Parse.Query(myBills);
	            query.equalTo("userId", currentUser.id);
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
						alert("Error: " + error.code + " " + error.message);
					}
				});
				var billId = getUrlVars()["id"];
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
							var costText = document.createTextNode(object.get("cost"));
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
								averageText = document.createTextNode("Average monthly cost: " + Math.round(average * 100) / 100);	
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