$(document).ready(function () {
  $('#forValidationBtn').on('click', function() {
  alert('This is for validation');
  });
  let row;
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
  $("#removeBtn").on("click", function () {
    const checkedRows = $("#dataTable3 .rowCheckbox:checked").closest("tr");
    if (checkedRows.length > 0) {
      checkedRows.each(function () {
        const itemName = $(this).find("td:nth-child(1)").text();
        const description = $(this).find("td:nth-child(2)").text();
        const rfpNo = $(this).find("td:nth-child(3)").text();
        const rfpAmount = $(this).find("td:nth-child(4)").text();
        const actualAmount = $(this).find("td:nth-child(5) input").val();
        const variance = $(this).find(".variance").text();
        const remarks = $(this).find(".remarks").val();
        const docref = $(this).find("td:nth-child(7)").text().trim() || "NONE";
        const displayDocRef = docref === "NONE" ? docref : "attachment.pdf";

        const newRow = `<tr>
                            <td>${itemName}</td>
                            <td>${description}</td>
                            <td class="text-center">${rfpNo}</td>
                            <td>${rfpAmount}</td>
                            <td>
                              <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" value="${actualAmount}">
                              <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal">Multiple Entry</button>
                            </td>
                            <td>${variance}</td>
                            <td ><textarea class="form-control form-control-sm remarks" rows="1" style="max-height: 150px" value="${remarks}"></textarea></td>
                            <td class="text-center"><input type="file" class="form-control form-control-sm" multiple></td>
                            <td class="text-center"><input type="checkbox" class="form-check-input rowCheckbox"></td>
                          </tr>`;

        $("#dataTable2 tbody").append(newRow);
      });

      checkedRows.remove();
    }
  });


  // function toggleSubmit() {
  //   const rfpAmountElement = $(this).closest("tr").find("#rfpAmount");
  //   const rfpAmount = rfpAmountElement.length ? parseFloat(rfpAmountElement.text()) : 0;
  //   if (anyChecked) {
  //     $("#submitLiquidation").removeClass("disabled").prop("disabled", false);
  //   } else {
  //     $("#submitLiquidation").addClass("disabled").prop("disabled", true);
  //   }
  // }

  $(document).on("input", "#actualAmount", function () {
    // Use closest to target the rfpAmount in the same row
    const rfpAmount = parseFloat(
      $(this).closest("tr").find(".rfpAmount").text().replace(/,/g, '') // Remove commas for float conversion
    );
    const actualAmount = parseFloat($(this).val()) || 0;
    const variance = rfpAmount - actualAmount;

    $(this).closest("tr").find(".variance").text(variance.toFixed(2));

    const checkbox = $(this).closest("tr").find(".rowCheckbox");

    if (actualAmount) {
      checkbox.prop("checked", true); // Check the checkbox if there is input
      checkbox.prop("disabled", false); // Enable the checkbox
      $("#submitLiquidation").removeClass("disabled").prop("disabled", false);
    } else {
      checkbox.prop("checked", false); // Uncheck the checkbox if input is empty
      checkbox.prop("disabled", true); // Disable the checkbox
      $("#submitLiquidation").addClass("disabled").prop("disabled", true);
    }
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
        .find("td:nth-child(4)")
        .text()
        .replace(/[^0-9.-]+/g, "")
    );

    $("#itemName").text(itemName);
    $("#rfpNo").text(rfpNo);
    $("#rfpAmt").text(rfpAmt.toFixed(2));

    const total = updateTotal(); // Get the total from new amounts
    $("#actualAmountInput").val(total.toFixed(2)); // Set the total in the actual amount input
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

  $(".rowCheckbox").change(function () {
  });
  // function toggleSubmit() {
  //   let anyChecked = $(".rowCheckbox:checked").length > 0;

  //   // Toggle the button state based on the checkbox status
  //   if (anyChecked) {
  //     $("#submitLiquidation").removeClass("disabled").prop("disabled", false);
  //   } else {
  //     $("#submitLiquidation").addClass("disabled").prop("disabled", true);
  //   }
  // }

  $("#submitLiquidation").on("click", function () {
    const checkedRows = $("#dataTable2 .rowCheckbox:checked").closest("tr");
    if (checkedRows.length > 0) {
      checkedRows.each(function () {
        const itemName = $(this).find("td:nth-child(1)").text();
        const description = $(this).find("td:nth-child(2)").text();
        const rfpNo = $(this).find("td:nth-child(3)").text();
        const rfpAmount = $(this).find("td:nth-child(4)").text();
        const actualAmount = $(this).find("td:nth-child(5) input").val();
        const variance = $(this).find(".variance").text();
        const remarks = $(this).find(".remarks").val();
        const docref = $(this).find("td:nth-child(7)").text().trim() || "NONE";
        const displayDocRef = docref === "NONE" ? docref : "attachment.pdf";

        const newRow = `<tr>
                            <td>${itemName}</td>
                            <td>${description}</td>
                            <td class="text-center">${rfpNo}</td>
                            <td>${rfpAmount}</td>
                            <td>${actualAmount}</td>
                            <td>${variance}</td>
                            <td >${remarks}</td>
                            <td class="text-center">${displayDocRef}</td>
                            <td class="text-center"><input type="checkbox" class="form-check-input rowCheckbox"></td>
                          </tr>`;

        $("#dataTable3 tbody").append(newRow);
      });

      checkedRows.remove();
    }
  });

  $("#addItem").on("click", function () {
    const newItem = $("#newItem").val();
    const newDescription = $("#newDescription").val();
    const newRemarks = $("#newRemarks").val();
    const newAmount = $("#newAmount").val();
    const newItemRow = `<tr>
                            <td>${newItem}</td>
                            <td>${newDescription}</td>
                            <td class="text-center"><span class="badge text-bg-primary">NEW ITEM</span></td>
                            <td><span class="badge text-bg-primary">NEW ITEM</span></td>
                            <td class="text-end">
                              <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" value="${newAmount}">
                              <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal">Multiple Entry</button>
                            </td>
                            <td>0.0</td>
                            <td ><textarea class="form-control form-control-sm remarks" rows="1" style="max-height: 150px" value="${newRemarks}"></textarea></td>
                            <td class="text-center"><input type="file" class="form-control form-control-sm" multiple></td>
                            <td class="text-center"><input type="checkbox" class="form-check-input rowCheckbox"></td>
                          </tr>`;
    $("#dataTable2 tbody").append(newItemRow);

    // Clear input fields after adding the new item
    $("#newItem").val('');
    $("#newDescription").val('');
    $("#newRemarks").val('');
    $("#newAmount").val('');
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
  function toggleChat() {
    const chat = document.querySelector('.notes-window');
    chat.classList.toggle('open');
  }
  function toggleBreakdown() {
      const chat = document.querySelector('.breakdown-window');
      chat.classList.toggle('open');
  }
  function showTime() {
      document.getElementById('currentTime').innerHTML = new Date().toUTCString();
  }
  showTime();
  setInterval(function () {
      showTime();
  }, 1000);
});
