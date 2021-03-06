<?php

class BlueAcorn_Greenspec_Model_Sales_Quote_Address_Total_Discount
extends Mage_Sales_Model_Quote_Address_Total_Abstract {

    protected $_code = 'greenspec';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }


        $quote = $address->getQuote();

        $amount = BlueAcorn_Greenspec_Model_Greenspec::getBonus($address);

        $address->setGreenspecBonusAmount($amount);
        $address->setGreenspecBonusBaseAmount($amount);

        $quote->setGreenspecBonusAmount($amount);

        $address->setGrandTotal($address->getGrandTotal() + $address->getGreenspecBonusAmount());
        $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getGreenspecBonusBaseAmount());
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        /* var_dump($address); */
        $amt = $address->getGreenspecBonusAmount();
        $address->addTotal(array(
            'code'=>$this->getCode(),
            /* 'title'=>Mage::helper('greenspec')->__('Greenspec'), */
            'title' => 'Greenspec',
            'value'=> $amt
        ));
        return $this;
    }
}