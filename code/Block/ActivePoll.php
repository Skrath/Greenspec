<?php
class BlueAcorn_Greenspec_Block_ActivePoll extends Mage_Poll_Block_ActivePoll {
    protected function _toHtml() {
        /** @var $coreSessionModel Mage_Core_Model_Session */
        $coreSessionModel = Mage::getSingleton('core/session');
        $justVotedPollId = $coreSessionModel->getJustVotedPoll();
        if ($justVotedPollId && !$this->_pollModel->isVoted($justVotedPollId)) {
            $this->_pollModel->setVoted($justVotedPollId);
        }

        $pollId = $this->getPollToShow();
        $data = $this->getPollData($pollId);
        $this->assign($data);

        /** Don't unset it in the session yet!! */
        //$coreSessionModel->setJustVotedPoll(false);

        if ($this->_pollModel->isVoted($pollId) === true || $justVotedPollId) {
            $this->setTemplate($this->_templates['results']);
        } else {
            $this->setTemplate($this->_templates['poll']);
        }

        // Bypass parent _toHtml since we are overridding it.
        return Mage_Core_Block_Template::_toHtml();
    }
}