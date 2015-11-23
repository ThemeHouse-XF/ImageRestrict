<?php

class ThemeHouse_ImageRestrict_Option
{

    protected static $_routePrefix = '';

    public static function setRoutePrefix($routePrefix)
    {
        self::$_routePrefix = $routePrefix;
    } /* END setRoutePrefix */

    public static function get($key)
    {
        switch ($key) {
            case 'routePrefix':
                return self::$_routePrefix;
        }
        
        return XenForo_Application::get('ThemeHouse_ImageRestrict_' . $key);
    } /* END get */
}