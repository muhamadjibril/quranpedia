<!DOCTYPE html>
<html>
<head>
	<title>Surah Al-Fatihah</title>
	<meta charset="utf-8">
	<style>
		.ayah {
			margin-bottom: 10px;
		}

		.bold {
			font-weight: bold;
		}

		.red {
			color: red;
		}
	</style>
</head>
<body>
	<h1>Mencari kata berawalan Alif Laam</h1>

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

	// Prepare SQL query untuk Surah
	$sql = "SELECT * FROM quran_id";
	$result = mysqli_query($conn, $sql);

	// Initialize surah and ayah variables
	$currentSurah = "";
	$currentAyah = "";

	// Print surah content with hyperlinks per kata
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$surah = $row["suraId"];
			$ayah = $row["verseID"];
			$ayahText = $row["ayahText"];

			// Check if it's a new surah or ayah
			if ($currentSurah !== $surah) {
				$currentSurah = $surah;
				echo "<h2>Surat $surah</h2>";
			}
			if ($currentAyah !== $ayah) {
				$currentAyah = $ayah;
				echo "<p>Ayat $ayah:</p>";
			}

			// Split ayah text into words
			$words = explode(" ", $ayahText);

			// Iterate over each word
			foreach ($words as $word) {
				// Check if word contains "اَلْ" (Alif Lam)
				if (strpos($word, "اَلْ") !== false)  {
					echo "<span class='ayah'><a href='surahView.php?ayahText=" . urlencode($word) . "' class='bold red'>$word</a></span>";
				} else {
					echo "<span class='ayah'>$word</span>";
				}
				echo " ";
			}
			echo "<br>";
		}
	} else {
		echo "<p>No results found.</p>";
	}

	// Close database connection
	mysqli_close($conn);
	?>
</body>
</html>
