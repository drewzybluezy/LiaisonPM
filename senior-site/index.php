<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Liaison Project Manager</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link href="favicon.ico" rel="shortcut icon">

</head>

<body>
<div class="header">
	<table style="width:100%;">
	<tr>
		<th style="width: 100%; height: 75px;">
			<img src="css/images/lsu.png" width=50px; height=50px; style="display:inline-block; vertical-align:middle; -webkit-margin-before:10px; margin-right:20px;">
			<h2 style="display:inline-block; vertical-align:middle; color:#FFE345; -webkit-margin-before:10px; text-shadow: 2px 2px 2px rgba(0,0,0,0.7)">
			Liaison Technologies Project Manager</h2></img>
		</th>
	</tr>
	</table>
</div>

<div class="main_container">
	<table style="width:100%;">
	<tr style="width:100%;">
		<th name="button" id="aboutlink" style="width:25%; height: 50px; background: url(css/images/button.png);
				vertical-align:middle; font-size:20px;">
			<a>About</a>
		</th>
		
		<th name="button" id="archlink" style="width:25%; height: 50px; background: url(css/images/button.png);
				vertical-align:middle; font-size:20px;">
			<a>Technical Overview</a>
		</th>
		
		<th name="button" id="teamlink" style="width:25%; height: 50px; background: url(css/images/button.png);
				vertical-align:middle; font-size:20px;">
			<a>Team</a>
		</th>
		
		<th name="button" id="liaisonlink" style="width:25%; height: 50px; background: url(css/images/button.png);
				vertical-align:middle; font-size:20px;">
			<a>Liaison Project Manager</a>
		</th>
	</tr>
	</table>
</div>

<div id="about">
	<li class="boxed">
		<h3>Liaison Technologies</h3>
		</br>
		<div name="liaison" style="display:inline-block; padding-left:25px; width: 100%">
			<table width=100%>
				<td style="vertical-align:top;">
					<div style="font-size:18px;"><i>
					"Liaison Technologies is a global integration and data management company providing unique & high-value 
					solutions to securely integrate, transform and manage complex business information on-premise or in the cloud.<br></br>
					Businesses around the world gain a competitive advantage with timely, 
					relevant and trustworthy data for their top business imperatives. Liaison provides a specialized set of solutions 
					& services focused on solving complex data integration challenges to over 7,000 organizations in over 35 countries. 
					Headquartered in Atlanta, GA. Liaison also has offices in the Netherlands, Finland, Sweden and the United Kingdom.<br></br>
					The company’s solution portfolio includes business-to-business and enterprise application integration project outsourcing, 
					cloud-based master data management (MDM), data harmonization, data security, a service oriented architecture-based B2B 
					integration network, and premiere managed services."</i>
					<br></br>
					<a href="http://www.liaison.com" target="_blank" style="font-size: 20px; color:#306EFF;
					text-shadow: none;">-Liaison Technologies website</a></div>
					</div>
				</td>
				<td><img src="css/images/logo2.png" height=100px width=300px style="vertical-align:top; float:right; margin-left: 25px;" /></td>
			</table>
		</div>
		<br></br>
		<h3>Project Manager</h3>
		</br>
		<div name="description" style="font-size:18px; display:inline-block; padding-left:25px; width: 100%">
			<b><u>Need</u></b>
			<br></br>
				As Liaison's main focus is on team-based development, they require a method of keeping track of projects. To accomplish this,
				they are requesting a solution which helps maintain communication between teammates, lets team members stay up-to-date on
				current tasks and projects, and updates management on resource allocation and project status.
			<br></br>
			<b><u>Solution</u></b>
			<br></br>
				The purpose of the Project Manager is to provide an efficient, effective, and simple method of assisting development teams in
				coordinating their efforts. These efforts include: tracking projects' progression in relation to developmental constraints, effective allocation 
				of resources, and reporting information to higher-level personnel
				in an organized, professional manner.
			<br></br>
				Our solution to this problem is implemented in the form of a web site. A web site allows users a lightweight solution, eliminating
				the need for installation and allowing changes to the program to take place server-side. The program accesses a MySQL database, utilizing
				JavaScript, JQuery, and HTML on the client side, and PHP on the server side.
		</div>
	</li>
</div>

