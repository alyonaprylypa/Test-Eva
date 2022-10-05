<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$filePath = $_SERVER["DOCUMENT_ROOT"].'/local/components/custom/intranet.absence.calendar/events.csv';
if (file_exists($filePath)) {
    if ($fp = fopen($filePath, "r")) {
        $arResult['EVENTS'] = [];
        while ($data = fgetcsv($fp, 0, ";") ) {
            $arResult['EVENTS'][] = ['date' => $data[0], 'event' => $data[1]];
        }
        fclose($fp);
    }
}

$this->IncludeComponentTemplate();
?>
