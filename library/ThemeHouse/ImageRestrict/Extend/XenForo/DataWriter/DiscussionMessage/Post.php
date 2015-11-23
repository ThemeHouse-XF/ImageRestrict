<?php

/**
 *
 * @see XenForo_DataWriter_DiscussionMessage_Post
 */
class ThemeHouse_ImageRestrict_Extend_XenForo_DataWriter_DiscussionMessage_Post extends XFCP_ThemeHouse_ImageRestrict_Extend_XenForo_DataWriter_DiscussionMessage_Post
{

    protected $_updateImageRestrictionMask = false;

    protected function _getFields()
    {
        $fields = parent::_getFields();
        
        $fields['xf_post']['imagerestriction_users'] = array(
            'type' => self::TYPE_SERIALIZED,
            'default' => 'a:0:{}'
        );
        
        return $fields;
    } /* END _getFields */

    protected function _messagePreSave()
    {
        if (!empty($GLOBALS[ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction::GLOBAL_KEY])) {
            $GLOBALS[ThemeHouse_ImageRestrict_ControllerHelper_ImageRestriction::GLOBAL_KEY]->actionImageRestriction(
                $this);
        }
        $this->_processImageRestrictionLinks();
        
        return parent::_messagePreSave();
    } /* END _messagePreSave */

    protected function _messagePostSave()
    {
        if ($this->_updateImageRestrictionMask) {
            $this->getModelFromCache('ThemeHouse_ImageRestrict_Model_Mask')->updateMaskPostId($this->get('post_id'),
                $this->getExtraData(XenForo_DataWriter_DiscussionMessage::DATA_ATTACHMENT_HASH));
        }
        
        return parent::_messagePostSave();
    } /* END _messagePostSave */

    public function setImageRestrictionUsers(array $users)
    {
        $usersSimple = array();
        $maskModel = $this->getModelFromCache('ThemeHouse_ImageRestrict_Model_Mask');
        
        foreach ($users as $user) {
            if ($maskModel->canRestrictUser($user, null, $error)) {
                $usersSimple[] = array(
                    'user_id' => $user['user_id'],
                    'username' => $user['username']
                );
            } else 
                if ($error) {
                    $this->error($error);
                    return;
                }
        }
        
        $this->set('imagerestriction_users', $usersSimple);
    } /* END setImageRestrictionUsers */

    protected function _processImageRestrictionLinks()
    {
        $users = $this->get('imagerestriction_users');
        if (!is_array($users)) {
            $users = @unserialize($users);
        }
        if (empty($users)) {
            $users = array();
        }
        
        if (!empty($users)) {
            $message = $this->get('message');
            
            $bbCodeParser = new XenForo_BbCode_Parser(
                XenForo_BbCode_Formatter_Base::create('ThemeHouse_ImageRestrict_BbCode_Formatter_Reverse',
                    array(
                        'smilies' => array(),
                        'bbCode' => array()
                    )));
            
            $message = $bbCodeParser->render($message, 
                array(
                    'attachment_hash' => $this->getExtraData(XenForo_DataWriter_DiscussionMessage::DATA_ATTACHMENT_HASH),
                    'post_id' => $this->get('post_id'),
                    'stopLineBreakConversion' => true
                ));
            $this->set('message', $message);
            
            $this->_updateImageRestrictionMask = true;
        }
    } /* END _processImageRestrictionLinks */
}