$(document).ready(function () {
  var table = $("#dataTable1").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });

  $(".dataTables_filter").addClass("d-none");
  $("#dataSearch").on("keyup", function () {
    table.search(this.value).draw();
  });
});

$(document).ready(function () {
  var table = $("#dataTable2").DataTable({
    paging: true,
    searching: true,
    pageLength: 10,
  });
});

$(document).ready(function () {
  var table = $("#dataTable3").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });
});

$(document).ready(function () {
  var table = $("#dataTable4").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });
});

$(document).ready(function () {
  var table = $("#dataTable5").DataTable({
    paging: true,
    searching: true,
    pageLength: 5,
  });
  $(".dataTables_filter").addClass("d-none");
  $("#dataSearch").on("keyup", function () {
    table.search(this.value).draw();
  });
});
