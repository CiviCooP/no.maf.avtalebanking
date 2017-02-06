<?php

/**
 * Collection of upgrade steps.
 */
class CRM_Avtalebanking_Upgrader extends CRM_Avtalebanking_Upgrader_Base {


  public function install() {
    $this->executeSqlFile('sql/install.sql');
  }

  public function uninstall() {
   CRM_Core_DAO::executeQuery("DROP TABLE `civicrm_avtale_banking`");
  }

}
