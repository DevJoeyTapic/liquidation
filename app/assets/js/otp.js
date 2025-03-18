$('document').ready(function() {
    let baseUrl = 'http://192.168.192.251:3000'
    $('.rowCheckbox').on('change', function() {
        const checkedRows = $("#dataTableForValidationT .rowCheckbox:checked").closest("tr");
    });
});
