<?php
defined('B_PROLOG_INCLUDED') || die;

use Local\Mstores\Entity\StoreTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

class CLocalMStoresStoreShowComponent extends CBitrixComponent
{
    const FORM_ID = 'MSTORES_SHOW';

    public function __construct(CBitrixComponent $component = null)
    {
        parent::__construct($component);

        CBitrixComponent::includeComponentClass('local.mstores:stores.list');
        CBitrixComponent::includeComponentClass('local.mstores:store.edit');
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $APPLICATION->SetTitle(Loc::getMessage('MSTORES_SHOW_TITLE_DEFAULT'));

        if (!Loader::includeModule('local.mstores')) {
            ShowError(Loc::getMessage('MSTORES_NO_MODULE'));
            return;
        }

        $dbStore = StoreTable::getById($this->arParams['STORE_ID']);
        $store = $dbStore->fetch();

        if (empty($store)) {
            ShowError(Loc::getMessage('MSTORES_STORE_NOT_FOUND'));
            return;
        }

        $APPLICATION->SetTitle(Loc::getMessage(
            'MSTORES_SHOW_TITLE',
            array(
                '#ID#' => $store['ID'],
                '#NAME#' => $store['NAME']
            )
        ));

        $this->arResult =array(
            'FORM_ID' => self::FORM_ID,
            'TACTILE_FORM_ID' => CLocalMStoresStoreEditComponent::FORM_ID,
            'GRID_ID' => CLocalMStoresStoresListComponent::GRID_ID,
            'STORE' => $store
        );

        $this->includeComponentTemplate();
    }
}