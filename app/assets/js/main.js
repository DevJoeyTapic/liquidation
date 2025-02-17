$(document).ready(function () {
  let baseUrl = 'http://192.168.192.251:3000'

  let row;
  $('#submitLiquidation').on('click', function(event) {
    event.preventDefault();
    
    // Confirmation Swal for submitting the liquidation
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

  $('#confirmValidationA').on('click', function() {
    alert('confirmValidationA');
  });

  function updateTotal() {
    let total = 0;
    $(".new-amount").each(function () {
      const value = parseFloat($(this).val()) || 0;
      total += value;
    });
    $("#totalAmount").text(total.toFixed(2));
    return total;
    
  }
  function updateTotal() {
    let total = 0;
    $(".new-amount").each(function () {
      const value = parseFloat($(this).val()) || 0;
      total += value;
    });
    $("#totalAmount").text(total.toFixed(2));
    return total;
    
  }
  $(document).on("input", ".new-amount", function () {
    updateTotal();
  });

  $('#submitBtn').on('click', function () {
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
    
    if(row) {
      const expectedAmount = parseFloat(row.find(".rfpAmount").text().replace(/[^0-9.-]+/g, ""));
      const total = updateTotal(); // Ensure total is updated before using it
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
            rfp_amount: expectedAmount ,
            variance: variance
          },
          success: function(response) {
            console.log(response);
            location.reload();
          },
          error: function(error) {
            console.error("Error occurred while submitting:", error);
          } 
        });
      });
    }
    else {
      Swal.fire({
        title: 'Error',
        text: 'No active row found',
        icon: 'error'
      });
    }
  });

  $(".add").on("click", function () {

    const lastDescription = $(".addedFields .description").last();
    const lastAmount = $(".addedFields .new-amount").last();
    const variance = parseFloat($(".variance").text().replace(/,/g, ''));

    if (!lastDescription.length || (lastDescription.val() && lastAmount.val())) {
      const newInput = $(`
        <div class="row d-flex justify-content-center align-items-center m-0 mt-2">
        <div class="col">
          <input type="text" class="form-control description" placeholder="Description">
        </div>
        <div class="col ps-0">
          <div class="input-group ps-0">
          <input type="text" class="form-control new-amount" placeholder="Enter Actual Amount">
          <button class="btn btn-danger delete-btn" type="button"><i class="fa-solid fa-trash fa-xs"></i></button>
          </div>
        </div>
        </div>
      `);

      newInput.find(".delete-btn").on("click", function () {
        newInput.remove();
        updateTotal();
      });

      $(".addedFields").append(newInput);
    } else {
      Swal.fire({
        title: 'Error',
        text: 'Please fill in all existing fields before adding new ones.',
        icon: 'warning',
        confirmButtonText: 'OK'
      });
    }
  });

  
  

  $(document).ready(function($) {
    $(document).on("input", "#actualAmount", function () {
      const rfpAmount = parseFloat(
        $(this).closest("tr").find(".rfpAmount").text().replace(/,/g, '') 
      );
      const actualAmount = parseFloat($(this).val()) || 0; 
      const variance = rfpAmount - actualAmount;

      $(this).closest("tr").find(".variance").text(variance.toFixed(2)); 
    
      const checkbox = $(this).closest("tr").find(".rowCheckbox");
    
      if (actualAmount) {
        checkbox.prop("checked", true); 
        checkbox.prop("disabled", false); 
        $("#submitLiquidation").removeClass("disabled").prop("disabled", false);
      } else {
        checkbox.prop("checked", false); 
        checkbox.prop("disabled", true); 
        $("#submitLiquidation").addClass("disabled").prop("disabled", true);
        // $(this).closest("tr").find(".variance").text("0.00"); 
      }
    });

    $(document).on('blur', '#actualAmount', function() {
      const rfpAmount = parseFloat(
        $(this).closest("tr").find(".rfpAmount").text().replace(/,/g, '') 
      );
      const variance = parseFloat(
        $(this).closest("tr").find(".variance").text().replace(/,/g, '') 
      );
      const item_id = $(this).closest("tr").find("input[name='item_id']").val();
      if (variance !== rfpAmount) {
        Swal.fire({
          title: 'Variance Remarks',
          input: 'text',
          inputLabel: 'Please provide a valid reason for variance.',
          inputPlaceholder: 'Type your remarks here...',
          showCancelButton: true,
          confirmButtonText: 'Submit',
          cancelButtonText: 'Cancel',
          showLoaderOnConfirm: true,
          preConfirm: (remarks) => {
              if (!remarks || remarks.trim() === '') {
                  Swal.showValidationMessage('Remarks are required.');
                  return false; 
              }
              return remarks;
          }
      }).then((result) => {
          if (result.isConfirmed) {
            const remarks = result.value;

            const tableBody = $('#remarksTable tbody');
            const newRow = $('<tr></tr>');

            const remarksCell = $('<td></td>');
            remarksCell.append('<p>' + remarks + '</p>');
            const fullname = $('#fullname').val(); 
            remarksCell.append('<p class="small">' + fullname + '</p>');
            const timestamp = new Date(new Date().getTime() + 8 * 60 * 60 * 1000).toISOString().slice(0, 19).replace('T', ' ');
            remarksCell.append('<p class="small" id="timestamp">' + timestamp + '</p>');

            newRow.append(remarksCell);

            tableBody.append(newRow);

            // AJAX call to add_item_remarks
            $.ajax({
                url: baseUrl + '/vesselitem/add_item_remark',
                method: 'POST',
                data: {
                    item_id: item_id, // Assuming item_id is available in this scope
                    remarks: remarks,
                    author: fullname,
                    timestamp: timestamp
                },
                success: function(response) {
                    Swal.fire('Remarks submitted', remarks, 'success');
                },
                error: function() {
                    Swal.fire('Error', 'Failed to submit remarks. Please try again.', 'error');
                }
            });
          }
        });
      }
    });
  });
  $('.multiple-btn').on('click', function() {
    row = $(this).closest("tr");
    const item_id = $(this).data('item');
    const itemName = row.find("td:first").text().replace('Controlled', '');
    const rfpNo = row.find("td:nth-child(3)").text();
    const rfpAmt = Number(row.find("td:nth-child(4)").text().replace(/,/g, '')).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    
    $("#itemName").text(itemName);
    $("#rfpNo").text(rfpNo);
    $("#rfpAmt").text(rfpAmt);

    const total = updateTotal();
    $("#actualAmountInput").val(total.toFixed(2));

    // Retain the data input previously
    const remarks = $("#newRemarkInput").val();
    const author = $("#fullname").val();
    const timestamp = new Date(new Date().getTime() + 8 * 60 * 60 * 1000).toISOString().slice(0, 19).replace('T', ' ');
  });

  $(document).on('click', '#showItemRemarks', function() {
    const item_id = $(this).data('item');
    const itemName = $(this).closest('tr').find('td:first').text().replace('Controlled', '').trim();
    document.getElementById('addRemarkBtn').setAttribute('data-item', item_id);
    $('#showItemRemarksModalLabel').text(itemName);
    $.ajax({
        url: baseUrl + '/vesselitem/get_item_remarks/' + item_id,
        method: 'GET',
        success: function(response) {
          const remarks = JSON.parse(response);
          const remarksTableBody = $('#remarksTable tbody');
          remarksTableBody.empty();

          if (Array.isArray(remarks)) {
              let remarksHtml = '';
              remarks.forEach(remark => {
                  const remarkText = remark.remarks || 'No text available'; 
                  const author = remark.author || 'Unknown author'; 
                  const timestamp = remark.timestamp || 'No timestamp';

                  remarksHtml += `<tr>
                                    <td>
                                      <p>${remarkText}</p>
                                      <p class="small">${author}</p>
                                      <p class="small">${timestamp}</p>
                                    </td>
                                  </tr>`;
              });
              remarksTableBody.html(remarksHtml);

          } else {
              remarksTableBody.html('<tr><td colspan="3">No remarks available.</td></tr>'); // Handle undefined or non-array remarks
        }
        }
    });
  });

  $("#addRemarkBtn").on('click', function() {
    const item_id = $(this).data('item');
    const remarks = $("#newRemarkInput").val();
    const author = $("#fullname").val();
    const timestamp = new Date(new Date().getTime() + 8 * 60 * 60 * 1000).toISOString().slice(0, 19).replace('T', ' ');
    
    console.log({
      item_id: item_id,
      remarks: remarks,
      author: author,
      timestamp: timestamp
    }); 

    if (!remarks || remarks.trim() === '') {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Please enter a remark before submitting'
      });
      return;
    }

    $.ajax({
      url: baseUrl + '/vesselitem/add_item_remark', 
      method: 'POST',
      data: {
        item_id: item_id,
        remarks: remarks,
        author: author,
        timestamp: timestamp
      },
      success: function(response) {
        console.log(response);
        const remarksTableBody = $('#remarksTable tbody');
        
        remarksTableBody.find('tr td[colspan="3"]').parent().remove();
        
        const newRow = `<tr>
                         <td>
                           <p>${remarks}</p>
                           <p class="small">${author}</p>
                           <p class="small">${timestamp}</p>
                         </td>
                       </tr>`;
        remarksTableBody.append(newRow);

        // Clear the input field
        $("#newRemarkInput").val('');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error:', textStatus, errorThrown);
      }
    });
  });

  
  $("#addItem").on("click", function () {

    const newItem = $("#newItem").val();
    const newRemarks = $("#newRemarks").val();
    const newAmount = $("#newAmount").val();
    const user_id = $('input[name="user_id"]').val();
    const supplier = $('input[name="supplier"]').val();
    const transno = $('input[name="transno"]').val();
    const isNew = $('input[name="isNew"]').val();
  
    $.ajax({
      url: baseUrl + '/vesselitem/add_item',
      method: 'POST',
      data: {
        newItem: newItem,
        newRemarks: newRemarks,
        newAmount: newAmount,
        user_id: user_id,
        supplier: supplier,
        transno: transno,
        isNew: isNew
      },
      success: function (response) {
        const data = JSON.parse(response);
  
        if (data.status === 'success') {
          const newItemRow = `
            <tr>
              <td>${newItem}</td>
              <td></td>
              <td class="text-center"><span class="badge text-bg-primary">NEW ITEM</span></td>
              <td><span class="badge text-bg-primary">NEW ITEM</span></td>
              <td class="text-end">
                <input type="text" class="form-control form-control-sm actualAmount" value="${newAmount}" disabled>
              </td>
              <td><span class="badge text-bg-primary">NEW ITEM</span></td>
              <td><textarea class="form-control form-control-sm remarks" rows="1" style="max-height: 150px" disabled>${newRemarks}</textarea></td>
              <td class="text-center"><input type="file" class="form-control form-control-sm" multiple></td>
              <td class="text-center"><input type="checkbox" class="form-check-input rowCheckbox">
                <input type="hidden" name="user_id" value="${user_id}">
                <input type="hidden" name="supplier" value="${supplier}">
                <input type="hidden" name="transno" value="${transno}">
                <input type="hidden" name="isNew" value="${isNew}">
              </td>
            </tr>`;const rfpAmount = parseFloat(
      $(this).closest("tr").find(".rfpAmount").text().replace(/,/g, '') 
    );
  
          $("#dataTable2 tbody").append(newItemRow);
  
          // Clear input fields after adding item
          $("#newItem").val('');
          $("#newRemarks").val('');
          $("#newAmount").val('');
        } else {
          alert(data.message);
        }
      },
      error: function () {
        alert('Error occurred while adding item');
      }
    });
  });

  $(document).on("click", "#updateUserBtn", function () {
    var user_id = $(this).closest('tr').find('input[name="user_id"]').val();
    var status = $(this).closest('tr').find('input[name="status"]').val();
    var username = $(this).closest('tr').find('td.username').text();
    var email = $(this).closest('tr').find('td.email').text();
    var fullname = $(this).closest('tr').find('td.fullname').text();
    var user_type = $(this).closest('tr').find('td.user_type').text();
    $('#user_id').val(user_id);
    $('#usernametxt').val(username);
    $('#emailtxt').val(email);
    $('#fullnametxt').val(fullname);
    switch (user_type) {
      case 'Admin':
        $('select option[value="1"]').attr('selected', 'selected');
      break;
      case 'Agent':
        $('select option[value="2"]').attr('selected', 'selected');
      break;
      case 'Accounting':
        $('select option[value="3"]').attr('selected', 'selected');
      break;
      case 'TAD':
        $('select option[value="4"]').attr('selected', 'selected');
      break;
      default:
        $('select option[value="0"]').attr('selected', 'selected');
    }
    
    if(status == 1) {
      $('#status').prop('checked', true);
    } else {
      $('#status').prop('checked', false);
    }
  });
  $('#showItemRemarksModal').on('shown.bs.modal', function () {
    $('#newRemarkInput').focus();
    var modalBody = document.getElementById('modal-body');
    modalBody.scrollTop = modalBody.scrollHeight;
  });


});
// Ensure no conflicting scripts are causing redirection issues
document.addEventListener('DOMContentLoaded', function() {
  let allFiles = [];
  let currentPreviewFile = null;

    $(document).ready(function() {
        $('#uploadButton').click(() => new bootstrap.Modal(document.getElementById('uploadModal')).show());
        $('#chooseFilesButton').click(() => $('#fileUpload').click());

        $('#fileUpload').change(function() {
            handleFiles($(this)[0].files);
        });

        $('#dropZone').on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        }).on('dragleave', function() {
            $(this).removeClass('dragover');
        }).on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
            handleFiles(e.originalEvent.dataTransfer.files);
        });
    });

    function handleFiles(files) {
        for (let file of files) {
            if (!allFiles.some(existingFile => existingFile.name === file.name)) {
                allFiles.push(file);
                addFileToList(file);
            }
        }
    }

    function addFileToList(file) {
        const listItem = $('<li class="list-group-item d-flex justify-content-between align-items-center">')
            .text(file.name)
            .on('click', function() {
                togglePreview(file);
            });

        const removeButton = $('<button class="btn btn-sm btn-danger">')
            .html('<i class="fa fa-trash"></i>')
            .on('click', function(e) {
                e.stopPropagation();
                removeFile(file);
            });

        listItem.append(removeButton);
        $('#fileNamesList').append(listItem);
    }

    function showPreview(file) {
        const filePreview = $('#filePreview').empty();
        if (file.type.startsWith('image')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                filePreview.append($('<img>').attr('src', event.target.result));
            };
            reader.readAsDataURL(file);
        } else {
            filePreview.html('<p><strong>Preview not available for this file type.</strong></p>');
        }
    }

    function togglePreview(file) {
        if (currentPreviewFile === file) {
            $('#filePreview').empty();
            currentPreviewFile = null;
        } else {
            showPreview(file);
            currentPreviewFile = file;
        }
    }

    function removeFile(fileToRemove) {
        allFiles = allFiles.filter(file => file.name !== fileToRemove.name);

        $('#fileNamesList li').each(function() {
            if ($(this).text().includes(fileToRemove.name)) {
                $(this).remove();
            }
        });

        if (currentPreviewFile === fileToRemove) {
            $('#filePreview').empty();
            currentPreviewFile = null;
        }
    }


  $('#validateAll').on('change', function() {
    if ($(this).is(':checked')) {
      $('.form-check-input').each(function() {
        $(this).prop('checked', true);
      });
    } else {
      $('.form-check-input').each(function() {
        $(this).prop('checked', false);
      });
    }
  });

  $('#markComplete').on('click', function(event) {
    event.preventDefault(); 

    Swal.fire({
        title: 'Archive Confirmation',
        text: 'Are you sure you want to archive this item? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, archive it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Liquidation Complete!",
                icon: "success"
            }).then(() => {
                window.location.href = "<?= site_url('vesselitem/archive/' . $id); ?>";
            });
        }
    });
  });
})