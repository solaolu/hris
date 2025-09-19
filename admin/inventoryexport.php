<?php

require_once('../Connections/cn.php');

 require_once '../PHPExcel.php';

 $objPHPExcel = new PHPExcel();

 $query = "select *, (itemInStore + itemInTransit) as itemTotal from inventory_tbl order by ID desc";

 $result = $db->execute($query);

 $objPHPExcel = new PHPExcel();

 $rowCount = 1;

     $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Item Name");
     $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Item Total");
     $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Item In Available");
     $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Item In Transit");
     $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Last Updated");

$rowCount++;

 while($row = mysqli_fetch_array($result)){
     $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['itemName']);
     $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['itemTotal']);
     $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['itemInStore']);
     $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['itemInTransit']);
     $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['lastUpdated']);
     $rowCount++;
     //pr($objPHPExcel);
}

/* header('Content-Type: application/vnd.openxmlformats-   officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="survey.xlsx"');
 header('Cache-Control: max-age=0');

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 ob_end_clean();
 $objWriter->save('php://output');
ob_clean() */
    
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
ob_end_clean();
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename="inventory_items.xls"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
exit;

?>