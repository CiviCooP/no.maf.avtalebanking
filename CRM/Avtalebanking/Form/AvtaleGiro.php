<?php

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Avtalebanking_Form_AvtaleGiro extends CRM_Core_Form {

  protected $contact_id;

  protected $ba_id;

  public function buildQuickForm() {
    $store = NULL;
    $this->contact_id = CRM_Utils_Request::retrieve('cid', 'Integer', $store, TRUE);
    $this->ba_id = CRM_Utils_Request::retrieve('ba_id', 'Integer', $store, TRUE);

    $avtaleGiroSql = "SELECT * FROM `civicrm_avtale_banking` WHERE ba_id = %1";
    $bank_account = new CRM_Banking_BAO_BankAccount();
    $bank_account->id = $this->ba_id;
    $bank_account_data = array();
    $bank_account_data['ba_id'] = $this->ba_id;
    $bank_account_data['cid'] = $this->contact_id;
    if ($bank_account->find(true)) {
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
    }

    $this->assign('account', $bank_account_data);
    $contact_name = civicrm_api3('Contact', 'getvalue', array('return' => 'display_name', 'id' => $this->contact_id));
    CRM_Utils_System::setTitle(ts('Edit Avtalge Giro for %1', array(1=>$contact_name)));

    $this->add('hidden', 'ba_id', $this->ba_id);
    $this->add('hidden', 'cid', $this->contact_id);

    // add form elements
    $this->add(
      'select', // field type
      'notification_to_bank', // field name
      ts('Send notification'), // field label
      array(0=>ts('No'), 1=>ts('Yes')), // list of options
      TRUE // is required
    );

    $this->add(
      'text',
      'maximum_amount', // field name
      ts('Maximum amount'), // field label,
      array(),
      TRUE // is required
    );
    $this->addRule('maximum_amount', ts('Maximum amount should be a valid number'), 'integer');

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    $this->setDefaults($bank_account_data);

    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    $params[1] = array($this->ba_id, 'Integer');
    $params[2] = array($values['notification_to_bank'], 'Integer');
    $params[3] = array($values['maximum_amount'], 'Integer');
    // We use REPLACE INTO as we don't know whether the record exists
    // and should be updated or not.
    $sql = "REPLACE INTO civicrm_avtale_banking (ba_id, notification_to_bank, maximum_amount) VALUES(%1, %2, %3)";
    CRM_Core_DAO::executeQuery($sql, $params);

    // Redirect to the right page
    $url = CRM_Utils_System::url('civicrm/contact/view', 'reset=1&cid='.$this->contact_id.'&selectedChild=avtalegiro');
    CRM_Utils_System::redirect($url);
    parent::postProcess();
  }

}
