<?php
/**
 * Created by JetBrains PhpStorm.
 * User: incubator
 * Date: 7/10/13
 * Time: 9:26 AM
 */
class BlueAcorn_GreenspecDiscounts_Model_SalesRule_Quote_Discount extends Mage_SalesRule_Model_Quote_Discount
{
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amount = $address->getDiscountAmount() + $address->getShippingDiscountAmount();

        if ($amount != 0) {
            $description = $address->getDiscountDescription();
            if (strlen($description)) {
                $title = Mage::helper('sales')->__('Item Discount (%s)', $description);
            } else {
                $title = Mage::helper('sales')->__('Item Discount');
            }
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $title,
                'value' => $amount
            ));
        }
        return $this;
    }
}