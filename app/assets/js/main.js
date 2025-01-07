// new variance calculation

// calculate variance
$(document).ready(function () {
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

  $(document).on("input", ".new-amount", function () {
    updateTotal();
  });

  $(document).on("input", ".actualAmount", function () {
    const expectedAmount = parseFloat(
      $(this).closest("tr").find("td:nth-child(3)").text()
    );
    const actualAmount = parseFloat($(this).val()) || 0;
    const variance = expectedAmount - actualAmount;

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
    toggleSubmit();
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
    const rfpNo = row.find("td:nth-child(2)").text();
    const rfpAmt = parseFloat(
      row
        .find("td:nth-child(3)")
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
      console.log("Expected amount for active row:", expectedAmount);
      const variance = expectedAmount - total;
      row.find(".variance").text(variance.toFixed(2)); // Update variance in the row
    } else {
      console.log("no active row found");
    }
  });

  $(".rowCheckbox").change(function () {
    toggleSubmit();
  });
  function toggleSubmit() {
    let anyChecked = $(".rowCheckbox:checked").length > 0;

    // Toggle the button state based on the checkbox status
    if (anyChecked) {
      $("#submitLiquidation").removeClass("disabled").prop("disabled", false);
    } else {
      $("#submitLiquidation").addClass("disabled").prop("disabled", true);
    }
  }

  $("#submitLiquidation").on("click", function () {
    const checkedRows = $("#dataTable2 .rowCheckbox:checked").closest("tr");
    if (checkedRows.length > 0) {
      checkedRows.each(function () {
        const itemName = $(this).find("td:nth-child(1)").text();
        const rfpNo = $(this).find("td:nth-child(2)").text();
        const rfpAmount = $(this).find("td:nth-child(3)").text();
        const actualAmount = $(this).find("td:nth-child(4) input").val();
        const variance = $(this).find(".variance").text();
        const remarks = $(this).find("td:nth-child(6) textarea").val();
        const docref = $(this).find("td:nth-child(7)").text().trim() || "NONE";

        const displayDocRef = docref === "NONE" ? docref : "attachment.pdf";

        const newRow = `<tr>
                            <td>${itemName}</td>
                            <td class="text-center">${rfpNo}</td>
                            <td>${rfpAmount}</td>
                            <td>${actualAmount}</td>
                            <td>${variance}</td>
                            <td >${remarks}</td>
                            <td class="text-center">${displayDocRef}</td>
                            <td class="text-center">For Validation</td>
                          </tr>`;

        $("#dataTable3 tbody").append(newRow);
      });

      checkedRows.remove();
      toggleSubmitButton();
    }
  });
});

// Ensure no conflicting scripts are causing redirection issues
document.addEventListener('DOMContentLoaded', function() {
    // Add any necessary initialization or event listeners here
});
