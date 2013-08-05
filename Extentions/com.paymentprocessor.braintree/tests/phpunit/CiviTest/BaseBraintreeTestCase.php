<?php

/**
 * Description of BaseBraintreeContributionTest
 *
 * @author Vivek Arora
 */
require_once 'CiviSeleniumTestCase.php';

class BaseBraintreeTestCase extends CiviSeleniumTestCase {

    protected function setUp() {
        parent::setUp();
    }


    //Command: scripts/phpunit -uroot -proot -hlocalhost -bcivicrm_ext_tests_dev --filter testAddBraintreePaymentProcessor WebTest_Contribute_BraintreeContributionTest
    function testAddBraintreePaymentProcessor() {
        $this->open($this->sboxPath);
        $this->webtestLogin();
        $this->waitForPageToLoad("30000");
        $this->_addBraintreePaymentProcessor();
    }

    function _addBraintreePaymentProcessor() {

        //Load Payment Processor Page 
        $this->open($this->sboxPath . "civicrm/admin/paymentProcessor");
        $this->waitForElementPresent('newPaymentProcessor');
        $this->click('newPaymentProcessor');
        $this->waitForPageToLoad("30000");

        $this->select("payment_processor_type", "label=Braintree");
        $this->waitForPageToLoad("30000");

        $this->type("name", "braintree");
        $this->type("description", "Braintree Payment Processor");
        $this->check('is_active');

        //For Live
        $this->type("user_name", "qvtn6yk594nbxsyw");
        $this->type("password", "g55wdxm36pb8yy5m");
        $this->type("signature", "b92f264fd7b17d0f01893ff52777135c");
 
        //For Test
        $this->type("test_user_name", "qvtn6yk594nbxsyw");
        $this->type("test_password", "g55wdxm36pb8yy5m");
        $this->type("test_signature", "b92f264fd7b17d0f01893ff52777135c");
 
        $this->waitForElementPresent('_qf_PaymentProcessor_next');
        $this->click('_qf_PaymentProcessor_next');
        $paleapRow = "xpath=//table[@id='selector']/tbody//tr//td[@class='crm-payment_processor-name'][text()='Braintree']/";
        if ($this->isElementPresent($paleapRow)) {
            $this->assertTrue(True, 'PayLeap Payment Processor Add Successfully.');
        }
    }

    //Command: scripts/phpunit -uroot -proot -hlocalhost -bcivicrm_ext_tests_dev --filter testDeletePayLeapPaymentProcessor WebTest_Contribute_PayLeapContributionTest
    function testDeletePayLeapPaymentProcessor() {
        $this->open($this->sboxPath);
        $this->webtestLogin();
        $this->waitForPageToLoad("30000");
        $this->_deletePayLeapPaymentProcessor();
    }

    function _deletePayLeapPaymentProcessor() {

        $this->open($this->sboxPath . "civicrm/admin/paymentProcessor");
        $this->waitForPageToLoad("30000");

        $noPP = "There are no Payment Processors entered.";
        if ($this->isTextPresent($noPP)) {
            $this->assertTrue(True, $noPP);
        } else {
            $braintreeRow = "xpath=//table[@class='selector']/tbody//tr//td[@class='crm-payment_processor-name'][text()='Braintree']/";
            $this->waitForElementPresent($braintreeRow);

            if ($this->isElementPresent($braintreeRow)) {

                $deleteLeink = $braintreeRow . "../td[6]/span//a[text()='Delete']";
                $this->waitForElementPresent($deleteLeink);
                $this->click($deleteLeink);
                $this->waitForPageToLoad("30000");
                $this->waitForElementPresent('_qf_PaymentProcessor_next');
                $this->click('_qf_PaymentProcessor_next');
                $msg = "Selected Payment Processor has been deleted.";
                $this->waitForTextPresent($msg);
                if (!$this->isTextPresent($msg)) {
                    $this->assertTrue(True, 'There is some problem to delete payent processor.');
                }
            }
        }
    }
    
     function _setCCAndBillingDetail() {
        $this->select("credit_card_type", "value=Visa");
        $this->type('credit_card_number', '4111111111111111');
        $this->type('cvv2', '123');

        $this->select("credit_card_exp_date[M]", "value=5");
        $this->select("credit_card_exp_date[Y]", "value=2015");

        $this->type('billing_first_name', substr(sha1(rand()), 0, 3));
        $this->type('billing_middle_name', substr(sha1(rand()), 0, 4));
        $this->type('billing_last_name', substr(sha1(rand()), 0, 5));

        $this->type('billing_street_address-5', substr(sha1(rand()), 0, 5) . '' . substr(sha1(rand()), 0, 7));
        $this->type('billing_city-5', substr(sha1(rand()), 0, 4));

        $this->select("billing_state_province_id-5", "value=1001");
        $this->type('billing_postal_code-5', '12345');
    }

}

?>
