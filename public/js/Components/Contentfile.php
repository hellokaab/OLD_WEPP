<?php
ini_set('memory_limit', '512M');
date_default_timezone_set('Asia/Bangkok');
header("Content-type:text/html; charset=UTF-8");
$content = $_POST['Content'];
$part = "upload/exam/content/";
$file = date('Ymd-His') . "_" . rand(1, 9999);
$file = "$file.txt";
$handle = fopen('../../upload/exam/content/' . $file, 'w') or die('Cannot open file:  ' . $file);
fwrite($handle, $content);
$file = $part.$file;
echo $file;

