<?php
/**
 * Default Russian Lexicon Entries for mSklad
 *
 * @package msklad
 * @subpackage lexicon
 */

include_once 'setting.inc.php';

$_lang['msklad'] = 'mSync (ex mSklad)';
$_lang['msklad_menu_desc'] = 'Синхронизация с 1С и сервисами "Класс365", "МойСклад"';
$_lang['msklad_copyright'] = '<a href="http://www.simpledream.ru" title="Simple Dream"> <img src="/assets/components/msklad/images/simpledream.png"></a>';

$_lang['msklad_btn_create'] = 'Добавить';
$_lang['msklad_menu_create'] = 'Добавить';
$_lang['msklad_menu_update'] = 'Изменить';
$_lang['msklad_menu_remove'] = "Удалить";
$_lang['msklad_menu_remove_confirm'] = "Подтвердите удаление";

$_lang['msklad_sync_catalog'] = 'Синхронизация справочника товаров';
$_lang['msklad_sync_catalog_button'] = "Синхронизировать товары (API)";
$_lang['msklad_sync_export_button'] = 'Экспорт справочника товаров в .csv';
$_lang['msklad_sync_finish'] = 'Завершение синхронизации, очистка кэша.';

$_lang['msklad_1c_config'] = 'Реквизиты синхронизации';
$_lang['msklad_1c_link'] = 'Ссылка для синхронизации (CommerceML 2)';
$_lang['msklad_1c_login'] = 'Логин';
$_lang['msklad_1c_pass'] = 'Пароль';

$_lang['msklad_sync_direction_ms2_to_service'] = 'Из miniShop2 в МойСклад';
$_lang['msklad_sync_direction_service_to_ms2'] = 'Из сервиса CommerceML в miniShop2';

$_lang['msklad_1c_properties'] = 'Настройка импорта свойств';
$_lang['msklad_1c_properties_intro'] = 'Здесь можно настроить связи свойств товара и полей minishop2/tv';

$_lang['msklad_id'] = 'id';
$_lang['msklad_source'] = 'источник';
$_lang['msklad_type'] = 'тип поля';
$_lang['msklad_target'] = 'цель';
$_lang['msklad_active'] = 'активный';

$_lang['msklad_type_db'] = 'поле msProduct';
$_lang['msklad_type_tv'] = 'tv';

$_lang['msklad_active_yes'] = 'да';
$_lang['msklad_active_no'] = 'нет';