<?php
class BlueAcorn_Greenspec_VoteController extends Mage_Core_Controller_Front_Action {
    public function submitAction() {
        // Generate coupon id
        $coupon_code = Mage::getModel('salesrule/rule')->load(1)->acquireCoupon()->getCode();

        // Set up email template
        $template = Mage::getModel('core/email_template')->loadDefault('poll_coupon_template')
            ->setSenderName("Custom 1")
            ->setSenderEmail("custom1@example.com")
            ->setTemplateSubject("Coupon");

        // Send email
        $template->send(Mage::app()->getRequest()->getParam('email'), 'Guest', array("coupon_code"=>$coupon_code));

        // Redirect
        $this->_redirectReferer();
    }
}