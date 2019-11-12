<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Localization\Loc;


/** @var CBitrixComponentTemplate $this */

$APPLICATION->SetTitle(Loc::getMessage('MSTORES_LIST_TITLE'));

$APPLICATION->IncludeComponent(
    'bitrix:crm.control_panel',
    '',
    array(
        'ID' => 'STORES',
        'ACTIVE_ITEM_ID' => 'STORES',
    ),
    $component
);

$urlTemplates = array(
    'DETAIL' => $arResult['SEF_FOLDER'] . $arResult['SEF_URL_TEMPLATES']['details'],
    'EDIT' => $arResult['SEF_FOLDER'] . $arResult['SEF_URL_TEMPLATES']['edit'],
);

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.toolbar',
    'title',
    array(
        'TOOLBAR_ID' => 'MSTORES_TOOLBAR',
        'BUTTONS' => array(
            array(
                'TEXT' => Loc::getMessage('MSTORES_ADD'),
                'TITLE' => Loc::getMessage('MSTORES_ADD'),
                'LINK' => CComponentEngine::makePathFromTemplate($urlTemplates['EDIT'], array('STORE_ID' => 0)),
                'ICON' => 'btn-add',
            ),
        )
    ),
    $this->getComponent(),
    array('HIDE_ICONS' => 'Y')
);

$APPLICATION->IncludeComponent(
    'local.mstores:stores.list',
    '',
    array(
        'URL_TEMPLATES' => $urlTemplates,
        'SEF_FOLDER' => $arResult['SEF_FOLDER'],
    ),
    $this->getComponent(),
    array('HIDE_ICONS' => 'Y',)
);