<?php
include_once 'dbConfig.php';
if (!empty($_POST["categoryName"])) {

    $dbInstance = Database::getInstance();
    $db = $dbInstance->getConnection();

    $categorieName = $_POST["categoryName"];

    if ($_POST["presentCategories"] == "" || $_POST["presentCategories"] == "default") {
        $parentId = 0;
    } else {
        $parentId = $_POST["presentCategories"];
    }


    $stmt = $db->prepare("INSERT INTO categories (name, parentId) VALUES (?, ?)");
    $stmt->bind_param("si", $categorieName, $parentId);
    $stmt->execute();
    $stmt->close();
    $db->close();


    echo '<p style="text-align: center; font-size: 20px; margin:auto;">Kategorija sėkmingai pridėta</p>';
    echo '<a href=../index.php style="margin:auto; text-align:center; display:block; text-decoration: none; color: dodgerblue; font-size: 20px">Grįžti atgal</a>';
} else {
    header("Location: /index.php");
}

?>


