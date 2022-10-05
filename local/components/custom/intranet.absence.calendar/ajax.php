<?
$filePath = $_SERVER["DOCUMENT_ROOT"].'/local/components/custom/intranet.absence.calendar/events.csv';
if (file_exists($filePath)) {
    if($_POST['date'] && $_POST['event']) {
        $fp = fopen($filePath, 'a');
        $res = fputcsv($fp, [$_POST['date'], $_POST['event']], ';', '"'); 
        fclose($fp);    
    }
}
$result = [
    'isSuccess' => boolval($res),
];
header("Content-type: application/json; charset=utf-8");
echo json_encode($result);