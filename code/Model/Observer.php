<?php

class BlueAcorn_GreenspecDiscounts_Model_Observer extends Mage_SalesRule_Model_Validator
{
    const SHIPPING_BY_PERCENT_ACTION = 'shipping_by_percent';

    public function modifySelectOptions(Varien_Event_Observer $observer)
    {
        $field = $observer->getEvent()->getForm()->getElement('simple_action');

        $options = $field->getValues();
        $options[$this::SHIPPING_BY_PERCENT_ACTION]
            = Mage::helper('blueacorn_greenspecdiscounts')->__('Percent of shipping cost discount');

        $field->setValues($options);
    }
}