<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author         Navjeet
 *
 * */
trait getEmployeFunctionalBranch {
    /**
     * Get employe functional branch
     */
    public function auto_getEmployeFunctionalBranch($userId) {
        return $this->User_model->get_user_branch($userId);
    }
}
