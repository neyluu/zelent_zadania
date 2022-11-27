<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Baza danych</title>
    <meta name="description" content="Odczyt z bazy MySQL">
    <meta name="keywords" content="technik, informatyk, programowanie webowe, PHP, MySQL">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="main.css">

</head>

<body>

	<form action="index2.php" method="post">
		<label> 
			Podaj nazwę klasy: <input type="text" name="klasa">
		</label>
		<input type="submit" value="Pokaż uczniów!">
	</form>

<?php

if(isset($_POST['klasa']))
{
	if(empty($_POST['klasa']))
	{
		echo "Nie podano nazwy klasy!";
	} 
	else 
	{
		try {
			
			require_once "dbconnect.php";
			
			$conn = new mysqli($host, $user, $pass, $db);
			
			if ($conn->connect_errno) 
			{
				throw new Exception($conn->error);
			}
			else 
			{
				
				$conn->set_charset("utf8");
				
				$klasa = $_POST['klasa'];
				
				$q = "SELECT Imie, Nazwisko, Srednia_ocen from uczen, klasa WHERE nazwa='$klasa' AND klasa.id = uczen.id_klasy";
				
				$result = $conn->query($q);

				if (!$result) 
				{
					throw new Exception($conn->error);
				} else {
				
					$ile = $result->num_rows;
					
					if($ile == 0)
					{
						echo "Nie ma takiej klasy w bazie!";
					} 
					else 
					{	
						
echo<<<END

	<table>
		<thead>
			<tr><th>Imię</th>
			<th>Nazwisko</th>
			<th>Średnia ocen</th></tr>
		</thead>
		<tbody>
		
END;
						$suma = 0;
				
						while($obj = $result->fetch_object())
						{
							
							echo "\r\n\t\t\t<tr><td>".$obj->Imie."</td><td>".$obj->Nazwisko."</td><td>".$obj->Srednia_ocen."</td></tr>";
							
							$suma += $obj->Srednia_ocen;
						
						}
						
						$result->free();

echo<<<END
\r\n
		</tbody>
	</table>

END;
							
						echo "\t<p>Średnia klasy: ".round($suma/$ile,2)."</p>";
						
						$conn->close();	
						
					}
	
				}
				
			}

		}
		catch(Exception $error) 
		{
			echo "Problemy z odczytem danych!";
		}
	}
}

?>

</body>
</html>