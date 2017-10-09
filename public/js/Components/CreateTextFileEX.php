<?php
ini_set('memory_limit', '512M');
date_default_timezone_set('Asia/Bangkok');
header("Content-type:text/html; charset=UTF-8");

$userFolder = $_POST['userID']."_".$_POST['userName'];
$sectionFolder = "Section_".$_POST['section_id'];
$content = $_POST['Content'];
$path = "../../../upload/exam/";

//สร้างโฟลเดอร์ของอาจารย์เพื่อเก็บข้อสอบ
makeFolder($path,$userFolder);
//สร้างโฟลเดอร์กลุ่มข้อสอบ
makeFolder($path.$userFolder.'/',$sectionFolder);

//สร้างโฟลเดอร์ข้อสอบ จากวันที่สร้าง
$examFolder = date('Ymd-His') . "_" . rand(1, 9999);
mkdir($path.$userFolder.'/'.$sectionFolder.'/'.$examFolder, 0777, true);
//สร้างไฟล์ให้ชื่อ content.txt
$file = "content.txt";
$handle = fopen($path.$userFolder.'/'.$sectionFolder.'/'.$examFolder.'/'.$file, 'w') or die('Cannot open file:  ' . $file);
fwrite($handle, $content);
$file = "../upload/exam/".$userFolder.'/'.$sectionFolder.'/'.$examFolder.'/'.$file;
echo $file;

function makeFolder($path,$folder) {
    $dirList = scandir($path);
    if (!in_array((string) $folder, (array) $dirList)) {
        mkdir($path.$folder, 0777, true);
    }
}