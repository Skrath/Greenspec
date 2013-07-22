<?php
class BlueAcorn_Greenspec_Block_PollEmail extends Mage_Poll_Block_ActivePoll {
    protected $voted;

    protected function _toHtml() {
        /** @var $coreSessionModel Mage_Core_Model_Session */
        $justVotedPollId = Mage::getSingleton('core/session')->getJustVotedPoll();

        $pollId = $this->getPollToShow();

        Mage::getSingleton('core/session')->setJustVotedPoll(false);

        if ($this->_pollModel->isVoted($pollId) === true || $justVotedPollId) {
            $this->voted = true;
        } else {
            $this->voted = false;
        }

        // Bypass parent _toHtml since we are overridding it.
        return Mage_Core_Block_Template::_toHtml();
    }

    public function hasVoted() {
        return $this->voted;
    }
}