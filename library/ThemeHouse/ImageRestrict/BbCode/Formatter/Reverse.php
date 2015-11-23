<?php

class ThemeHouse_ImageRestrict_BbCode_Formatter_Reverse extends XenForo_BbCode_Formatter_Base
{

    protected $_urls = array();

    protected $_urlPrefix = '[U[R[L[';

    protected $_urlSuffix = ']]]';

    public function getTags()
    {
        if ($this->_tags !== null) {
            return $this->_tags;
        }
        
        return array(
            'img' => array(
                'parseCallback' => array(
                    $this,
                    'parseValidatePlainIfNoOption'
                ),
                'callback' => array(
                    $this,
                    'processTagImg'
                )
            )
        );
    } /* END getTags */

    public function processTagImg(array $tag, array $rendererStates)
    {
        $url = $this->stringifyTree($tag['children']);
        
        $validUrl = $this->_getValidUrl($url);
        if (!$validUrl) {
            return $this->filterString($url, $rendererStates);
        }
        
        $censored = XenForo_Helper_String::censorString($validUrl);
        if ($censored != $validUrl) {
            return $this->filterString($url, $rendererStates);
        }
        
        $this->_urls[$url] = $validUrl;
        
        return '[IMG]' . $this->_urlPrefix . $url . $this->_urlSuffix . '[/IMG]';
    } /* END processTagImg */

    public function processTagUrl(array $tag, array $rendererStates)
    {
        if (!empty($tag['option'])) {
            $url = $tag['option'];
            $text = $this->renderSubTree($tag['children'], $rendererStates);
        } else {
            $url = $this->stringifyTree($tag['children']);
            $text = urldecode($url);
            if (!utf8_check($text)) {
                $text = $url;
            }
        }
        
        $validUrl = $this->_getValidUrl($url);
        if (!empty($validUrl)) {
            $this->_urls[$url] = $validUrl;
        }
        
        if (!empty($tag['option'])) {
            return "[URL={$this->_urlPrefix}{$url}{$this->_urlSuffix}]{$text}[/URL]";
        } else {
            return "[URL]{$this->_urlPrefix}{$url}{$this->_urlSuffix}[/URL]";
        }
    } /* END processTagUrl */

    public function renderTree(array $tree, array $extraStates = array())
    {
        $output = parent::renderTree($tree, $extraStates);
        
        $maskModel = XenForo_Model::create('ThemeHouse_ImageRestrict_Model_Mask');
        $maskedUrls = $maskModel->maskUrls($this->_urls, $extraStates);
        
        foreach ($this->_urls as $url => $validUrl) {
            $search = $this->_urlPrefix . $url . $this->_urlSuffix;
            
            if (!empty($maskedUrls[$validUrl])) {
                $replace = $maskedUrls[$validUrl];
            } else {
                $replace = $url;
            }
            
            $output = str_replace($search, $replace, $output);
        }
        
        return $output;
    } /* END renderTree */
}