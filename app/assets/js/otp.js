$('document').ready(function() {
    let baseUrl = 'http://localhost:3000'
    $('.rowCheckbox').on('change', function() {
        const checkedRows = $("#dataTableForValidationT .rowCheckbox:checked").closest("tr");
    });
});
