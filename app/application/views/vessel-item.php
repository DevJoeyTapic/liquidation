<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALS</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/liquidate.ico'); ?>">

    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>  

    <!-- JS Files -->
    <script src="<?= base_url('assets/js/dataTable.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS files -->
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">

</head>
<body>
    <div class="container-fluid">
        <nav class="navbar fixed-top bg-gradient">
            <div class="d-flex justify-content-center align-items-center">
                <a href="<?= base_url() ?>"><img src="<?= base_url('assets/images/wallem_logo_white.png'); ?>" class="header-logo"> </a>
            </div>

            <div class="profile">
                <div class="btn-group">
                    <button type="button" class="btn text-white dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <img src="<?= base_url('assets/images/default_pic.png'); ?>">
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header"><?= $this->session->userdata('username') ?: 'Guest'; ?> - <?= $this->session->userdata('user_type') == 2 ? 'Supercargo Agent' : ($this->session->userdata('user_type') == 3 ? 'Accounting' : 'Unknown'); ?></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button></li>
                        <li><a class="dropdown-item" href="<?= site_url('login/logout'); ?>">Signout</a></li>
                    </ul>
                </div>  
            </div>
        </nav>

        <div class="main-container bg-gradient">
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fa-solid fa-exclamation-circle me-2"></i>
                <div>
                    <strong>Due Wallem: </strong> PHP 39,377.01
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    
            <div class="cont mb-3">
                <div class="row px-3 d-flex justify-content-start align-items-center">
                    <div class="col p-0">
                        <div class="row p-0 d-flex justify-content-start align-items-center">
                            <div class="col-2">
                                <i class="fa-solid fa-ship fa-xl text-warning"></i>
                            </div>
                            <div class="col-10">
                                <p class="label">VESSEL</p>
                                <p class="title"><?= isset($vessel) ? $vessel : ''; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-0">
                        <div class="row p-0 d-flex justify-content-start align-items-center">
                            <div class="col-3">
                                <i class="fa-solid fa-anchor fa-xl text-info"></i>
                            </div>
                            <div class="col-9">
                                <p class="label">VOYAGE</p>
                                <p class="title"><?= isset($vessel_items->vessel) ? $vessel_items->vessel : ''; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col p-0">
                        <div class="row p-0 d-flex justify-content-start align-items-center">
                            <div class="col-2">
                                <i class="fa-solid fa-water fa-xl text-primary"></i>
                            </div>
                            <div class="col-10">
                                <p class="label">PORT</p>
                                <p class="title"><?= isset($vessel_items->vessel) ? $vessel_items->vessel : ''; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 p-0">
                        <div class="row d-flex justify-content-start align-items-center">
                            <div class="col-2">
                                <i class="fa-solid fa-clock fa-xl text-primary"></i>
                            </div>
                            <div class="col-10">
                                <p class="label">ARRIVAL</p>
                                <p class="title">2024-Oct-10</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-start align-items-center">
                            <div class="col-2">
                                <i class="fa-solid fa-clock fa-xl text-success"></i>
                            </div>
                            <div class="col-10">
                                <p class="label">DEPARTURE</p>
                                <p class="title">2024-Oct-11</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cont">
                <h5 class="mb-3">Item Liquidation</h5>
                <nav>
                    <div class="nav nav-tabs liquidation-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="pendingTab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true"><i class="fa-regular fa-clock pe-2"></i>Pending Item(s) Liquidation</button>    
                        <button class="nav-link" id="forValidationTab" data-bs-toggle="tab" data-bs-target="#forValidation" type="button" role="tab" aria-controls="forValidation" aria-selected="false"><i class="fa-solid fa-user-clock pe-2"></i>Liquidated Item(s) for Validation</button>
                        <button class="nav-link" id="validatedTab" data-bs-toggle="tab" data-bs-target="#validated" type="button" role="tab" aria-controls="validated" aria-selected="false"><i class="fa-solid fa-circle-check pe-2"></i>Liquidated Item(s)</button>            
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pendingTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemSubmissionModal">
                                        <i class="fa-solid fa-plus"></i>
                                        Add Item
                                    </button>
                                </div>
                                <div class="table-reponsive">
                                    <table class="table table-striped table-hover display" id="dataTable2">
                                        <thead>
                                            <tr>
                                                <th class="col-3">Items</th>
                                                <th>Description</th>
                                                <th class="col-1 text-center">RFP No.</th>
                                                <th class="col-2">RFP Amount</th>
                                                <th class="col-2">Actual Amount</th>
                                                <th class="col-2">Variance</th>
                                                <th class="col-2">Remarks</th>
                                                <th class="col-2 text-center">Document Reference</th>
                                                <th>Validate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="itemName">Mooring/Unmooring</td>
                                                <td></td>
                                                <td class="text-center rfpNo">6147</td>
                                                <td class="rfpAmount">24000.00</td>
                                                <td class="text-end">
                                                    <input type="text" class="form-control form-control-sm actualAmount">
                                                    <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal">Multiple Entry</button>
                                                </td>
                                                <td class="variance">0.00</td>
                                                <td class="remarks"><textarea class="form-control form-control-sm" rows="1" style="max-height: 150px"></textarea></td>
                                                <td class="docRef"><input type="file" class="form-control form-control-sm" multiple></td>
                                                <td class="text-center validate"><input type="checkbox" class="form-check-input rowCheckbox"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="forValidation" role="tabpanel" aria-labelledby="forValidationTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#liquidationModal">
                                        <i class="fa-solid fa-check"></i>
                                        Submit Liquidation
                                    </button>
                                </div>
                                <div class="table-reponsive">
                                    <table class="table table-striped table-hover display" id="dataTable3">
                                        <thead>
                                            <tr>
                                                <th class="col-3">Items</th>
                                                <th>Description</th>
                                                <th class="col-1 text-center">RFP No.</th>
                                                <th class="col-2">RFP Amount</th>
                                                <th class="col-2">Actual Amount</th>
                                                <th class="col-2">Variance</th>
                                                <th class="col-2">Remarks</th>
                                                <th class="col-2 text-center">Document Reference</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="itemName">Mooring/Unmooring</td>
                                                <td>* * Description goes here * *</td>
                                                <td class="text-center rfpNo">6147</td>
                                                <td class="rfpAmount">24000.00</td>
                                                <td class="">24000.00</td>                                                </td>
                                                <td class="variance">0.00</td>
                                                <td class="remarks">* * Comments goes here * *</td>
                                                <td class="docRef"><a href="#">somefiles.pdf</a></td>
                                                <td class="text-center validate"><input type="checkbox" class="form-check-input rowCheckbox"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="validated" role="tabpanel" aria-labelledby="validatedTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#validatedModal">
                                        <i class="fa-solid fa-check-circle"></i>
                                        View Validated Item
                                    </button>
                                </div>
                                <div class="table-reponsive">
                                    <table class="table table-striped table-hover display" id="dataTable4">
                                    <thead>
                                            <tr>
                                                <th class="col-3">Items</th>
                                                <th>Description</th>
                                                <th class="col-1 text-center">RFP No.</th>
                                                <th class="col-2">RFP Amount</th>
                                                <th class="col-2">Actual Amount</th>
                                                <th class="col-2">Variance</th>
                                                <th class="col-2">Remarks</th>
                                                <th class="col-2 text-center">Document Reference</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="itemName">Mooring/Unmooring</td>
                                                <td>* * Description goes here * *</td>
                                                <td class="text-center rfpNo">6147</td>
                                                <td class="rfpAmount">24000.00</td>
                                                <td class="">24000.00</td>                                                </td>
                                                <td class="variance">0.00</td>
                                                <td class="remarks">* * Comments goes here * *</td>
                                                <td class="docRef"><a href="#">somefiles.pdf</a></td>
                                                <td>Validated</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
  	</div>
  <!-- Modals -->
	<div class="modal fade" id="multipleEntryModal" tabindex="-1" aria-labelledby="multipleEntryModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="multipleEntryModalLabel">Multiple Entry</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-2">
						<p class="label">ITEM NAME:</p>
						<p class="title" id="itemName"></p>
					</div>
					<div class="mb-2 row">
						<div class="col-auto">
							<p class="label">RFP NO.:</p>
							<p class="title" id="rfpNo"></p>
						</div>
						<div class="col-auto">
							<p class="label">RFP AMOUNT:</p>
							<p class="title" id="rfpAmt"></p>
						</div>
					</div>
					<div class="row pe-3 d-flex justify-content-end align-items-center">
						<button type="button" class="w-auto btn btn-primary btn-sm mb-2 add">Add Field</button>
					</div>
					<div class="addedFields">
						<div class="mt-3">
							<strong>Total: </strong><span id="totalAmount">0.00</span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary submit" data-bs-dismiss="modal" id="submitBtn">Submit</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="submissionConfirmationModal" tabindex="-1" aria-labelledby="submissionConfirmationModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="submissionConfirmationModalLabel">Confirmation</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Are you sure you want to submit this item(s) liquidation for validation?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="confirmSubmit" data-bs-dismiss="modal">Confirm</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="itemSubmissionModal" tabindex="-1" aria-labelledby="itemSubmissionModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="itemSubmissionModalLabel">Add Item</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row m-2">
						<label for="itemName p-0">Item Name: </label>
						<input type="text" class="form-control form-control-sm mb-2">
					</div>
					<div class="row m-2 gap-2">
						<div class="col p-0">
							<label for="amount">Amount: </label>
							<input type="text" class="form-control form-control-sm mb-2" placeholder="0.00">
						</div>
					</div>
					<div class="row m-2">
						<label for="remarks">Remarks: </label>
						<textarea class="form-control form-control-sm mb-2" rows="3" style="max-height: 150px;"></textarea>
					</div>
					<div class="row m-2">
						<label for="docref">Upload:</label>
						<input type="file" class="form-control form-control-sm mb-2" name="filenames[]" multiple>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="">Add</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			let total = 0;
		
			// Iterate through each row in the table
			$('#rfpAmount').closest('tbody').find('tr').each(function() {
				// Get the text from the third cell (formatted with currency)
				let value = $(this).find('td#rfpAmount').text().replace(/[^0-9.-]+/g, '');
				
				// Convert to float and sum
				total += parseFloat(value) || 0;
			});
			$('#totalDisplay').text('Total: PHP ' + total.toFixed(2)); // Format the output
		});
	</script>
		
</body>
</html>