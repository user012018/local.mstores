<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Uri;


/** @var CBitrixComponentTemplate $this */


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

$editUrl = CComponentEngine::makePathFromTemplate(
    $urlTemplates['EDIT'],
    array('STORE_ID' => $arResult['VARIABLES']['STORE_ID'])
);

$viewUrl = CComponentEngine::makePathFromTemplate(
    $urlTemplates['DETAIL'],
    array('STORE_ID' => $arResult['VARIABLES']['STORE_ID'])
);

$editUrl = new Uri($editUrl);
$editUrl->addParams(array('backurl' => $viewUrl));

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.toolbar',
    'type2',
    array(
        'TOOLBAR_ID' => 'MSTORES_TOOLBAR',
        'BUTTONS' => array(
            array(
                'TEXT' => Loc::getMessage('MSTORES_EDIT'),
                'TITLE' => Loc::getMessage('MSTORES_EDIT'),
                'LINK' => $editUrl->getUri(),
                'ICON' => 'btn-edit',
            ),
        )
    ),
    $this->getComponent(),
    array('HIDE_ICONS' => 'Y')
);


$APPLICATION->IncludeComponent(
    'local.mstores:store.show',
    '',
    array(
        'STORE_ID' => $arResult['VARIABLES']['STORE_ID']
    ),
    $this->getComponent(),
    array('HIDE_ICONS' => 'Y',)
);
