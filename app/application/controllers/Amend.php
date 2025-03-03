<?php
class Amend extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function submit_for_amendment() {
        $items = $this->input->post('items'); 
        
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                $updatedId = $this->Liquidation_model->revalidate_item($item['item_id']);
            }
            
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No items to revalidate.'));
        }
    }
}
