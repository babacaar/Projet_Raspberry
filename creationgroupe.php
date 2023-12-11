<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau groupe</title>
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
            width: 100%;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        h1 {
            background-color: lightblue;
            color: #000;
            padding: 10px;
            text-align: center;
        }

        .title {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        textarea {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .logo-img {
            width: 298px;
            height: 127px;
            border-radius: 8px;
            margin-left: 20px;
        }

        .container {
            display: flex;
            align-items: center;
        }

        li.dropdown {
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="configuration.php">
            <img class="logo-img" alt="Banniere" src="lycee.jpg">
        </a>
        <ul>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Hôtes</a>
                <div class="dropdown-content">
                    <a href="list.php">Liste des hôtes</a>
                    <a href="gestionPis.php">Ajouter un hôte</a>
                </div>
            </li>
	    <li><a href="creationgroupe.php">Groupes</a></li>
        </ul>
    </div>
    <h1 class="title">Nouveau groupe</h1>
    <form method="post" action="controller_ajoutgroupe.php" novalidate="novalidate">
        <div class="form-group">
            <label for="name">Nom de groupe</label>
            <input type="text" name="name" id="name" required="">
        </div>
        <div class="form-group">
            <label for="description">Description du groupe</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" name="add" id="add">Ajouter</button>
        </div>
    </form>
</body>
</html>
