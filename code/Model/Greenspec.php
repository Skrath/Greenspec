<?php

/**
 * Our test CC module adapter
 */
class BlueAcorn_Greenspec_Model_Greenspec extends Mage_Payment_Model_Method_Abstract
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

    protected static $shippingMethod;
    protected static $paymentMethod;

    private static $nextDayShippingMethods = array('ups_1DP', 'ups_1DA', 'ups_1DM', 'fedex_FEDEX_1_DAY_FREIGHT', 'fedex_FIRST_OVERNIGHT');
    private static $freeShippingMethods = array('freeshipping_freeshipping');

    /* Here you will need to implement authorize, capture and void public methods */


    public static function getBonus(Mage_Sales_Model_Quote_Address $address) {
        self::$shippingMethod = $address->getShippingMethod();
        self::$paymentMethod = $address->getQuote()->getPayment()->getMethod();

        $quote = $address->getQuote();
        $totals = $quote->getTotals();
        $discount = 0;


        if (self::$shippingMethod) {
            /**
             * Discounts applied through shipping & payment methods
             */
            // 2% off total shipping if not free or next day shipping
            if (!in_array(self::$shippingMethod, self::$freeShippingMethods) && !in_array(self::$shippingMethod, self::$nextDayShippingMethods)) {
                $discount += 0.02 * $address->getShippingAmount();
            }
            // 20% off grand total if next day shipping is chosen
            else if (in_array(self::$shippingMethod, self::$nextDayShippingMethods)) {
                $discount += 0.2 * $address->getGrandTotal();
            }
        }

        if (Mage::app()->getStore()->isAdmin()) {
            // Retrieve group items
            $group_items = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('type_id', array('eq'=>'grouped'))
                ->load()
                ->getItems();

            // Populate associated products array
            $associatedProducts = array();
            foreach ($group_items as $product) {
                $associatedProducts = array_merge($associatedProducts, $product->getTypeInstance(true)->getAssociatedProducts($product));
            }

            // Retrieve cart items
            $items = $address->getAllItems();
            foreach($items as $item) {
                foreach($associatedProducts as $product) {
                    if ($product->getSku() == $item->getProduct()->getSku()) {
                        $discount += 0.05*$product->getPrice();
                    }
                }
            }
        }
        return $discount*-1;
    }

    /**
     * this method is called if we are just authorising
     * a transaction
     */
    public function authorize (Varien_Object $payment, $amount)
    {

    }

    /**
     * this method is called if we are authorising AND
     * capturing a transaction
     */
    public function capture (Varien_Object $payment, $amount)
    {

    }

    /**
     * called if refunding
     */
    public function refund (Varien_Object $payment, $amount)
    {

    }

    /**
     * called if voiding a payment
     */
    public function void (Varien_Object $payment)
    {

    }
}