<?php

class ThemeHouse_ImageRestrict_Route_Prefix_Masked implements XenForo_Route_Interface
{

    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $action = $router->resolveActionWithStringParam($routePath, $request, 'code');
        
        return $router->getRouteMatch('ThemeHouse_ImageRestrict_ControllerPublic_Masked', $action, 'forums');
    } /* END match */

    public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
    {
        return XenForo_Link::buildBasicLinkWithStringParam($outputPrefix, $action, $extension, $data, 'code');
    } /* END buildLink */
}