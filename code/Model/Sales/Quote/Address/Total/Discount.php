<?php
class BlueAcorn_Greenspec_Model_Sales_Quote_Address_Total_Discount extends Mage_Sales_Model_Quote_Address_Total_Abstract {
    protected $_code = "fee";

    public function collect(Mage_Sales_Model_Quote_Address $address) {
        parent::collect($address);

        // Instantiate greenspec discount model
        $greenspec = Mage::getModel("ba_greenspec/discount");

        // Reset amomunt
        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        /*
        $items = $this->_getAddressItems($address);
        if (!count($items))
            return $this;
        */

        // Get quote
        $quote = $address->getQuote();

        if ($greenspec->canApply($address)) {
            // Get existing Greenspec discount from quote
            $exist_discount = $quote->getGreenspecAmount();

            // Apply greenspec discounts
            $discount = $greenspec->applyDiscounts($address);

            $address->setGreenspecAmount($discount);
            $address->setBaseGreenspecAmount($discount);
            $quote->setGreenspecAmount($discount);

            // Adjust grand total
            $address->setGrandTotal($address->getGrandTotal() + $address->getGreenspecAmount());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseGreenspecAmount());
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address) {
        $amt = $address->getGreenspecAmount();
        $address->addTotal(array(
            'code'=>$this->getCode(),
            'title'=>'Greenspec Discounts',
            'value'=> $amt
        ));
        return $this;
    }

}