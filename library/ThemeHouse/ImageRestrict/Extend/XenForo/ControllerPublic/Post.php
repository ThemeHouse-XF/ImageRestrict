<?php

/**
 *
 * @see XenForo_ControllerPublic_Post
 */
class ThemeHouse_ImageRestrict_Extend_XenForo_ControllerPublic_Post extends XFCP_ThemeHouse_ImageRestrict_Extend_XenForo_ControllerPublic_Post
{

    public function actionEdit()
    {
        $response = parent::actionEdit();
        
        if ($response instanceof XenForo_ControllerResponse_View) {
            $params = & $response->params;
            
            $params['ImageRestrictionUsers'] = $this->getModelFromCache('ThemeHouse_ImageRestrict_Model_Mask')->getUsersFromPost(
                $params['post']);
        }
        
        return $response;
    } /* END actionEdit */

    public function actionSave()
    {
        $GLOBALS[ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction::GLOBAL_KEY] = $this;
        
        return parent::actionSave();
    } /* END actionSave */

    public function actionSaveInline()
    {
        $GLOBALS[ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction::GLOBAL_KEY] = $this;
        
        return parent::actionSaveInline();
    } /* END actionSaveInline */

    public function actionImageRestriction(XenForo_DataWriter_DiscussionMessage_Post $dw)
    {
        $this->getHelper('ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction')->processUsers($dw);
    } /* END actionImageRestriction */
}