<div id="architecture" style="display:none;">
	<li class="boxed">
		<h3>Overview</h3>
		</br>
		<div style="padding-left:25px; font-size:18px;">
			<div style="width:600px; font-size:80%; text-align:center; float:right; margin:25px;">
				<img src="css/images/flowChart.png" height=400px width=600px/>
				<i>Fig. 1 - Work flow diagram.</i>
			</div>
			<div style="width:600px; font-size:80%; text-align:center; float:right;  margin:25px;">
				<img src="css/images/schema.png" height=400px width=600px style="padding-bottom:10px;"/>
				<i>Fig. 2 - Our database schema, using MySQL.</i>
			</div>
				The design of the Project Manager allows users to observe projects on different levels of detail,
			from a brief coverage to a detailed layout including components and related employees. Projects and 
			related components can be added, modified, or removed with simple, easy-to-understand controls, though 
			only by authorized users via a log-in system. This system utilizes a hierarchy lock implementation based 
			on permission tiers. The application's final blueprint (Fig. 1) is offered for clarification.
			<br></br>
				The information storage for projects, related components, and users for this 
			web-based application is within a MySQL database. This database contains an organized network of tables, with 
			critical or related information kept safe and synchronized by input-constraints and recoverability handled by the
			application for user convenience. The database schema can be seen in Fig. 2.
			<br></br>
			<div style="display:block;">
				<h3 style="margin-left:0;">Tools</h3>
				The project manager has been implemented with the following:<br></br>
				<b><u>Languages:</u></b>
				<ul style="list-style-type:disc; margin-top:5px;">
					<li><b>PHP:</b> back-end processing/data manipulation</li>
					<li><b>MySQL:</b> Data Storage/Constraints</li>
					<li><b>JavaScript:</b> front-end application interface/appearance </li>
					<li><b>JQuery:</b> front-end application interface improvement/appearance enhancement</li>
				</ul>
				</br>
				<b><u>JQuery Plugins:</u></b>
				<ul style="list-style-type:disc; margin-top:5px;">
					<li><b>Chosen:</b> Provides support for multiple selection/search capability</li>
					<li><b>DataTables:</b> table structure w/ sorting and search features</li>
				</ul>
				</br>
				<b><u>Outsourced Components:</u></b>
				<ul style="list-style-type:disc; margin-top:5px;">
					<li><b>PHPExcel:</b> Professional Report Generation with dynamic data transfer</img>, provided at
						<a href="http://phpexcel.codeplex.com/" style="font-size: 16px; color:rgba(26,89,120,0.9); font-weight:bold;
						font-size:20px; text-shadow: none; text-decoration: underline;">PHPExcel Home</a></li>
				</ul>
			</div>
			<div style="clear:both;" />
		</div>
	</li>
</div>

