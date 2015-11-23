<?php

class ThemeHouse_ImageRestrict_Model_Mask extends XenForo_Model
{

    const CODE_CHARACTERS = 'abcdefghiklmnopqrstuvwxyz1234567890';

    const FETCH_POST = 0x01;

    public function canViewStuffInPost(array $mask, array $viewingUser = null)
    {
        $this->standardizeViewingUserReference($viewingUser);

        $ImageRestrictionUsers = $this->getUsersFromPost($mask);

        foreach ($ImageRestrictionUsers as $user) {
            if ($user['user_id'] == $viewingUser['user_id']) {
                return false;
            }
        }

        return true;
    } /* END canViewStuffInPost */

    public function canRestrictUser(array $user, array $viewingUser = null, &$error = false)
    {
        $this->standardizeViewingUserReference($viewingUser);

        if ($user['user_id'] == $viewingUser['user_id']) {
            return false;
        }

        if (XenForo_Application::$versionId < 1020000 && ($user['is_admin'] || $user['is_moderator'])) {
            $error = new XenForo_Phrase('th_you_cant_deny_access_to_staff_members_imagerestriction');
            return false;
        } elseif (XenForo_Application::$versionId >= 1020000 && $user['is_staff']) {
            $error = new XenForo_Phrase('th_you_cant_deny_access_to_staff_members_imagerestriction');
            return false;
        }

        return true;
    } /* END canRestrictUser */

    public function getUsersFromPost(array $post)
    {
        if (isset($post['imagerestriction_users'])) {
            $ImageRestrictionUsers = $post['imagerestriction_users'];
            if (!is_array($ImageRestrictionUsers)) {
                $ImageRestrictionUsers = @unserialize($ImageRestrictionUsers);
            }
            if (empty($ImageRestrictionUsers)) {
                $ImageRestrictionUsers = array();
            }

            return $ImageRestrictionUsers;
        } else {
            return array();
        }
    } /* END getUsersFromPost */

    public function maskUrls(array $urls, array $postData)
    {
        $urls = array_unique($urls);
        $masks = array();

        foreach ($urls as $key => $validUrl) {
            $parts = explode('.', $validUrl);
            $extension = strtolower(array_pop($parts));

            if (!in_array($extension, array(
                'jpg',
                'jpeg',
                'gif',
                'png',
                'bmp'
            ))) {
                unset($urls[$key]);
            }
        }

        if (!empty($urls)) {
            $maskTotal = $this->countAllMask();
            if (!empty($postData['attachment_hash'])) {
                $masksByAttachmentHash = $this->getAllMask(array(
                    'attachment_hash' => $postData['attachment_hash']
                ));
            } else {
                $masksByAttachmentHash = array();
            }
            if (!empty($postData['post_id'])) {
                $masksByPostId = $this->getAllMask(array(
                    'post_id' => $postData['post_id']
                ));
            } else {
                $masksByPostId = array();
            }
            $masksMerged = array_merge($masksByAttachmentHash, $masksByPostId);

            // remove masked url from the list
            foreach ($masksMerged as $mask) {
                foreach ($urls as $key => $validUrl) {
                    if ($mask['url'] == $validUrl) {
                        unset($urls[$key]);
                        $masks[$validUrl] = $this->getMaskLink($mask);
                    }
                }
            }

            // start generating mask
            foreach ($urls as $validUrl) {
                $code = $this->generateCode($validUrl, $maskTotal);

                $dw = XenForo_DataWriter::create('ThemeHouse_ImageRestrict_DataWriter_Mask');
                if (!empty($postData['post_id'])) {
                    $dw->set('post_id', $postData['post_id']);
                }
                if (!empty($postData['attachment_hash'])) {
                    $dw->set('attachment_hash', $postData['attachment_hash']);
                }
                $dw->set('url', $validUrl);
                $dw->set('code', $code);
                $dw->save();

                $generated = $dw->getMergedData();
                $masks[$validUrl] = $this->getMaskLink($generated);
            }
        }

        return $masks;
    } /* END maskUrls */

    public function getMaskLink(array $mask)
    {
        return XenForo_Link::buildPublicLink('full:restricted-images', $mask);
    } /* END getMaskLink */

