<?php
class ModelExtensionModuleMaxqty extends Model{
    public function maximumValidation($cartId = null, $type, $qty, $productId = null) {

        // Get Cart Details
        $cartDetails = ($type == 'add') ? $this->getCartDetails($productId, $type): $this->getCartDetails($cartId, $type);
        if ($cartDetails) {
            $productId = $cartDetails['product_id'];
            $cartQuantity = $cartDetails['quantity'];
        }
        

        // Get Product Details
        $productDetails = $this->getProductDetails($productId);
        $productName = $productDetails['name'];
        $productMaxLimit = $productDetails['max_limit'];


        if ($qty > 0 && $type == 'add' && $cartDetails) {
            $qty = $cartQuantity + $qty;   
        }

        $json = [
            'validation' => true,
            'product_name' => $productName,
            'max_limit' => $productMaxLimit
        ];
        if($productMaxLimit){
            if($productMaxLimit < $qty){
                $json['validation'] = false;
                return $json;
            }
        }

        return $json;

    }

    public function getCartDetails($id, $type) {

        // Add Operation
        if ($type == 'add') {
            $result = $this->db->query("SELECT cart_id, product_id, quantity FROM " . DB_PREFIX . "cart WHERE product_id = " . (int)$id . " AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND customer_id = " . (int)$this->customer->getId() );
        }
        else {
            $result = $this->db->query("SELECT cart_id, product_id, quantity FROM " . DB_PREFIX . "cart WHERE cart_id = " . (int)$id . " AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND customer_id = " . (int)$this->customer->getId() );
        }
        
        return $result->row;

    }

    public function getProductDetails($productId) {

        $result = $this->db->query("SELECT opd.name, op.max_limit FROM " . DB_PREFIX . "product op LEFT JOIN " . DB_PREFIX . "product_description opd ON (opd.product_id = op.product_id AND opd.language_id = 1) WHERE op.product_id = " . (int)$productId . " LIMIT 1");
        return $result->row;
    }


// _______________WEB_____________________

public function totalQtyPerCustomer($max_limit_days, $product_id, $customer_id,$customer_email){
    if($max_limit_days){
    $limit_from_date = date('Y-m-d H:i:s', strtotime('-'.$max_limit_days.' days', strtotime(date('Y-m-d H:i:s'))));
    $productInfo = $this->getProductInfo($customer_id, $product_id, $limit_from_date,$customer_email);
    $qty_total = $productInfo['qty_total'];
    $productName = $productInfo['name'];
    $order_productId = $productInfo['product_id'];
    $json = [
        'qty_total' => $qty_total,
        'productName' => $productName,
        'order_productId' => $order_productId

    ];
    return $json;

    }

}

public function getProductInfo($customer_id, $product_id, $limit_from_date, $customer_email) {
    // $result = $this->db->query("SELECT opd.name, opd.product_id, SUM(opd.quantity) as qty_total FROM " . DB_PREFIX . "order op  JOIN " . DB_PREFIX . "order_product opd ON (opd.order_id = op.order_id) WHERE op.customer_id = '" . (int)$customer_id . "' AND opd.product_id = '" . (int)$product_id ."' AND  op.date_added  >= '" . $limit_from_date . "' AND  op.order_status_id  = '" . $this->config->get('limit_max_order_status')."' ");
    $result = $this->db->query("SELECT opd.name, opd.product_id, SUM(opd.quantity) as qty_total FROM " . DB_PREFIX . "order op  JOIN " . DB_PREFIX . "order_product opd ON (opd.order_id = op.order_id) WHERE (op.customer_id = '" . (int)$customer_id . "'OR op.email='". $customer_email ."') AND opd.product_id = '" . (int)$product_id ."' AND  op.date_added  >= '" . $limit_from_date . "' AND  op.order_status_id  = '" . $this->config->get('limit_max_order_status')."' ");

    return $result->row;
}
public function totalQtyPerGuest($product_id,$max_limit_days,$guest_email){
    $limit_from_date = date('Y-m-d H:i:s', strtotime('-'.$max_limit_days.' days', strtotime(date('Y-m-d H:i:s'))));
    $result = $this->db->query("SELECT opd.name, opd.product_id, SUM(opd.quantity) as qty_total FROM " . DB_PREFIX . "order op  JOIN " . DB_PREFIX . "order_product opd ON (opd.order_id = op.order_id) WHERE op.email = '" . $guest_email . "' AND opd.product_id = '" . (int)$product_id ."' AND  op.date_added  >= '" . $limit_from_date . "' AND  op.order_status_id  = '" . $this->config->get('limit_max_order_status')."' ");
    return $result->row;

}
}

