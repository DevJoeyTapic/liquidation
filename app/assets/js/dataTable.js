$(document).ready(function () {
  // Initialize DataTable for #dataTable1
  var table1 = $("#dataTable1").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });
  
  // Custom search functionality for #dataTable1
  $(".dataTables_filter").addClass("d-none");
  $("#dataSearch").on("keyup", function () {
    table1.search(this.value).draw();
  });

  // Initialize DataTable for #dataTable2
  var table2 = $("#dataTable2").DataTable({
    paging: true,
    searching: true,
    pageLength: 10,
  });

  // Initialize DataTable for #dataTable3
  var table3 = $("#dataTable3").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });

  // Initialize DataTable for #dataTable4
  var table4 = $("#dataTable4").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });

  // Initialize DataTable for #dataTable5
  var table5 = $("#dataTable5").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });

  // Custom search functionality for #dataTable5
  $(".dataTables_filter").addClass("d-none");
  $("#dataSearch").on("keyup", function () {
    table5.search(this.value).draw();
  });
});