    public function generateCode($validUrl, $maskTotal = false)
    {
        if ($maskTotal === false) {
            $maskTotal = $this->countAllMask();
        }
        $codeCharacters = self::CODE_CHARACTERS;
        $codeCharactersLength = strlen($codeCharacters);
        $codeCharactersLengthMinus = $codeCharactersLength - 1;
        $maskCodeLength = max(5, 2 + ceil(log($maskTotal, $codeCharactersLength)));

        do {
            $code = '';
            for ($i = 0; $i < $maskCodeLength; $i++) {
                $code .= $codeCharacters[mt_rand(0, $codeCharactersLengthMinus)];
            }
            $existed = $this->getAllMask(array(
                'code' => $code
            ));
        } while (!empty($existed));

        return $code;
    } /* END generateCode */

    public function updateMaskPostId($postId, $attachmentHash)
    {
        return $this->_getDb()->update('xf_imagerestriction_mask', array(
            'post_id' => $postId,
            'attachment_hash' => ''
        ), array(
            'attachment_hash = ?' => $attachmentHash
        ));
    } /* END updateMaskPostId */

    public function getMaskByCode($code, array $fetchOptions = array())
    {
        $data = $this->getAllMask(array(
            'code' => $code
        ), $fetchOptions);

        return reset($data);
    } /* END getMaskByCode */

    public function getList(array $conditions = array(), array $fetchOptions = array())
    {
        $data = $this->getAllMask($conditions, $fetchOptions);
        $list = array();

        foreach ($data as $id => $row) {
            $list[$id] = $row['url'];
        }

        return $list;
    } /* END getList */

    public function getMaskById($id, array $fetchOptions = array())
    {
        $data = $this->getAllMask(array(
            'mask_id' => $id
        ), $fetchOptions);

        return reset($data);
    } /* END getMaskById */

    public function getAllMask(array $conditions = array(), array $fetchOptions = array())
    {
        $whereConditions = $this->prepareMaskConditions($conditions, $fetchOptions);

        $orderClause = $this->prepareMaskOrderOptions($fetchOptions);
        $joinOptions = $this->prepareMaskFetchOptions($fetchOptions);
        $limitOptions = $this->prepareLimitFetchOptions($fetchOptions);

        return $this->fetchAllKeyed(
            $this->limitQueryResults(
                "
				SELECT mask.*
					$joinOptions[selectFields]
				FROM `xf_imagerestriction_mask` AS mask
					$joinOptions[joinTables]
				WHERE $whereConditions
					$orderClause
			", $limitOptions['limit'], $limitOptions['offset']), 'mask_id');
    } /* END getAllMask */

    public function countAllMask(array $conditions = array(), array $fetchOptions = array())
    {
        $whereConditions = $this->prepareMaskConditions($conditions, $fetchOptions);

        $orderClause = $this->prepareMaskOrderOptions($fetchOptions);
        $joinOptions = $this->prepareMaskFetchOptions($fetchOptions);
        $limitOptions = $this->prepareLimitFetchOptions($fetchOptions);

        return $this->_getDb()->fetchOne(
            "
			SELECT COUNT(*)
			FROM `xf_imagerestriction_mask` AS mask
				$joinOptions[joinTables]
			WHERE $whereConditions
		");
    } /* END countAllMask */

    public function prepareMaskConditions(array $conditions, array &$fetchOptions)
    {
        $sqlConditions = array();
        $db = $this->_getDb();

        foreach (array(
            'mask_id',
            'post_id',
            'attachment_hash',
            'code'
        ) as $intField) {
            if (!isset($conditions[$intField]))
                continue;

            if (is_array($conditions[$intField])) {
                $sqlConditions[] = "mask.$intField IN (" . $db->quote($conditions[$intField]) . ")";
            } else {
                $sqlConditions[] = "mask.$intField = " . $db->quote($conditions[$intField]);
            }
        }

        return $this->getConditionsForClause($sqlConditions);
    } /* END prepareMaskConditions */

    public function prepareMaskFetchOptions(array $fetchOptions)
    {
        $selectFields = '';
        $joinTables = '';

        if (!empty($fetchOptions['join'])) {
            if ($fetchOptions['join'] & self::FETCH_POST) {
                $selectFields .= ' ,post.* ';
                $joinTables .= ' INNER JOIN `xf_post` AS post ON (post.post_id = mask.post_id) ';
            }
        }

        return array(
            'selectFields' => $selectFields,
            'joinTables' => $joinTables
        );
    } /* END prepareMaskFetchOptions */

    public function prepareMaskOrderOptions(array &$fetchOptions, $defaultOrderSql = '')
    {
        $choices = array()

        ;
        return $this->getOrderByClause($choices, $fetchOptions, $defaultOrderSql);
    } /* END prepareMaskOrderOptions */
}