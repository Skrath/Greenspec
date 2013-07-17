<?php

class BlueAcorn_GreenspecDiscounts_Model_Sales_Order extends Mage_Sales_Model_Order
{
    public function getNewCouponCode()
    {
        $code = Mage::helper('blueacorn_greenspecdiscounts')->generateCouponCodes();
        return
            '<br/>
             <p style="font-size:12px; line-height:16px; margin:0;">
                 For your next purchase, enjoy 5% off with the following, one-time-use coupon code: <strong>' . $code . '</strong>
             </p>
             <br/>';
    }
}