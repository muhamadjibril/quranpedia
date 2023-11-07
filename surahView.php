<!DOCTYPE html>
<html>
<head>
	<title>View Ayahs</title>
	<meta charset="utf-8">
	<style>
		.red {
			color: red;
		}
	</style>
</head>
<body>
	<?php
	// Set up database connection
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "quran";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Check if ayahText parameter is set
	if (isset($_GET["ayahText"])) {
		$ayahText = $_GET["ayahText"];

		// Prepare SQL query to retrieve all ayahs with the same text
		$sql = "SELECT * FROM quran_id WHERE ayahText LIKE '%" . mysqli_real_escape_string($conn, $ayahText) . "%'";
		$result = mysqli_query($conn, $sql);

		// Print all ayahs with the same text
		echo "<h2>Ayahs with the same text:</h2>";
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$surahId = $row["suraId"];
				$verseId = $row["verseID"];
				$ayahText = $row["ayahText"];

				// Highlight the words containing "اَلْ" (Alif Lam)
				$highlightedText = preg_replace('/(اَلْ\w+)/u', '<span class="red">$1</span>', $ayahText);

				echo "<p>Surah: $surahId - Ayah: $verseId $highlightedText</p>";
			}
		} else {
			echo "<p>No results found.</p>";
		}
	} else {
		echo "<p>Invalid request.</p>";
	}

	// Close database connection
	mysqli_close($conn);
	?>
</body>
</html>
