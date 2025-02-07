$(document).ready(function () {
  let baseUrl = 'http://192.168.192.251:3000'

  let row;
  $('#submitLiquidation').on('click', function(event) {
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
                location.reload();
                const checkedRows = $("#dataTable2 .rowCheckbox:checked").closest("tr");
                
                let dataToSubmit = [];
                
                if (checkedRows.length > 0) {
                    checkedRows.each(function () {
                        const actualAmount = $(this).find("td:nth-child(5) input").val();
                        const variance = $(this).find(".variance").text();
                        const remarks = $(this).find(".remarks").val();
                        const item_id = $(this).find("input[name='item_id']").val();
                        
                        dataToSubmit.push({
                            actualAmount: actualAmount,
                            variance: variance,
                            remarks: remarks,
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
                            location.reload();
                            console.log(response);
                        },
                        error: function(error) {
                            console.error("Error occurred while submitting:", error);
                        }
                    });
                }
            });
        }
    });
});


$('#confirmValidationV').on('click', function() {
  const checkedRows = $("#dataTable6 .rowCheckbox:checked").closest("tr");
  
  if (checkedRows.length > 0) {
      // Show confirmation dialog first
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
              checkedRows.each(function() {
                  const itemName = $(this).find("td:nth-child(1)").text();
                  const description = $(this).find("td:nth-child(2)").text();
                  const rfpNo = $(this).find("td:nth-child(3)").text();
                  const rfpAmount = $(this).find("td:nth-child(4)").text();
                  const actualAmount = $(this).find("td:nth-child(5) input").val();
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
                  url: baseUrl + '/agentvessel/voo_om_validate_bulk',
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
  } else {
      Swal.fire({
          title: 'No Items Selected!',
          text: 'Please select at least one item to submit for validation.',
          icon: 'info'
      });
  }
});


$('#confirmValidationA').on('click', function() {
  const checkedRows = $("#dataTable9 .rowCheckbox:checked").closest("tr");
  
  if (checkedRows.length > 0) {
      // Show confirmation dialog first
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
                  const actualAmount = $(this).find("td:nth-child(5) input").val();
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
  } else {
      Swal.fire({
          title: 'No Items Selected!',
          text: 'Please select at least one item to submit for accounting.',
          icon: 'info'
      });
  }
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
  $("#submitBtn").on("click", function () {
    const total = updateTotal(); // Store total for later use
    // $(".actualAmount").val(total.toFixed(2));

    if (row) {
      row.find(".actualAmount").val(total.toFixed(2));
      const expectedAmount = parseFloat(
        row
          .find(".rfpAmount")
          .text()
          .replace(/[^0-9.-]+/g, "")
      );
      const variance = expectedAmount - total;
      row.find(".variance").text(variance.toFixed(2)); // Update variance in the row
    } else {
      console.log("no active row found");
    }
  });

  $(document).ready(function($) {
    $(".variance").each(function() {
      $(this).text("0.00");
    });

    $(document).on("input", "#actualAmount", function () {
      const rfpAmount = parseFloat(
        $(this).closest("tr").find(".rfpAmount").text().replace(/,/g, '') 
      );
      const actualAmount = parseFloat($(this).val()) || 0; 
      const variance = rfpAmount - actualAmount;
      const formattedVariance = variance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

      $(this).closest("tr").find(".variance").text(formattedVariance); 
    
      const checkbox = $(this).closest("tr").find(".rowCheckbox");
    
      if (actualAmount) {
        checkbox.prop("checked", true); 
        checkbox.prop("disabled", false); 
        $("#submitLiquidation").removeClass("disabled").prop("disabled", false);
      } else {
        checkbox.prop("checked", false); 
        checkbox.prop("disabled", true); 
        $("#submitLiquidation").addClass("disabled").prop("disabled", true);
        $(this).closest("tr").find(".variance").text("0.00"); 
      }
    });

    $(document).on('blur', '#actualAmount', function() {
      const variance = parseFloat(
        $(this).closest("tr").find(".variance").text().replace(/,/g, '') 
      );
      if (variance !== 0.00) {
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
            const timestamp = new Date().toISOString().slice(0, 19).replace('T', ' ');
            remarksCell.append('<p class="small" id="timestamp">' + timestamp + '</p>');
        
            newRow.append(remarksCell);
        
            tableBody.append(newRow);
        
            Swal.fire('Remarks submitted', remarks, 'success');
          }
        });
      }
    });
  });

  $(".add").on("click", function () {
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
  });

  $(".multiple-btn").on("click", function () {
    row = $(this).closest("tr");
    $(".addedFields").empty();
    const itemName = row.find("td:first").text();
    const rfpNo = row.find("td:nth-child(3)").text();
    const rfpAmt = parseFloat(
      row
        .find("td:nth-child(5)")
        .text()
        .replace(/[^0-9.-]+/g, "")
    );

    $("#itemName").text(itemName);
    $("#rfpNo").text(rfpNo);
    $("#rfpAmt").text(rfpAmt.toFixed(2));

    const total = updateTotal(); // Get the total from new amounts
    $("#actualAmountInput").val(total.toFixed(2)); // Set the total in the actual amount input
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
})
