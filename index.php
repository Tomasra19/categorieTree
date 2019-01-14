<?php
include_once 'php/dbConfig.php';

//select all rows from the category table query
$dbInstance = Database::getInstance();
$db = $dbInstance->getConnection();
$sql = "SELECT * FROM categories";
$result = $db->query($sql);

//array for all categories
$allCategories = array();
//multidimensional array to hold a list of categories and parent category
$categoryMulti = array(
    'categories' => array(),
    'parent_cats' => array()
);

//build the array lists with data from the category table
while ($row = $result->fetch_assoc()) {
    //creates entry into categories array with current category id ie. $categories['categories'][1]
    $categoryMulti['categories'][$row['id']] = $row;
    //creates entry into parent_cats array. parent_cats array contains a list of all categories with children
    $categoryMulti['parent_cats'][$row['parentId']][] = $row['id'];
    $allCategories[] = $row;
}
//build final category tree and print html
function printCategoryTree($parent, $category)
{
    $html = "";
    if (isset($category['parent_cats'][$parent])) {
        $html .= "<ul>\n";
        foreach ($category['parent_cats'][$parent] as $cat_id) {
            if (!isset($category['parent_cats'][$cat_id])) {
                $html .= "<li>" . $category['categories'][$cat_id]['name'] . "</li>";
            } else {
                $html .= "<li>" . $category['categories'][$cat_id]['name'];
                $html .= printCategoryTree($cat_id, $category);
                $html .= "</li>";
            }
        }
        $html .= "</ul> \n";
    }
    return $html;
}

//print selectbox with all categories
function selectCategories($categories)
{
    foreach ($categories as $category) {
        echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/main.css">
    <title>Category Tree</title>
</head>
<body>
<button id="btnNew" onclick="showForm()">Nauja Kategorija</button>
<div id="formContainer" hidden>
    <form id="submitCategory" action="php/upload.php" method="post">
        <input type="text" name="categoryName" placeholder="Kategorijos Pavadinimas">
        <p class="formText">Ar tai pagrindinė Kategorija?</p>
            <select id="subCatValidator">
                <option value="true" selected="selected">Taip</option>
                <option value="false">Ne</option>
            </select>
        <div id="subCatSelectorContainer">
            <p class="formText">Pasirinkite prie kurios kategorijos pridėti</p>
            <select name="presentCategories">
                <option style="display:none;" value="default"></option>
                <?php selectCategories($allCategories) ?>
            </select>
        </div>
        <input id="submitButton" type="submit" value="Pridėti">
    </form>
</div>
<div id="categoriesContainer">
    <?php echo printCategoryTree(0, $categoryMulti);
    ?>
</div>
<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</body>
</html>
