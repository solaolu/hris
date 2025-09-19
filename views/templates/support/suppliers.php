<?php
function getSupplierByCategory($cat){
    $db = new DAO();
    
    
        $sql="select supplierName, ID from approvedSuppliers_tbl where UPPER(category)=UPPER('$cat')";
        $rows=$db->getData($sql);
        return $rows;
}
?>