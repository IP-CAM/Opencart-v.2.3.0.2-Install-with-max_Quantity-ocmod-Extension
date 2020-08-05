<?php
class ModelExtensionModuleColumnMax extends Model {
  public function install() {
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "product`  ADD  `max_limit` INT(11) NULL DEFAULT NULL ;");
  }
 
  public function uninstall() {
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` DROP `max_limit` ;");
  }
}