<?php

$host = "webdev.iyaserver.com";
$userid = "lewischr";
$userpw = "Iya6521484446";
$db = "lewischr_recipes";

$mysqli = new mysqli ($host, $userid, $userpw, $db);

if ($mysqli->connect_errno) {
    echo "db connection error" . $mysqli->connect_error;
    exit("STOPPING page");
}
?>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="generalStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900|Montserrat:400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



    <meta charset="UTF-8">
    <title>Pantry Pal</title>
    <style>
        body{
            background-image: none;
            background-color: white;
        }
        #resultsDiv {
            background-color: white;
            height: auto;
            padding: 10px;
            float: left;
            width: 80%;

        }


        .searchResult {
            width: 250px;
            margin: 30px;
            background-color: rgb(255, 255, 255);
            border-radius: 10px;
            padding-bottom: 15px;
            -webkit-box-shadow: -1px 0px 7px 1px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: -1px 0px 7px 1px rgba(0, 0, 0, 0.1);
            box-shadow: -1px 0px 7px 1px rgba(0, 0, 0, 0.1);
            height: auto;
            float: left;
            display: block;
            clear: both;
        }

        .recipeImage {
            width: 100%;
            margin-bottom: 0px;
            position: relative;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        #filters{
            width: 200px;
            padding: 25px;
            float: left;
            margin-left: 30px;
            margin-top: 30px;
            position: -webkit-sticky;
            position: sticky;
            top: 60px;

        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 11pt;
        }

        .recipeInfo {
            width: 230px;
            margin: 10px;
            color: grey;

        }

        .recipeName {
            font-size: 16pt;
            line-height: 22pt;
            font-weight: bold;
            font-family: Lato, Helvetica, sans-serif;
            color: black;
        }

        .tags {
            padding: 2px 10px 2px 10px;
            background-color: #8AC1C6;
            border-radius: 10px;
            margin-top: 10px;
            margin-right: 5px;
            float: left;
            color: white;
            font-size: 10pt;
        }
        .outLink {
            height: 15px;
            float: right;
        }
        .resultsHeader{
            width: 100%;
            background-image:
        }
        .resultsHeader{
            background-image: url("mainBG.jpg");
            background-size: 140%;
            background-position-y: -500px;
            background-position-x: -30px;
            background-position: fixed;
            width: 100%;
            height: 400px;
        }
        .resultsHeaderText{
            color: white;
            padding-top: 160px;
            padding-left: 70px;
        }
        .filterTag{
            padding: 2px 10px 2px 10px;
            background-color: #F4F4F4;
            border-radius: 5px;
            margin-top: 10px;
            margin-right: 5px;
            float: left;
            color: #9E9E9E;
            font-size: 10pt;
        }
    </style>
</head>
<body>
<?php
include_once 'header.php';
?>

<div class="resultsHeader">
<div class="resultsHeaderText">
    <h1>Recipes You Can Make...</h1>
</div>

</div>
<div id="filters">
<strong style="font-family: 'Montserrat', sans-serif; font-size: 14pt;">filters:</strong>
    <br><br>
    ingredients
    <br>
    <div class="filterTag">
        penne &nbsp; x
    </div>
    <div class="filterTag">
        pesto &nbsp; x
    </div>
    <div class="filterTag">
        garlic &nbsp; x
    </div>
    <div style="clear: both;">

    </div>
    <br><br>

    meal types
    <br>
    <div class="filterTag">
        dinner &nbsp; x
    </div>

    <div style="clear: both;">

    </div>
    <br><br>

    diet
    <br>
    <div class="filterTag">
        vegan &nbsp; x
    </div>

</div>
<div id="resultsDiv">
    <?php
    if($_REQUEST) {


        $sql = "SELECT * FROM lewischr_recipes.all_data_view
    WHERE ingredient IN ('" . $_REQUEST["ingred1"] . "' , '" . $_REQUEST["ingred2"] . "', '" . $_REQUEST["ingred3"] . "') GROUP BY title";
    } else {
        $sql = "SELECT * FROM lewischr_recipes.all_data_view WHERE 1 group by ID";
    }
    if ($result = $mysqli->query($sql)) {

        while ($row = $result->fetch_assoc()) {
            echo '<div class="searchResult">
            <img class="recipeImage" src="'.$row["imgURL"].'">
            <div class="recipeInfo">
            <span class="recipeName"><strong>' . $row['title'] . '</strong>
            <a href="'.$row["url"].'" target="_blank" ><img class="outLink" src="Asset%204.png"> </a> 
            <br></span>
            <em>' . $row['description'] . '</em>
            <br>';
            //echo '<div class="tags">'.$row["ID"].'</div>';

            $sqlMeals = "SELECT * FROM lewischr_recipes.recipe_meal_join WHERE mID=" . $row["ID"];
            //echo $sqlDiets;
            if ($mealTagResult = $mysqli->query($sqlMeals)) {
                while ($mealTagRow = $mealTagResult->fetch_assoc()) {
                    //echo '<div class="tags">'.$row["ID"].'</div>';
                    echo '<div class="tags">'.$mealTagRow["meal"].'</div>';
                    //var_dump($mysqli);
                }
            }
            else {
                var_dump($mysqli);
            }
            $sqlDiets = "SELECT * FROM lewischr_recipes.recipe_diet_join WHERE dID=" . $row["ID"];
            //echo $sqlDiets;
            if ($dietTagResult = $mysqli->query($sqlDiets)) {
                while ($dietTagRow = $dietTagResult->fetch_assoc()) {
                    //echo '<div class="tags">'.$row["ID"].'</div>';
                    echo '<div class="tags">'.$dietTagRow["diet"].'</div>';
                    //var_dump($mysqli);
                }
            }
            else {
                var_dump($mysqli);
            }
            echo '</div></div>';
        }
    }
    ?>
    <script src="masonry.pkgd.min.js"></script>
    <script>
        $('.resultsDiv').masonry({

            itemSelector: '.grid-item',
            columnWidth: 250
        });

    </script>
</div>

</body>
</html>
