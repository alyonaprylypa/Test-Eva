<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?
$APPLICATION->SetTitle('Календарь дел');
?>

<?$APPLICATION->IncludeComponent(
	"custom:intranet.absence.calendar",
	"",
	[]
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>