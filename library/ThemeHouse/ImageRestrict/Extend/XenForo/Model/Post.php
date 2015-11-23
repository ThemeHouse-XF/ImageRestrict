<?php

/**
 *
 * @see XenForo_Model_Post
 */
class ThemeHouse_ImageRestrict_Extend_XenForo_Model_Post extends XFCP_ThemeHouse_ImageRestrict_Extend_XenForo_Model_Post
{

    public function getAndMergeAttachmentsIntoPosts(array $posts)
    {
        $posts = parent::getAndMergeAttachmentsIntoPosts($posts);
        $maskModel = $this->getModelFromCache('ThemeHouse_ImageRestrict_Model_Mask');
        
        foreach ($posts as &$post) {
            if (!$maskModel->canViewStuffInPost($post)) {
                if (!empty($post['attachments'])) {
                    foreach ($post['attachments'] as &$attachment) {
                        if (!empty($attachment['thumbnailUrl'])) {
                            unset($attachment['thumbnailUrl']);
                        }
                    }
                }
            }
        }
        return $posts;
    } /* END getAndMergeAttachmentsIntoPosts */
}