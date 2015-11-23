<?php

class ThemeHouse_ImageRestrict_Install_Controller extends ThemeHouse_Install
{

    protected $_resourceManagerUrl = 'http://xenforo.com/community/resources/image-restrictions.2043/';

    protected function _getTables()
    {
        return array(
            'xf_imagerestriction_mask' => array(
                'mask_id' => 'int(10) unsigned AUTO_INCREMENT PRIMARY KEY', /* END 'mask_id' */
                'post_id' => 'int(10) unsigned NOT NULL DEFAULT \'0\'', /* END 'post_id' */
                'attachment_hash' => 'VARCHAR(32) NOT NULL DEFAULT \'\'', /* END 'attachment_hash' */
                'url' => 'TEXT', /* END 'url' */
                'code' => 'VARCHAR(30) NOT NULL', /* END 'code' */
            ), /* END 'xf_imagerestriction_mask' */
        );
    } /* END _getTables */

    protected function _getUniqueKeys()
    {
        return array(
            'xf_imagerestriction_mask' => array(
                'code' => array(
                    'code'
                ), /* END 'code' */
            ) /* END 'xf_imagerestriction_mask' */
        );
    } /* END _getUniqueKeys */

    protected function _getKeys()
    {
        return array(
            'xf_imagerestriction_mask' => array(
                'post_id' => array(
                    'post_id'
                ), /* END 'post_id' */
            ) /* END 'xf_imagerestriction_mask' */
        );
    } /* END _getKeys */

    protected function _getTableChanges()
    {
        return array(
            'xf_post' => array(
                'imagerestriction_users' => 'MEDIUMBLOB NULL', /* END 'imagerestriction_users' */
            ), /* END 'xf_post' */
        );
    } /* END _getTableChanges */
}