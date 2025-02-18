$('document').ready(function() {
    let baseUrl = 'http://192.168.192.251:3000'
    let row;
    
    $('#submitLiquidation').on('click', function() {
        
        Swal.fire({
            title: 'Submit Liquidation Item/s',
            text: 'Are you sure you want to submit item/s for liquidation?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Item/s Submitted!",
                    icon: "success"
                }).then(() => {
                    const checkedRows = $("#dataTable2 .rowCheckbox:checked").closest("tr");
    
                    let dataToSubmit = [];
                    
                    if (checkedRows.length > 0) {
                        checkedRows.each(function () {
                            const actualAmount = $(this).find("td:nth-child(5) input").val();
                            const variance = $(this).find(".variance").text();
                            const item_id = $(this).find("input[name='item_id']").val();
                            
                            dataToSubmit.push({
                                actualAmount: actualAmount,
                                variance: variance,
                                item_id: item_id
                            });
                        });
    
                        $.ajax({
                            url: baseUrl + '/vesselitem/submit_for_validation',
                            method: 'POST',
                            data: {
                                items: dataToSubmit // Sending all items in a single request
                            },
                            success: function(response) {
                                console.log(response);
                                location.reload();
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: 'Submission Error',
                                    text: 'An error occurred while submitting the items. Please try again later.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
    
                    // Check for empty fields before running the AJAX in the submitBtn logic
                    let hasEmptyFields = false;
                    $('.addedFields .description, .addedFields .new-amount').each(function() {
                        if (!$(this).val().trim()) {
                            hasEmptyFields = true;
                            return false; 
                        }
                    });
    
                    if (hasEmptyFields) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Please fill in all fields before submitting',
                            icon: 'error'
                        }).then(() => {
                            $('#multipleEntryModal').modal('show');
                        });
                        return;
                    }
    
                    const total = updateTotal();
                    
                    if (row) {
                        const expectedAmount = parseFloat(row.find(".rfpAmount").text().replace(/[^0-9.-]+/g, ""));
                        row.find(".actualAmount").val(total.toFixed(2));
                        const variance = expectedAmount - total;
                        row.find(".variance").text(variance.toFixed(2));
                        
                        $('.addedFields .row').each(function() {
                            const item_id = row.find('input[name="item_id"]').val();
                            const rfp_no = row.find('.rfpno').text().trim();
                            const currency = row.find('.currency').text().trim();
                            const expectedAmount = parseFloat(row.find(".rfpAmount").text().replace(/[^0-9.-]+/g, ""));
                            const description = $(this).find('.description').val();
                            const amount = $(this).find('.new-amount').val();
    
                            $.ajax({
                                url: baseUrl + '/breakdowncost/add_breakdown_cost',
                                method: 'POST',
                                data: {
                                    item_id: item_id,
                                    description: description,
                                    amount: amount,
                                    rfp_no: rfp_no,
                                    currency: currency,
                                    rfp_amount: expectedAmount,
                                    variance: variance
                                },
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(error) {
                                    console.error("Error occurred while submitting:", error);
                                }
                            });
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'No active row found',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
