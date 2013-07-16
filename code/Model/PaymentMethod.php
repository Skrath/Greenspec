<?php

/**
 * Our test CC module adapter
 */
class BlueAcorn_Greenspec_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'greenspec';

    /**
     * Is this payment method a gateway (online auth/charge) ?
     */
    protected $_isGateway               = true;

    /**
     * Can authorize online?
     */
    protected $_canAuthorize            = true;

    /**
     * Can capture funds online?
     */
    protected $_canCapture              = true;

    /**
     * Can capture partial amounts online?
     */
    protected $_canCapturePartial       = false;

    /**
     * Can refund online?
     */
    protected $_canRefund               = false;

    /**
     * Can void transactions online?
     */
    protected $_canVoid                 = true;

    /**
     * Can use this payment method in administration panel?
     */
    protected $_canUseInternal          = true;

    /**
     * Can show this payment method as an option on checkout payment page?
     */
    protected $_canUseCheckout          = true;

    /**
     * Is this payment method suitable for multi-shipping checkout?
     */
    protected $_canUseForMultishipping  = true;

    /**
     * Can save credit card information for future processing?
     */
    protected $_canSaveCc = false;

    /* Here you will need to implement authorize, capture and void public methods */

    /* @see examples of transaction specific public methods such as */
    /* authorize, capture and void in Mage_Paygate_Model_Authorizenet */

    public static function canApply(Mage_Sales_Model_Quote_Address $address) {
        $quote = $address->getQuote();


        /* var_dump($address->getAllShippingRates()); */
        /* var_dump($address->getShippingMethod()); */

        return true;
    }

    public static function getFee() {
        return 11;
    }
}