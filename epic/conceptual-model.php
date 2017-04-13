<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Conceptual-model</title>
	</head>
	<body>
		<h1>Conceptual model</h1>
		<ul>Profile
			<li>profileId (Primary Key)</li>
			<li>profileVerificationToke</li>
			<li>profileHandle</li>
			<li>profileEmail</li>
			<li>profileHash</li>
			<li>profileSalt</li>
			</ul>

		<ul>Favorite
			<li>faveItemId (Primary key)</li>
			<li>faveProfileItemId(foreign key</li>
			<li>faveDate</li>
		</ul>

		<ul> Relations
			<li> One <strong> profile </strong> favorites <strong>products </strong> (m to n) </li>
		</ul>

	</body>
</html>