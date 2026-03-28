$(document).ready(function () {
    $("#ExpenseTable").DataTable({
        responsive: true,
        autoWidth: true,
        pageLength: 10,
        scrollX: true,
        scrollY: "350px",
    });

    $(".select2").select2({
        dropdownParent: $("#modalAddTransaction"),
        placeholder: "Choose!",
    });
});
