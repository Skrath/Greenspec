<?php

class BlueAcorn_Greenspec_Model_Observer {

    public function testing(Varien_Event_Observer $observer) {
        $session = Mage::getSingleton('core/session');
        $greenspecData = $session->getGreenspecData();


        /* var_dump(is_array($greenspecData) && $greenspecData['visitedPage']); */
    }

    public function checkCMSPage(Varien_Event_Observer $observer) {
        $session = Mage::getSingleton('core/session');
        $greenspecData = $session->getGreenspecData();

        if (!is_array($greenspecData)) {
            $greenspecData = array();
        }

        $page = $observer->getData('page');

        if ( (int)$page->getPageId() == Mage::getStoreConfig('payment/greenspec/cms_page')) {
            $greenspecData['visitedPage'] = true;
            $session->setGreenspecData($greenspecData);
        }
    }
}
