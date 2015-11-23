<?php

/**
 *
 * @see XenForo_ControllerPublic_Thread
 */
class ThemeHouse_ImageRestrict_Extend_XenForo_ControllerPublic_Thread extends XFCP_ThemeHouse_ImageRestrict_Extend_XenForo_ControllerPublic_Thread
{

    public function actionAddReply()
    {
        $GLOBALS[ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction::GLOBAL_KEY] = $this;
        
        return parent::actionAddReply();
    } /* END actionAddReply */

    public function actionImageRestriction(XenForo_DataWriter_DiscussionMessage_Post $dw)
    {
        $this->getHelper('ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction')->processUsers($dw);
    } /* END actionImageRestriction */
}