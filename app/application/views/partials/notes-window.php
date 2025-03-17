<button onclick="toggleChat()" class="chat-toggle-btn btn btn-primary rounded-circle">
    <i class="fas fa-comments"></i>
    <span class="position-absolute start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
        <span class="visually-hidden">New alerts</span>
    </span>
</button>
<div class="notes-window">
    <div class="notes-header bg-gradient text-white p-3 text-center d-flex justify-content-between">
        <p></p>
        <p class="p-0">Notes</p>
        <i class="fa-solid fa-xmark m-2" onClick="toggleChat()"></i>
    </div>
    <div class="chat-messages p-3" id="notes-list">
        <?php if (!empty($notes)): ?>
            <?php foreach($notes as $note): ?>
                <?php if($note->sender == $this->session->userdata('fullname')): ?>
                    <div class="sender">
                        <div class="d-flex justify-content-between text-secondary">
                            <div class="d-flex justify-content-end align-items-end">
                                <p class="small">
                                    <?php
                                        date_default_timezone_set('Asia/Singapore'); 
                                        echo date('F j, Y H:i A', strtotime($note->timestamp));
                                    ?>
                                </p>
                            </div>
                            <div>
                                <p class="small text-end"><strong><?= $note->sender; ?></strong></p>
                            </div>
                        </div>
                        <div class=""> 
                            <div class="imessage d-flex justify-content-end align-items-right">
                                <p class="from-me">
                                <?= $note->notes; ?>
                                </p>
                                <div class="profile-notes right">
                                    <img src="<?= base_url('assets/images/bg-ship.jpg'); ?>" class="rounded-circle">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="receiver">
                        <div class="d-flex justify-content-between text-secondary">
                            <div>
                                <p class="small"><strong><?= $note->sender; ?></strong></p>
                            </div>
                            <div class="d-flex justify-content-end align-items-end">
                                <p class="small">
                                    <?php
                                        date_default_timezone_set('Asia/Singapore'); 
                                        echo date('F j, Y H:i A', strtotime($note->timestamp));
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="imessage d-flex">
                                <div class="profile-notes">
                                    <img src="<?= base_url('assets/images/bg-ship.jpg'); ?>" class="rounded-circle m-0">
                                </div>
                                <p class="from-them">
                                <?= $note->notes; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-notes mx-auto my-auto">No notes available.</p>
        <?php endif; ?>
    </div>
    
    <div class="input-group d-flex justify-content-betwen align-items-center">
        <input type="hidden" name="liq_ref" value="<?php echo $id; ?>" id="liq_ref">
        <input type="hidden" name="sender" value="<?php echo $this->session->userdata('fullname'); ?>" id="sender">
        <input type="text" class="form-control" name="notes" placeholder="Type a message..." id="notesInput">
        <button class="btn btn-primary" id="addNotesBtn" style="border-radius: 0;">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>
</div>