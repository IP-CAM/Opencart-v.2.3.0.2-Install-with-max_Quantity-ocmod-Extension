<?php
class ModelExtensionModuleMaxqty extends Model {
    public function addMaxQty($productId,$max_limit){
        if($max_limit){               
            $this->db->query("UPDATE " . DB_PREFIX . "product SET max_limit = '" . (int)$max_limit . "' WHERE product_id = '" . (int)$productId . "'");
        }
    }



    public function editMaxQty($productId,$max_limit){                            
            $this->db->query("UPDATE " . DB_PREFIX . "product SET max_limit = '" . (int)$max_limit . "'  WHERE product_id = '" . (int)$productId . "'");
    }


    public function addMaxLimitDays($productId,$max_limit_days){
        if($max_limit_days){               
            $this->db->query("UPDATE " . DB_PREFIX . "product SET max_limit_days = '" . (int)$max_limit_days . "' WHERE product_id = '" . (int)$productId . "'");
        }
    }

    public function editMaxLimitDays($productId,$max_limit_days){
        if($max_limit_days){   
            $this->db->query("UPDATE " . DB_PREFIX . "product SET max_limit_days = '" . (int)$max_limit_days . "' WHERE product_id = '" . (int)$productId . "'");
        }
    }
// order status dropdown

    public function orderStatusData(){
        $data = $this->db->query("SELECT name, order_status_id FROM " . DB_PREFIX . "order_status");
        return $data->rows;

    }
    public function getOrderStatus($order_id) {
        $result = $this->db->query("SELECT name FROM " . DB_PREFIX . "order_status WHERE order_status_id = " . (int)$order_id  );
        return $result->row;
    
    }
    

}




