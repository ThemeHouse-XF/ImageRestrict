<?php

/**
 *
 * @see XenForo_ControllerPublic_Forum
 */
class ThemeHouse_ImageRestrict_Extend_XenForo_ControllerPublic_Forum extends XFCP_ThemeHouse_ImageRestrict_Extend_XenForo_ControllerPublic_Forum
{

    public function actionAddThread()
    {
        $GLOBALS[ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction::GLOBAL_KEY] = $this;
        
        return parent::actionAddThread();
    } /* END actionAddThread */

    public function actionImageRestriction(XenForo_DataWriter_DiscussionMessage_Post $dw)
    {
        $this->getHelper('ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction')->processUsers($dw);
    } /* END actionImageRestriction */
}