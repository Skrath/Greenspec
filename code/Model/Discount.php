<?php
class BlueAcorn_Greenspec_Model_Discount extends Mage_Core_Model_Abstract {
    protected $shippingMethod;
    protected $paymentMethod;
    private $nextDayShippingMethods = array('ups_1DA', 'fedex_FEDEX_1_DAY_FREIGHT', 'fedex_FIRST_OVERNIGHT');
    private $freeShippingMethods = array('freeshipping_freeshipping');

    public function canApply(Mage_Sales_Model_Quote_Address $address) {
        // Retrieve shipping method from quote
        $this->shippingMethod = $address->getQuote()->getShippingAddress()->getShippingMethod();

        // Retrieve payment method from quote
        $this->paymentMethod = $address->getQuote()->getPayment()->getMethod();

        // Just return true for now
        if ($this->shippingMethod && $this->paymentMethod)
            return true;
        else
            return false;
    }

    public function applyDiscounts(Mage_Sales_Model_Quote_Address $address) {
        $discount = 0;

        if ($this->shippingMethod) {
            // 2% off total shipping if not free or next day shipping
            if (!in_array($this->shippingMethod, $this->freeShippingMethods) && !in_array($this->shippingMethod, $this->nextDayShippingMethods))
                $discount += 0.02 * $address->getShippingAmount();
            // 20% off grand total if next day shipping is chosen
            else if (in_array($this->shippingMethod, $this->nextDayShippingMethods))
                $discount += 0.2 * $address->getGrandTotal();
        }
        return $discount*-1;
    }
}