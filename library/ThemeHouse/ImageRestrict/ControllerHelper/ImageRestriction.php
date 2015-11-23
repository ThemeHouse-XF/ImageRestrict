<?php

class ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction extends XenForo_ControllerHelper_Abstract
{

    const GLOBAL_KEY = 'ThemeHouse_ImageRestrict_Controller';

    public function processUsers(XenForo_DataWriter_DiscussionMessage_Post $dw)
    {
        if ($this->_controller->getInput()->filterSingle('ImageRestrictionDataIsComing', XenForo_Input::UINT)) {
            $usernames = $this->_controller->getInput()->filterSingle('ImageRestrictionUsers', XenForo_Input::STRING, 
                array(
                    'array' => true
                ));
            foreach (array_keys($usernames) as $i) {
                if (empty($usernames[$i])) {
                    unset($usernames[$i]);
                }
            }
            
            if (!empty($usernames)) {
                $userModel = $this->_controller->getModelFromCache('XenForo_Model_User');
                $fetchOptions = array();
                $invalidNames = array();
                $users = $userModel->getUsersByNames($usernames, $fetchOptions, $invalidNames);
                try {
                    if (!empty($invalidNames)) {
                        throw new XenForo_Exception(
                            new XenForo_Phrase('th_imagerestriction_users_not_found_x_imagerestriction',
                                array(
                                    'users' => implode(', ', $invalidNames)
                                )), true);
                    }
                } catch (Exception $e) {
                    XenForo_Error::logException($e);
                }
                
                $dw->setImageRestrictionUsers($users);
            } else {
                $dw->setImageRestrictionUsers(array());
            }
        }
    } /* END processUsers */
}