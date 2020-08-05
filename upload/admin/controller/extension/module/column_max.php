<?php
class ControllerExtensionModuleColumnMax extends Controller {
  public function install() {
    $this->load->model('extension/module/column_max');
    $this->model_extension_module_column_max->install();
  }
   
  public function uninstall() {
    $this->load->model('extension/module/column_max');
    $this->model_extension_module_column_max->uninstall();
  }
}