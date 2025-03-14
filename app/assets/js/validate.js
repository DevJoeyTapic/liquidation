$('document').ready(function() {
    let baseUrl = 'https://agent.wallem.com.ph'
    let row;
    
    $('#confirmValidationA').on('click', function() {
        const checkedRows = $("#dataTableForValidationA .rowCheckbox:checked").closest("tr");
        if (checkedRows.length > 0) {
            Swal.fire({
                title: 'Submit Validation Item/s',
                text: 'Are you sure you want to validate the selected liquidation item/s?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Collect data for all selected rows
                    const itemsData = [];
                    checkedRows.each(function () {
                        const itemName = $(this).find("td:nth-child(1)").text();
                        const description = $(this).find("td:nth-child(2)").text();
                        const rfpNo = $(this).find("td:nth-child(3)").text();
                        const rfpAmount = $(this).find("td:nth-child(4)").text();
                        const actualAmount = $(this).find("td:nth-child(6) input").val();
                        const variance = $(this).find(".variance").text();
                        const remarks = $(this).find(".remarks").val();
                        const item_id = $(this).find('input[name="item_id"]').val();
    
                        itemsData.push({
                            itemName,
                            description,
                            rfpNo,
                            rfpAmount,
                            actualAmount,
                            variance,
                            remarks,
                            item_id
                        });
                    });
    
                    // AJAX request to submit all selected items
                    $.ajax({
                        url: baseUrl + '/agentvessel/acctg_validate_bulk',
                        method: 'POST',
                        data: { items: itemsData }, // Send data for all selected rows
                        success: function(response) {
                            Swal.fire({
                                title: 'Validation Successful!',
                                text: 'Selected items have been validated.',
                                icon: 'success'
                            }).then(() => {
                                location.reload(); // Reload page after successful submission
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error submitting the validation.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        } 
        else {
            Swal.fire({
                title: 'No Items Selected!',
                text: 'Please select at least one item to submit for accounting.',
                icon: 'info'
            });
        }
    });
})
