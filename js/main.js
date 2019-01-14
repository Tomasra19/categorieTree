//function for add new category button
function showForm() {
    $("#btnNew").hide();
    $("#formContainer").show();
}

//Code for choosing parent Category
$('#subCatSelectorContainer').hide();

$('#subCatValidator').change(function () {
    if ($('#subCatValidator').val() == "false") {
        $('#subCatSelectorContainer').show();
    } else {
        $('#subCatSelectorContainer').hide();
    }
});

//New category form submit validation
$('#submitCategory').submit(function () {
    if ($('input[name=categoryName]').val() === "") {
        alert("Kažką pamiršote?! Įveskite naujos kategorijos pavadinimą");
    }
    if ($('#subCatSelectorContainer').is(':hidden')) {
        $('select[name=presentCategories] option[value="default"]').attr("selected", true);
    }
});



