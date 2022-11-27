<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Dziennik szkolny</title>
	
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
    <link rel="stylesheet" href="main.css">

</head>

<body>

	<form action="index.php" method="POST">
		<select name="klasa">
			<?php pokazKlasy(); ?>
		</select>
		<button type="submit">Pokaż oceny</button>
	</form>
	<?php pokazWychowawce(); ?>
	<?php wypisz(); ?>
</body>
</html>

<?php
	function wypisz()
	{
		if(isset($_POST['klasa']) && $_POST["klasa"] != "")
		{
			$conn = mysqli_connect("localhost", "root", "", "szkola");
			if(!$conn)
			{
				"Bład połączenia!";
				return;
			}
			$klasa = $_POST['klasa'];
	
			$sql = "SELECT Imie, Nazwisko, Srednia_ocen from uczen, klasa WHERE nazwa='$klasa' AND klasa.id = uczen.id_klasy";
			$res = mysqli_query($conn, $sql);
	
			$i = 1;
			$suma_srednich_klasy = 0;

			echo "<table>";
			echo 	"<tr>
						<td>L.p</td>
						<td>Imię</td>
						<td>Nazwisko</td>
						<td>Średnia ocen</td>
					</tr>";
			while($row = mysqli_fetch_row($res))
			{
				$imie = $row[0];
				$nazwisko = $row[1];
				$srednia = $row[2];
				echo 	"<tr>
							<td>$i</td>
							<td>$imie</td>
							<td>$nazwisko</td>
							<td>$srednia</td>
						</tr>";

				$i++;
				$suma_srednich_klasy += $srednia;
			}
			echo "</table><br>";
			echo round($suma_srednich_klasy / ($i - 1), 2);
		}
		else
		{
			echo "Podaj nazwę klasy";
		}
	}
	
	function pokazKlasy()
	{
		$conn = mysqli_connect("localhost", "root", "", "szkola");
			if(!$conn)
			{
				"Bład połączenia!";
				return;
			}
			$klasa = $_POST['klasa'];
	
			$sql = "SELECT nazwa from klasa";
			$res = mysqli_query($conn, $sql);

			while($row = mysqli_fetch_row($res))
			{
				$klasa_insert = $row[0];
				echo "<option value='$klasa_insert'>$klasa_insert</option>";
			}

	}

	function pokazWychowawce()
	{
		if(isset($_POST['klasa']) && $_POST["klasa"] != "")
		{
		$conn = mysqli_connect("localhost", "root", "", "szkola");
			if(!$conn)
			{
				"Bład połączenia!";
				return;
			}
			$klasa = $_POST['klasa'];
	
			$sql = "SELECT wychowawca.imie, wychowawca.nazwisko FROM wychowawca JOIN klasa ON wychowawca.id_klasy = klasa.id WHERE wychowawca.id_klasy='$klasa'";
			$res = mysqli_query($conn, $sql);

			while($row = mysqli_fetch_row($res))
			{
				echo "<p>$row[0] $row[1]</p>";
			}
		}
	}
?>