<?php
class jayson_PHM_Extend_XenForo_ControllerPublic_Account extends XFCP_jayson_PHM_Extend_XenForo_ControllerPublic_Account {
    protected function _saveVisitorSettings($settings, &$errors, $extras = array()) {
        $parent = parent::_saveVisitorSettings($settings, $errors, $extras);
        if (!isset($settings['allow_view_profile'])) return $parent;
        if ($settings['allow_view_profile'] === 'followed' && !XenForo_Visitor::getInstance()->hasPermission('general', 'jayson_raa_use_followed')) {
            $writer = XenForo_DataWriter::create('XenForo_DataWriter_User');
            $writer->setExistingData(XenForo_Visitor::getUserId());
            $writer->set('allow_view_profile', 'members');
            $writer->preSave();
            if ($dwErrors = $writer->getErrors()) {
                $errors = (is_array($errors) ? $dwErrors + $errors : $dwErrors);
                return false;
            }
            $writer->save();
            throw new XenForo_Exception(new XenForo_Phrase('jayson_phm_cannot_use_followed'), true);
        }
        return $parent;
    }
}
