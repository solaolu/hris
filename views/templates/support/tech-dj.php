<?php //echo getcwd(); 
require_once("../../../classes/dao.php");  
require_once('suppliers.php');
?>
<h2>TECHNICAL - DJ</h2>
<form method="post" id="djBrief" action="create_tbl.php?t=djRequest_tbl">
<table border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td align="right"><strong>Client:</strong></td>
    <td><input type="text" class="form-control" name="Client" id="Client" /></td>
    <td align="right"><strong>Project Name:</strong></td>
    <td><input type="text" class="form-control" name="ProjectName" id="ProjectName" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Event Date:</strong></td>
    <td><input type="text" class="form-control date-picker" name="EventDate" id="EventDate" /></td>
    <td align="right"><strong>Event Location:</strong></td>
    <td><input type="text" class="form-control" name="EventLocation" id="EventLocation" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Unit/Department:</strong></td>
    <td><input type="text" class="form-control" name="Unit" id="Unit" /></td>
    <td align="right"><strong>Supplier&rsquo;s Name:</strong></td>
    <td><input type="text" class="form-control" name="SupplierName" id="SupplierName" /></td>
  </tr>
  <tr>
    <td align="right"><strong>Setup/delivery/Call Time:</strong></td>
    <td><input type="text" class="form-control" name="SetupTime" id="SetupTime" /></td>
    <td align="right"><strong>Setup/delivery/Call Date:</strong></td>
    <td><input type="text" class="form-control" name="SetupDate" id="SetupDate" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><strong>Objective:</strong> Briefly state what exactly the client intends to achieve and the main objective of the project.</p>
<p>
  <textarea class="form-control" name="Objective" id="Objective" cols="50" rows="5"></textarea>
</p>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="5"><strong>Preferred Class of DJ:</strong>
      <label for="DJ"></label>
      <br />
      <select name="DJ" id="DJ">
        <option>Preferred Class of DJ</option>
        <option value="1st Class">1st Class</option>
        <option value="2nd Class">2nd Class</option>
        <option value="3rd Class">3rd Class</option>
        <option value="A+">A+</option>
      </select>
      <br />
      <p><em>State preferred DJ in the box below if known</em><br />
        <label for="DJName"></label>
        <input type="text" class="form-control" name="DJName" id="DJName" />
        <br />
        <br />
      </p></td>
  </tr>
  <tr>
    <td colspan="5">Microphone:<br />
      <table width="200">
        <tr>
          <td><label>
            <input type="checkbox" name="Microphone" value="Chorded" id="Microphone_0" />
            Chorded</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="Microphone" value="Chordless" id="Microphone_1" />
            Chordless</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="Microphone" value="Lapel" id="Microphone_2" />
            Lapel</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="Microphone" value="Overhead" id="Microphone_3" />
            Overhead</label></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="5">Sound:<br />
      <table width="200">
        <tr>
          <td><label>
            <input type="checkbox" name="Sound" value="With Sound" id="Sound_0" />
            With Sound</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="checkbox" name="Sound" value="Without Sound" id="Sound_1" />
            Without Sound</label></td>
        </tr>
    </table></td>
  </tr>
</table>
<p><br />
</p>
<p>&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td><strong>Preferred Supplier:</strong></td>
    <td><input type="text" class="form-control" name="PreferredSupplier" id="PreferredSupplier" /></td>
    <td><strong>Payment Terms:</strong></td>
    <td><input type="text" class="form-control" name="PaymentTerms" id="PaymentTerms" /></td>
  </tr>
  <tr>
    <td><strong>Supplier Name:</strong></td>
    <td><input type="text" class="form-control" name="SupplierName2" id="SupplierName2" /></td>
    <td><strong>Project Manager:</strong></td>
    <td><input type="text" class="form-control" name="ProjectManager" id="ProjectManager" /></td>
  </tr>
  <tr>
    <td><strong>Procurement:</strong></td>
    <td><input type="text" class="form-control" name="Procurement" id="Procurement" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td nowrap="nowrap" rowspan="2"><p><strong>Metric</strong></p></td>
    <td rowspan="2"><p align="center"><strong>Metric   Weight</strong></p></td>
    <td rowspan="2"><p align="center"><strong>Weighting   per sub KPI</strong></p></td>
    <td nowrap="nowrap" rowspan="2"><p><strong>KPI </strong></p></td>
    <td rowspan="2"><p><strong>KPI Measurement</strong></p></td>
  </tr>
  <tr> </tr>
  <tr>
    <td><p>Time</p></td>
    <td><p align="center">20%</p></td>
    <td><p align="center">20%</p></td>
    <td><p>Setup Timeliness</p></td>
    <td><p>Time at which the vendor got to the venue for   setup</p></td>
  </tr>
  <tr>
    <td><p>Interpersonal Relationship</p></td>
    <td><p align="center">10%</p></td>
    <td><p align="center">10%</p></td>
    <td><p> Mutual   respect, Team spirit, Fostering relationship </p></td>
    <td><p>Has a good understanding of our business   objectives and core values</p></td>
  </tr>
  <tr>
    <td rowspan="2"><p>Delivery &amp; Support </p></td>
    <td nowrap="nowrap" rowspan="2"><p align="center">20%</p></td>
    <td nowrap="nowrap"><p align="center">10%</p></td>
    <td><p>Communication</p></td>
    <td><p>Degree to which supplier provides timely   information to influence outcome of CMS events positively</p></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><p align="center">10%</p></td>
    <td><p>Problem Resolution</p></td>
    <td><p>Suppliers has the ability to cope, respond to or   handle late approvals, changes, cancellations and inform you of crucial  deadlines and developments in good time.</p></td>
  </tr>
  <tr>
    <td nowrap="nowrap" rowspan="2"><p>Quality</p></td>
    <td nowrap="nowrap" rowspan="2"><p align="center">20%</p></td>
    <td nowrap="nowrap"><p align="center">10%</p></td>
    <td rowspan="2"><p>Technical Expertise</p></td>
    <td><p>Events management    of a consistently high standard in terms of effect on expected results</p></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><p align="center">10%</p></td>
    <td><p>Supplier displays leading-edge technical   expertise and robust understanding of world class events production and   activations</p></td>
  </tr>
  <tr>
    <td rowspan="2"><p>Professionalism</p></td>
    <td nowrap="nowrap" rowspan="2"><p align="center">30%</p></td>
    <td nowrap="nowrap"><p align="center">5%</p></td>
    <td rowspan="2"><p>Provision of Innovative Solutions</p></td>
    <td><p>Is proactive and takes constructive initiatives</p></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><p align="center">5%</p></td>
    <td><p>Degree to which supplier proactively provides   valuable, innovative, and on-target events and activations  solutions </p></td>
  </tr>
  <tr>
      <td>&nbsp;</td>
  </tr>
  <tr>
     <td>
      <p>Preferred suppliers (maximum of 3)</p>
      <select class="select2" multiple name="supplier1">
          <?php 
            
            $rows = getSupplierByService("dj");
          
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
      <td><a class="btn btn-primary" onclick="submitBrief('djBrief')">Submit Brief</a></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
