<?php

class ThemeHouse_ImageRestrict_ControllerPublic_Masked extends XenForo_ControllerPublic_Abstract
{

    public function actionIndex()
    {
        $code = $this->_input->filterSingle('code', XenForo_Input::STRING);
        
        $mask = $this->_getMaskOrError($code, array(
            'join' => ThemeHouse_ImageRestrict_Model_Mask::FETCH_POST
        ));
        
        $maskModel = $this->_getMaskModel();
        if (!$maskModel->canViewStuffInPost($mask)) {
            if (!$imagePath = XenForo_Template_Helper_Core::styleProperty('imagePath')) {
                $imagePath = 'styles/default';
            }
            $mask['url'] = $imagePath . '/xenforo/icons/moderated.png';
        }
        
        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, $mask['url']);
    } /* END actionIndex */

    protected function _getMaskModel()
    {
        return $this->getModelFromCache('ThemeHouse_ImageRestrict_Model_Mask');
    } /* END _getMaskModel */

    protected function _getMaskOrError($code, array $fetchOptions = array())
    {
        $info = $this->_getMaskModel()->getMaskByCode($code, $fetchOptions);
        if (empty($info)) {
            throw $this->getNoPermissionResponseException();
        }
        
        return $info;
    } /* END _getMaskOrError */
}