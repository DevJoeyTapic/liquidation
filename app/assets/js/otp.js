$('document').ready(function() {
    let baseUrl = 'https://agents.wallem.com.ph'
    $('.rowCheckbox').on('change', function() {
        const checkedRows = $("#dataTableForValidationT .rowCheckbox:checked").closest("tr");
    });
});
