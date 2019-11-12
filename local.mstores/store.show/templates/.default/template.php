<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/** @var CBitrixComponentTemplate $this */

if (!Loader::includeModule('crm')) {
    ShowError(Loc::getMessage('MSTORES_NO_CRM_MODULE'));
    return;
}

ob_start();
$APPLICATION->IncludeComponent(
    'local.mstores:store.bounddeals',
    '',
    array(
        'STORE_ID' => $arResult['STORE']['ID']
    ),
    $this->getComponent(),
    array('HIDE_ICONS' => 'Y')
);
$boundDealsHtml = ob_get_clean();

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.form',
    'show',
    array(
        'GRID_ID' => $arResult['GRID_ID'],
        'FORM_ID' => $arResult['FORM_ID'],
        'TACTILE_FORM_ID' => $arResult['TACTILE_FORM_ID'],
        'ENABLE_TACTILE_INTERFACE' => 'Y',
        'SHOW_SETTINGS' => 'Y',
        'DATA' => $arResult['STORE'],
        'TABS' => array(
            array(
                'id' => 'tab_1',
                'name' => Loc::getMessage('MSTORES_TAB_STORE_NAME'),
                'title' => Loc::getMessage('MSTORES_TAB_STORE_TITLE'),
                'display' => false,
                'fields' => array(
                    array(
                        'id' => 'section_store',
                        'name' => Loc::getMessage('MSTORES_FIELD_SECTION_STORE'),
                        'type' => 'section',
                        'isTactile' => true,
                    ),
                    array(
                        'id' => 'ID',
                        'name' => Loc::getMessage('MSTORES_FIELD_ID'),
                        'type' => 'label',
                        'value' => $arResult['STORE']['ID'],
                        'isTactile' => true,
                    ),
                    array(
                        'id' => 'NAME',
                        'name' => Loc::getMessage('MSTORES_FIELD_NAME'),
                        'type' => 'label',
                        'value' => $arResult['STORE']['NAME'],
                        'isTactile' => true,
                    ),
                    array(
                        'id' => 'ADDRESS',
                        'name' => Loc::getMessage('MSTORES_FIELD_ADDRESS'),
                        'type' => 'label',
                        'value' => $arResult['STORE']['ADDRESS'],
                        'isTactile' => true,
                    ),
                    array(
                        'id' => 'ASSIGNED_BY',
                        'name' => Loc::getMessage('MSTORES_FIELD_ASSIGNED_BY'),
                        'type' => 'custom',
                        'value' => CCrmViewHelper::PrepareFormResponsible(
                            $arResult['STORE']['ASSIGNED_BY_ID'],
                            CSite::GetNameFormat(),
                            Option::get('intranet', 'path_user', '', SITE_ID) . '/'
                        ),
                        'isTactile' => true,
                    )
                )
            ),
            array(
                'id' => 'deals',
                'name' => Loc::getMessage('MSTORES_TAB_DEALS_NAME'),
                'title' => Loc::getMessage('MSTORES_TAB_DEALS_TITLE'),
                'fields' => array(
                    array(
                        'id' => 'DEALS',
                        'colspan' => true,
                        'type' => 'custom',
                        'value' => $boundDealsHtml
                    )
                )
            )
        ),
    ),
    $this->getComponent(),
    array('HIDE_ICONS' => 'Y')
);