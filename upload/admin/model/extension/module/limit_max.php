<?php
class ModelExtensionModuleLimitMax extends Model {
  public function install() {
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "product`  ADD  `max_limit` INT(11) NULL DEFAULT NULL ;");
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "product`  ADD  `max_limit_days` INT(11) NULL DEFAULT NULL ;");

  }
 
  public function uninstall() {
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` DROP `max_limit` ;");
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` DROP `max_limit_days` ;");

  }
}