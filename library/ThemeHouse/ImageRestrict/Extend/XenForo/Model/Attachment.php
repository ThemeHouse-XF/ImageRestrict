<?php

/**
 *
 * @see XenForo_Model_Attachment
 */
class ThemeHouse_ImageRestrict_Extend_XenForo_Model_Attachment extends XFCP_ThemeHouse_ImageRestrict_Extend_XenForo_Model_Attachment
{

    public function canViewAttachment(array $attachment, $tempHash = '', array $viewingUser = null)
    {
        $canView = parent::canViewAttachment($attachment, $tempHash, $viewingUser);
        
        if ($canView) {
            if ($attachment['content_type'] == 'post' and !empty($attachment['content_id']) and
                 !empty($attachment['thumbnail_width'])) {
                $this->standardizeViewingUserReference($viewingUser);
                $post = $this->getModelFromCache('XenForo_Model_Post')->getPostById($attachment['content_id']);
                
                $canView = $this->getModelFromCache('ThemeHouse_ImageRestrict_Model_Mask')->canViewStuffInPost($post);
            }
        }
        
        return $canView;
    } /* END canViewAttachment */
}