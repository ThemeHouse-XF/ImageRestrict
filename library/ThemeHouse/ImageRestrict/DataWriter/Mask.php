<?php

class ThemeHouse_ImageRestrict_DataWriter_Mask extends XenForo_DataWriter
{

    protected function _getFields()
    {
        return array(
            'xf_imagerestriction_mask' => array(
                'mask_id' => array(
                    'type' => 'uint',
                    'autoIncrement' => true
                ),
                'post_id' => array(
                    'type' => 'uint',
                    'default' => 0
                ),
                'attachment_hash' => array(
                    'type' => 'string',
                    'maxLength' => 32,
                    'default' => ''
                ),
                'url' => array(
                    'type' => 'string'
                ),
                'code' => array(
                    'type' => 'string',
                    'maxLength' => 30
                )
            )
        );
    } /* END _getFields */

    protected function _getExistingData($data)
    {
        if (!$id = $this->_getExistingPrimaryKey($data, 'mask_id')) {
            return false;
        }
        
        return array(
            'xf_imagerestriction_mask' => $this->_getMaskModel()->getMaskById($id)
        );
    } /* END _getExistingData */

    protected function _getUpdateCondition($tableName)
    {
        $conditions = array();
        
        foreach (array(
            'mask_id'
        ) as $field) {
            $conditions[] = $field . ' = ' . $this->_db->quote($this->getExisting($field));
        }
        
        return implode(' AND ', $conditions);
    } /* END _getUpdateCondition */

    protected function _getMaskModel()
    {
        return $this->getModelFromCache('ThemeHouse_ImageRestrict_Model_Mask');
    } /* END _getMaskModel */
}