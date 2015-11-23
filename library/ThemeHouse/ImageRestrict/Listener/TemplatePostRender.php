<?php

class ThemeHouse_ImageRestrict_Listener_TemplatePostRender extends ThemeHouse_Listener_TemplatePostRender
{

    protected function _getTemplates()
    {
        return array(
            'thread_create',
            'post_edit',
            'thread_reply'
        );
    } /* END _getTemplates */

    public static function templatePostRender($templateName, &$content, array &$containerData, 
        XenForo_Template_Abstract $template)
    {
        $templatePostRender = new ThemeHouse_ImageRestrict_Listener_TemplatePostRender($templateName, $content,
            $containerData, $template);
        list ($content, $containerData) = $templatePostRender->run();
    } /* END templatePostRender */

    protected function _threadCreate()
    {
        $this->_appendTemplate('th_form_stuff_imagerestriction');
    } /* END _threadCreate */

    protected function _postEdit()
    {
        $this->_appendTemplate('th_form_stuff_imagerestriction');
    } /* END _postEdit */

    protected function _threadReply()
    {
        $this->_appendTemplate('th_form_stuff_imagerestriction');
    } /* END _threadReply */
}