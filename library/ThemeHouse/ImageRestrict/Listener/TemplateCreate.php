<?php

class ThemeHouse_ImageRestrict_Listener_TemplateCreate extends ThemeHouse_Listener_TemplateCreate
{

    protected function _getTemplates()
    {
        return array(
            'thread_create',
            'post_edit',
            'thread_reply'
        );
    } /* END _getTemplates */

    public static function templateCreate(&$templateName, array &$params, XenForo_Template_Abstract $template)
    {
        $templateCreate = new ThemeHouse_ImageRestrict_Listener_TemplateCreate($templateName, $params, $template);
        list ($templateName, $params) = $templateCreate->run();
    } /* END templateCreate */

    protected function _threadCreate()
    {
        $this->_preloadTemplate('th_form_stuff_imagerestriction');
    } /* END _threadCreate */

    protected function _postEdit()
    {
        $this->_preloadTemplate('th_form_stuff_imagerestriction');
    } /* END _postEdit */

    protected function _threadReply()
    {
        $this->_preloadTemplate('th_form_stuff_imagerestriction');
    } /* END _threadReply */
}