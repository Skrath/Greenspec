<?php
/**
 * Created by JetBrains PhpStorm.
 * User: incubator
 * Date: 7/12/13
 * Time: 12:08 PM
 */
class BlueAcorn_GreenspecDiscounts_Model_SalesRule_Validator extends Mage_SalesRule_Model_Validator
{
    const SHIPPING_BY_PERCENT_ACTION = 'shipping_by_percent';

    public function processShippingAmount(Mage_Sales_Model_Quote_Address $address)
    {
        foreach ($this->_getRules() as $rule) {
            if ($rule->getSimpleAction() == $this::SHIPPING_BY_PERCENT_ACTION) {
                $shippingAmount = $address->getShippingAmountForDiscount();
                if ($shippingAmount !== null) {
                    $baseShippingAmount = $address->getBaseShippingAmountForDiscount();
                } else {
                    $shippingAmount = $address->getShippingAmount();
                    $baseShippingAmount = $address->getBaseShippingAmount();
                }
                $quote = $address->getQuote();
                $appliedRuleIds = array();
                $rulePercent = min(100, $rule->getDiscountAmount());
                $discountAmount = ($shippingAmount - $address->getShippingDiscountAmount()) * $rulePercent / 100;
                $baseDiscountAmount = ($baseShippingAmount -
                        $address->getBaseShippingDiscountAmount()) * $rulePercent / 100;
                $discountPercent = min(100, $address->getShippingDiscountPercent() + $rulePercent);
                $address->setShippingDiscountPercent($discountPercent);

                $discountAmount = min($address->getShippingDiscountAmount() + $discountAmount, $shippingAmount);
                $baseDiscountAmount = min(
                    $address->getBaseShippingDiscountAmount() + $baseDiscountAmount,
                    $baseShippingAmount
                );

                $address->setShippingDiscountAmount($discountAmount);
                $address->setBaseShippingDiscountAmount($baseDiscountAmount);
                $appliedRuleIds[$rule->getRuleId()] = $rule->getRuleId();

                $this->_maintainAddressCouponCode($address, $rule);
                $this->_addDiscountDescription($address, $rule);

                $address->setAppliedRuleIds($this->mergeIds($address->getAppliedRuleIds(), $appliedRuleIds));
                $quote->setAppliedRuleIds($this->mergeIds($quote->getAppliedRuleIds(), $appliedRuleIds));

                if ($rule->getStopRulesProcessing()) {
                    return $this;
                }
            }
        }

        return parent::processShippingAmount($address);
    }
}