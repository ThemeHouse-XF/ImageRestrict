<?php

class ThemeHouse_ImageRestrict_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_ImageRestrict' => array(
                'controller' => array(
                    'XenForo_ControllerPublic_Forum',
                    'XenForo_ControllerPublic_Post',
                    'XenForo_ControllerPublic_Thread'
                ), /* END 'controller' */
                'model' => array(
                    'XenForo_Model_Attachment',
                    'XenForo_Model_Post'
                ), /* END 'model' */
                'datawriter' => array(
                    'XenForo_DataWriter_DiscussionMessage_Post'
                ), /* END 'datawriter' */
            ), /* END 'ThemeHouse_ImageRestrict' */
        );
    } /* END _getExtendedClasses */

    public static function loadClassController($class, array &$extend)
    {
        $loadClassController = new ThemeHouse_ImageRestrict_Listener_LoadClass($class, $extend, 'controller');
        $extend = $loadClassController->run();
    } /* END loadClassController */

    public static function loadClassModel($class, array &$extend)
    {
        $loadClassModel = new ThemeHouse_ImageRestrict_Listener_LoadClass($class, $extend, 'model');
        $extend = $loadClassModel->run();
    } /* END loadClassModel */

    public static function loadClassDataWriter($class, array &$extend)
    {
        $loadClassDataWriter = new ThemeHouse_ImageRestrict_Listener_LoadClass($class, $extend, 'datawriter');
        $extend = $loadClassDataWriter->run();
    } /* END loadClassDataWriter */
}