<div id="team" style="display:none;">
	<li class="boxed">
		<h3>Team Members</h3>
		</br>
		<div name="Drew" style="display:inline-block; padding-left:25px;">
			<table>
			<td style="vertical-align:top;"><img class="pic" src="css/images/drew.jpg" height=200px; width=150px;/></td>
			<td><h3 style="margin-top:0;">Andrew Murphy</h3>
			<div style="margin-left: 10px; font-size: 16px;">
				<b>Email: </b>dr3wmurphy@siu.edu<br></br>
				<a href="http://www.github.com/dr3wmurphy" target="_blank" style="font-size: 16px; color:rgba(26,89,120,0.9); font-weight:bold;
				font-size:20px; text-shadow: none; text-decoration: underline;">Github profile</a><br></br>
				<b>Responsibilities:</b>
				<ul style="list-style-type:disc; margin-top:5px; margin-left:20px;">
					<li>Website look and feel</li>
					<li>Project Google Site Administrator</li>
					<li>UI Design Lead</li>
					<li>Interaction Flow Design</li>
					<li>Senior Project Site Implementation</li>
					<li>Milestone Implementation</li>
				</ul>
				</br>
				<b>Interests:</b>
				<ul style="list-style-type:disc; margin-top:5px; margin-left:20px;">
					<li>OpenGL</li>
					<li>Game Design/Development</li>
					<li>Android Development</li>
					<li>Java/Swing</li>
					<li>MySQL</li>
					<li>HTML/CSS</li>
				</ul>
				</br>
				<b>Bio:</b><br></br>
					Born in Terre Haute, IN and raised in Marshall, IL, Andrew "Drew" Murphy graduated from Marshall High School in 2009 before
					attending SIUC, majoring in Computer Science with a minor in Mathematics and a concentration in game development. Recipient of
					the prestigious Chancellor's Scholarship and the 2013 Outstanding Computer Science Senior award, he is set to graduate in May 2013
					with a 3.9 cumulative GPA before moving to Kansas City, MO under the employment of Cerner Corporation as a Software Engineer.
				
			</div>
			</td></table>
		</div>
		<br></br><br></br>
		<div name="Joe" style="display:inline-block;  padding-left:25px;">
			<table>
			<td style="vertical-align:top;"><img class="pic" src="css/images/joe.jpg" height=200px; width=150px;/></td>
			<td><h3 style="margin-top:0;">Joseph Ahart</h3>
			<div style="margin-left: 10px; font-size: 16px;">
				<b>Email: </b>josephcharlesdoom@gmail.com<br></br>
				<b>Responsibilities:</b>
				<ul style="list-style-type:disc; margin-top:5px; margin-left:20px;">
					<li>Initial prototype Design/Implementation</li>
					<li>Project Oversight</li>
					<li>Communication with Liaison Throughout Development</li>
					<li>Slide Show Functionality</li>
				</ul>
				</br>
				<b>Interests:</b>
				<ul style="list-style-type:disc; margin-top:5px; margin-left:20px;">
					<li>Game Design/Development</li>
					<li>User Interface Design/Development</li>
					<li>Android Application Development</li>
					<li>Web/Mobile Development</li>
					<li>Java</li>
					<li>HTML/CSS</li>
				</ul>
				</br>
				<b>Bio: </b><br></br>
					Joe was born in the suburbs of Chicago where he spent his whole life prior to college, and graduated from Glenbard North High School in 2006. 
					He started attending Southern Illinois University in January, 2009, to acheive a Bachelor of Science degree in Computer Science 
					with a concentration in game development. He is expected to graduate in December of 2013.
				
			</div>
			</td></table>
		</div>
		<br></br><br></br>
		<div name="Donald" style="display:inline-block; padding-left:25px;">
			<table>
			<td style="vertical-align:top;"><img class="pic" src="css/images/donnie.jpg" height=200px; width=150px;/></td>
			<td><h3 style="margin-top:0;">Donald Miller</h3>
			<div style="margin-left: 10px; font-size: 16px;">
				<b>Email: </b>dmcs10.4@siu.edu<br></br>
				<b>Responsibilities:</b>
				<ul style="list-style-type:disc; margin-top:5px; margin-left:20px;">
					<li>Server-side functionality</li>
					<li>Log in/out Security</li>
					<li>Report Generation</li>
					<li>Data/application recoverability</li>
				</ul>
				</br>
				<b>Interests:</b>
				<ul style="list-style-type:disc; margin-top:5px; margin-left:20px;">
					<li>Game Design/Development</li>
					<li>Graphical Application Design/Development</li>
					<li>User Interface Design/Development</li>
					<li>Java</li>
					<li>MySQL</li>
					<li>PHP</li>
				</ul>
				</br>
				<b>Bio:</b><br></br>
					Donald Miller attended Rend Lake College from Fall 2007-Spring 2010, where he obtained his Associate's Degree.
					Afterwards, he transferred to Southern Illinois University, beginning attendance Fall 2010. During this period 
					of time, he has been accepted into the Golden Key International Honour Society, as well as the Delta Epsilon Iota 
					Academic Honor Society. His graduation is to occur at the end of Summer 2013.
					
			</div>
			</td></table>
		</div>
	</li>
</div>

</body>

<script type="text/javascript" src="js/jquery.js"></script>
<script>
	$('th#aboutlink').click(function() {
		document.getElementById('about').style.display="inline";
		document.getElementById('architecture').style.display="none";
		document.getElementById('team').style.display="none";
	});
	
	$('th#archlink').click(function() {
		document.getElementById('architecture').style.display="inline";
		document.getElementById('about').style.display="none";
		document.getElementById('team').style.display="none";
	});
	
	$('th#teamlink').click(function() {
		document.getElementById('team').style.display="inline";
		document.getElementById('about').style.display="none";
		document.getElementById('architecture').style.display="none";
	});
	
	$('th#liaisonlink').click(function() {
		window.open("../web/", '_blank');
	});
</script>

</html>
