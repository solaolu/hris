<?php //echo getcwd(); 
require_once("../../../classes/dao.php");  
require_once('suppliers.php');
?>
<h2>TECHNICAL - LIGHT</h2>

<form method="post" id="lightBrief" action="create_tbl.php?t=lightRequest_tbl">
<table border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td align="right"><strong>Client:</strong></td>
    <td><input type="text" class="form-control"  name="Client" id="Client" /></td>
    <td align="right"><strong>Project Name:</strong></td>
    <td><input type="text" class="form-control"  name="ProjectName" id="ProjectName" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Event Date:</strong></td>
    <td><input type="text" class="form-control date-picker"  name="EventDate" id="EventDate" /></td>
    <td align="right"><strong>Event Location:</strong></td>
    <td><input type="text" class="form-control"  name="EventLocation" id="EventLocation" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Unit/Department:</strong></td>
    <td><input type="text" class="form-control"  name="Unit" id="Unit" /></td>
    <td align="right"><strong>Supplier&rsquo;s Name:</strong></td>
    <td><input type="text" class="form-control"  name="SupplierName" id="SupplierName" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Setup/delivery/Call Time:</strong></td>
    <td><input type="text" class="form-control"  name="SetupTime" id="SetupTime" /></td>
    <td align="right"><strong>Setup/delivery/Call Date:</strong></td>
    <td><input type="text" class="form-control"  name="SetupDate" id="SetupDate" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><strong>Objective:</strong> Briefly state what exactly the client intends to achieve and the main objective of the project.</p>
<p>
  <textarea class="form-control" name="Objective" id="Objective" cols="50" rows="5"></textarea>
</p>
<p><strong>Light</strong></p>
<p><em>Type</em>                                                                                </p>
<table width="200">
  <tr>
    <td><label>
      <input type="radio" name="LightType" value="Parcan" id="LightType_0" />
      Parcan</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="LightType" value="Moving Heads" id="LightType_1" />
      Moving Head</label></td>
  </tr>
</table>
<p><em>Specific</em></p>
<table width="200">
  <tr>
    <td><label>
      <input type="radio" name="LightSpecifics" value="Mood" id="LightSpecifics_0" />
      Mood</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="LightSpecifics" value="Ambiance" id="LightSpecifics_1" />
      Ambiance</label></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>Colour Scheme: 
  <input type="text" class="form-control"  name="ColourScheme" id="ColourScheme" />
</p>
<p>&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td><strong>Preferred Supplier:</strong></td>
    <td><input type="text" class="form-control"  name="PreferredSupplier" id="PreferredSupplier" /></td>
    <td><strong>Payment Terms:</strong></td>
    <td><input type="text" class="form-control"  name="PaymentTerms" id="PaymentTerms" /></td>
  </tr>
  <tr>
    <td><strong>Supplier Name:</strong></td>
    <td><input type="text" class="form-control"  name="SupplierName2" id="SupplierName2" /></td>
    <td><strong>Project Manager:</strong></td>
    <td><input type="text" class="form-control"  name="ProjectManager" id="ProjectManager" /></td>
  </tr>
  <tr>
    <td><strong>Procurement:</strong></td>
    <td><input type="text" class="form-control"  name="Procurement" id="Procurement" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td>&nbsp;</td>
  </tr>
  <tr>
     <td>
      <p>Preferred suppliers (maximum of 3)</p>
      <select class="select2" multiple name="supplier1">
          <?php 
            
            $rows = getSupplierByService("light");
          
            foreach($rows as $row){
            ?>
                <option value="<?php echo $row['ID']; ?>"><?php echo $row['supplierName']; ?></option>
            <?php
            }
          ?>
      </select>
      </td>
  </tr>
  <tr>
      <td>&nbsp;</td>
  </tr>
  <tr>
      <td><a class="btn btn-primary" onclick="submitBrief('lightBrief')">Submit Brief</a></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>

