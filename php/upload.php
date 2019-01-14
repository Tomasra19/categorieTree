<?php
include_once 'dbConfig.php';
//check if input category name is not null
if (!empty($_POST["categoryName"])) {

    //get db connection instance
    $dbInstance = Database::getInstance();
    $db = $dbInstance->getConnection();
    //set input to variable
    $categorieName = $_POST["categoryName"];

    //assign correct parentId if it is main category or sub category
    if ($_POST["presentCategories"] == "" || $_POST["presentCategories"] == "default") {
        $parentId = 0;
    } else {
        $parentId = $_POST["presentCategories"];
    }

    //insert category to db
    $stmt = $db->prepare("INSERT INTO categories (name, parentId) VALUES (?, ?)");
    $stmt->bind_param("si", $categorieName, $parentId);
    $stmt->execute();
    $stmt->close();
    $db->close();

    //html for successful insert
    echo '<p style="text-align: center; font-size: 20px; margin:auto;">Kategorija sėkmingai pridėta</p>';
    echo '<a href=../index.php style="margin:auto; text-align:center; display:block; text-decoration: none; color: dodgerblue; font-size: 20px">Grįžti atgal</a>';
} else {
    //if category name input null redirect to index page
    header("Location: /index.php");
}

?>


