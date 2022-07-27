<?php
include 'application/libraries/spout-3.1.0/src/Spout/Autoloader/autoload.php';
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
date_default_timezone_set("Asia/Bangkok");
$tFileName = 'test.xlsx';
$oWriter = WriterEntityFactory::createXLSXWriter();

$oWriter->openToBrowser($tFileName); // stream data directly to the browser
$aCells = [
    WriterEntityFactory::createCell(null),
    WriterEntityFactory::createCell('test'),
    WriterEntityFactory::createCell(null)
];
$singleRow = WriterEntityFactory::createRow($aCells);
$oWriter->addRow($singleRow);
$oWriter->close();
 ?>
