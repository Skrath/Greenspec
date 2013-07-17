<?php
class BlueAcorn_GreenspecDiscounts_Model_Sales_Quote_Address_Total_ShippingDiscount
    extends Mage_Sales_Model_Quote_Address_Total_Shipping
{
    public function __construct()
    {
        $this->setCode('shipping_discount');
    }

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        // This has already been collected in Mage_SalesRule_Model_Quote_Discount--just adding a separate line item...
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amount = $address->getShippingDiscountAmount();
        if ($amount != 0 || $address->getShippingDescription()) {
            $title = Mage::helper('sales')->__('Shipping Discount');
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $title,
                'value' => -$address->getShippingDiscountAmount()
            ));
        }
        return $this;
    }
}