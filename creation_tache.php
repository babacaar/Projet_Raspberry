<html>
  <head>
    <title>Formulaire en PHP/MySQL</title>
	<link rel="stylesheet" href="style.css" />
  </head>
  <body>
     <form method="post" action="controller_creation.php">
     Tache : <br />
	 <input type="text" name="TDL_Name_Tache" placeholder="Entrez la tache à éffectuer" size="30"/><br />
	 Priorité : <br />
	 <label for="TDL_Priority" name="TDL_Priority"></label>
	<select id="TDL_Priority" name="TDL_Priority">
		<option value="Moyenne">Moyenne</option>
		<option value="Haute">Haute</option>
		<option value="Basse">Basse</option>
	</select><br />
	A faire pour le : <br />
	<input type="date" name="TDL_Date_Jalon" value=""><br />
	
	<input type="submit" value="Submit" /><br />
	<input type="button" onclick="window.location.href = 'http://172.17.5.202/Menu.php';" value="Menu" /><br />
    </form>
   </body>
</html>