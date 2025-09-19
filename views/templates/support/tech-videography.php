<?php //echo getcwd(); 
require_once("../../../classes/dao.php");  
require_once('suppliers.php');
?>
<h2>TECHNICAL - VIDEOGRAPHY</h2>
<p>&nbsp;</p>
<form method="post" id="videographyBrief" action="create_tbl.php?t=videographyRequest_tbl">
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
<p><strong>VIDEOGRAPHY</strong><br />
</p>
<p><br />
</p>
<p><em>TYPE</em>:</p>
<p>&nbsp;</p>
<p>DISTRIBUTION:</p>
<table width="200">
  <tr>
    <td><label>
      <input type="checkbox" name="Distribution" value="Front of House" id="Distribution_0" />
      Front of House</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Distribution" value="Roving" id="Distribution_1" />
      Roving</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Distribution" value="Crowed" id="Distribution_2" />
      Crowed</label></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>MIXING/LIVE FEEDS: 
  <br />
</p>
<p>  Streaming (if required must use 4k camera)<br />
</p>
<table width="200">
  <tr>
    <td><label>
      <input type="radio" name="Streaming" value="Yes" id="Streaming_0" />
      Yes</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="Streaming" value="No" id="Streaming_1" />
      No</label></td>
  </tr>
</table>
<p>&nbsp;  </p>
<p>Output Type:<br />
</p>
<table width="200">
  <tr>
    <td><label>
      <input type="radio" name="OutputType" value="3GP" id="OutputType_0" />
      3GP</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="OutputType" value="AVI" id="OutputType_1" />
      AVI</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="OutputType" value="MP4" id="OutputType_2" />
      MP4</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="OutputType" value="WMA" id="OutputType_3" />
      WMA</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="OutputType" value="MKV" id="OutputType_4" />
      MKV</label></td>
  </tr>
</table>
<p>&nbsp;  </p>
<p>Duration:<br />
</p>
<table width="200">
  <tr>
    <td><label>
      <input type="checkbox" name="Duration" value="30 seconds" id="Duration_0" />
      30 seconds</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Duration" value="60 seconds" id="Duration_1" />
      60 seconds</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Duration" value="5 minutes" id="Duration_2" />
      5 minutes</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Duration" value="7 minutes" id="Duration_3" />
      7 minutes</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Duration" value="All rushes" id="Duration_4" />
      All rushes (unedited)</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Duration" value="Documentary" id="Duration_5" />
      Documentary</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="checkbox" name="Duration" value="1 hour Edited" id="Duration_6" />
      1hr Edited</label></td>
  </tr>
</table>
<p>  <br />
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
            
            $rows = getSupplierByService("videography");
          
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
      <td><a class="btn btn-primary" onclick="submitBrief('videographyBrief')">Submit Brief</a></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>

