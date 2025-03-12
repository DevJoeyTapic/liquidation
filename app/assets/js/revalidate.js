$('document').ready(function() {
    let baseUrl = 'http://agents.wallem.com.ph'
    let row;
    
    $('#revalidateAllBtn').on('click', function() {
        $('.form-check-input').each(function() {
            $(this).prop('checked', !$(this).prop('checked'));
        });
    });
    // $('#amendBtn').on('click', function() {
    //     const checkedRows = $("#dataTableForValidationA .rowCheckbox:checked").closest("tr");
    //     if (checkedRows.length > 0) {
    //         Swal.fire({
    //             title: 'Amend Item/s',
    //             text: 'Are you sure you want to submit the selected liquidation item/s for amendment?',
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonText: 'Yes',
    //             cancelButtonText: 'Cancel'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 // Collect data for all selected rows
    //                 const itemsData = [];
    //                 checkedRows.each(function () {
    //                     const agent = $(this).find("td:nth-child(1)").text();
    //                     const itemName = $(this).find("td:nth-child(2)").text();
    //                     const description = $(this).find("td:nth-child(3)").text();
    //                     const rfpNo = $(this).find("td:nth-child(4)").text();
    //                     const rfpAmount = $(this).find("td:nth-child(5)").text();
    //                     const actualAmount = $(this).find("td:nth-child(6)").text();
    //                     const variance = $(this).find("td:nth-child(7)").text();
    //                     const item_id = $(this).find('input[name="item_id"]').val();
    
    //                     itemsData.push({
    //                         agent,
    //                         itemName,
    //                         description,
    //                         rfpNo,
    //                         rfpAmount,
    //                         actualAmount,
    //                         variance,
    //                         item_id
    //                     });
    //                 });
    
    //                 // AJAX request to submit all selected items
    //                 $.ajax({
    //                     url: baseUrl + '/revalidate/submit_for_revalidation',
    //                     method: 'POST',
    //                     data: { items: itemsData }, // Send data for all selected rows
    //                     success: function(response) {
    //                         Swal.fire({
    //                             title: 'Revalidation Successful!',
    //                             text: 'Selected items have been revalidated.',
    //                             icon: 'success'
    //                         }).then(() => {
    //                             location.reload(); // Reload page after successful submission
    //                         });
    //                     },
    //                     error: function() {
    //                         Swal.fire({
    //                             title: 'Error!',
    //                             text: 'There was an error submitting the revalidation.',
    //                             icon: 'error'
    //                         });
    //                     }
    //                 });
    //             }
    //         });
    //     } 
    //     else {
    //         Swal.fire({
    //             title: 'No Items Selected!',
    //             text: 'Please select at least one item to submit for revalidation.',
    //             icon: 'info'
    //         });
    //     }
    // });

    $('#revalidateBtn').on('click', function() {
        const checkedRows = $("#dataForRevalidation .rowCheckbox:checked").closest("tr");
        if (checkedRows.length > 0) {
            Swal.fire({
                title: 'Revalidate Item/s',
                text: 'Are you sure you want to revalidate the selected liquidation item/s?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Collect data for all selected rows
                    const itemsData = [];
                    checkedRows.each(function () {
                        const agent = $(this).find("td:nth-child(1)").text();
                        const itemName = $(this).find("td:nth-child(2)").text();
                        const description = $(this).find("td:nth-child(3)").text();
                        const rfpNo = $(this).find("td:nth-child(4)").text();
                        const rfpAmount = $(this).find("td:nth-child(5)").text();
                        const actualAmount = $(this).find("td:nth-child(6)").text();
                        const variance = $(this).find("td:nth-child(7)").text();
                        const item_id = $(this).find('input[name="item_id"]').val();
    
                        itemsData.push({
                            agent,
                            itemName,
                            description,
                            rfpNo,
                            rfpAmount,
                            actualAmount,
                            variance,
                            item_id
                        });
                    });
    
                    // AJAX request to submit all selected items
                    $.ajax({
                        url: baseUrl + '/revalidate/submit_for_revalidation',
                        method: 'POST',
                        data: { items: itemsData }, // Send data for all selected rows
                        success: function(response) {
                            Swal.fire({
                                title: 'Revalidation Successful!',
                                text: 'Selected items have been revalidated.',
                                icon: 'success'
                            }).then(() => {
                                location.reload(); // Reload page after successful submission
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error submitting the revalidation.',
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
                text: 'Please select at least one item to submit for revalidation.',
                icon: 'info'
            });
        }
    });
});
