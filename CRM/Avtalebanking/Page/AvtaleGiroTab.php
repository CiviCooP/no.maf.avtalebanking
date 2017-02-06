<?php

class CRM_Avtalebanking_Page_AvtaleGiroTab extends CRM_Core_Page {

  private $contactId;

  public function run() {
    $store = NULL;
    $bank_accounts = array();
    $contact_id = CRM_Utils_Request::retrieve('cid', 'Integer', $store, TRUE) ;

    $avtaleGiroSql = "SELECT * FROM `civicrm_avtale_banking` WHERE ba_id = %1";
    $bank_account = new CRM_Banking_BAO_BankAccount();
    $bank_account->contact_id = $contact_id;
    $bank_account->find();
    while ($bank_account->fetch()) {
      $bank_account_data = $bank_account->toArray();
      $bank_account_data['references']  = $bank_account->getReferences();
      $bank_account_data['data_parsed'] = json_decode($bank_account->data_parsed, true);
      $bank_account_data['notification_to_bank'] = false;
      $bank_account_data['maximum_amount'] = false;

      // Retrieve the AvtaleGiro information for this bank account
      $avtaleGiroSqlParams[1] = array($bank_account->id, 'Integer');
      $avtaleGiroInformation = CRM_Core_DAO::executeQuery($avtaleGiroSql, $avtaleGiroSqlParams);
      if ($avtaleGiroInformation->fetch()) {
        $bank_account_data['notification_to_bank'] = $avtaleGiroInformation->notification_to_bank;
        $bank_account_data['maximum_amount'] = $avtaleGiroInformation->maximum_amount;
      }
      $bank_account_data['edit_link'] = CRM_Utils_System::url('civicrm/banking/avtalegiro_form', 'reset=1&ba_id='.$bank_account->id.'&cid='.$contact_id, TRUE);

      $bank_accounts[$bank_account->id] = $bank_account_data;
    }

    $this->assign('bank_accounts', $bank_accounts);

    parent::run();
  }

}
