<!-- Modals -->
<div class="modal fade" id="multipleEntryModal" tabindex="-1" aria-labelledby="multipleEntryModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="multipleEntryModalLabel">Cost Breakdown</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                inpu
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
                    <!-- added fields goes here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary submit" data-bs-dismiss="modal" id="submitBtn">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="itemSubmissionModal" tabindex="-1" aria-labelledby="itemSubmissionModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="itemSubmissionModalLabel">Add Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id" value="<?= $item->user_id; ?>">
                <input type="hidden" name="supplier" value="<?= $item->supplier; ?>">
                <input type="hidden" name="transno" value="<?= $item->transno; ?>">
                <input type="hidden" name="isNew" value="1">
                <div class="row m-2">
                    <label for="itemName p-0">Item Name: </label>
                    <input type="text" class="form-control form-control-sm mb-2" id="newItem">
                </div>
                <div class="row m-2 gap-2">
                    <div class="col p-0">
                        <label for="amount">Amount: </label>
                        <input type="text" class="form-control form-control-sm mb-2" placeholder="0.00" id="newAmount">
                    </div>
                </div>
                <div class="row m-2">
                    <label for="remarks">Remarks: </label>
                    <textarea class="form-control form-control-sm mb-2" rows="3" style="max-height: 150px;" id="newRemarks"></textarea>
                </div>
                <div class="row m-2">
                    <label for="docref">Upload:</label>
                    <input type="file" class="form-control form-control-sm mb-2" name="filenames[]" multiple id="newUpload">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addItem" data-bs-dismiss="modal">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showItemRemarksModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title fs-5" id="showItemRemarksModalLabel">Variance Remarks</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="fullname" value="<?= $this->session->userdata('fullname') ?>">
            <p class="bold">Remarks: </p>
            <table class="table table-hover" id="remarksTable">
                <tbody>
                    <!-- item remarks goes here -->
                </tbody>
            </table>
            
        </div>
        <div class="modal-footer">

            <div class="input-group d-flex justify-content-betwen align-items-center">
                <input type="text" class="form-control" placeholder="Reply" id="newRemarkInput" autofocus>
                <button class="btn btn-primary" id="addRemarkBtn">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="dropZone">
                    <p>Drag & Drop files or click to choose files</p>
                    <button class="btn btn-sm btn-primary" id="chooseFilesButton"><i class="fa-solid fa-upload me-2"></i>Choose Files</button>
                    <input type="file" id="fileUpload" multiple />
                </div>
                <p class="bold my-3">Uploaded Files: </p>
                <ul id="fileNamesList" class="list-group mt-3"></ul>
                <div id="filePreview" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>