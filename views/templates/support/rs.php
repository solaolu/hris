<?php //echo getcwd(); 
require_once("../../../classes/dao.php");  
require_once('suppliers.php');
?>
 <h2><strong>RESEARCH &amp; STRATEGY BRIEF TEMPLATE</strong></h2>

 <form method="post" id="rsBrief" action="create_tbl.php?t=researchRequest_tbl">
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><strong>Name   of Client</strong></td>
    <td><p><strong>
      <input class="form-control" name="ClientName" type="text" id="ClientName" size="50" />
    &nbsp;</strong></p></td>
  </tr>
  <tr>
    <td><p><strong>Project   Name</strong></p></td>
    <td><p>
      <input class="form-control" name="ProjectName" type="text" id="ProjectName" size="50" />
    </p></td>
  </tr>
  <tr>
    <td><p><strong>Project   Location</strong></p></td>
    <td><p>
      <input class="form-control" name="ProjectLocation" type="text" id="ProjectLocation" size="50" />
    </p></td>
  </tr>
  <tr>
    <td><p><strong>Project   Date</strong></p></td>
    <td><p>
      <input type="text" name="ProjectDate" class='datepicker form-control' id="ProjectDate" />
    </p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>The Brief document must provide the following information:</p>
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2" valign="top"><p><strong>ELEMENT</strong></p></td>
    <td valign="top"><p><strong>DETAILS</strong></p></td>
  </tr>
  <tr>
    <td valign="top"><p>1</p></td>
    <td valign="top"><p><strong>Background</strong></p></td>
    <td valign="top"><label for="Background"></label>
    <textarea class="form-control" name="Background" id="Background" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>2</p></td>
    <td valign="top"><p><strong>Project Objective &amp; Deliverables</strong></p>
      <ul>
        <li><em>Brand and business objectives</em></li>
        <li><em>This provides detailed information of   each task expected to be carried out.</em></li>
        <li><em>The expected deliverables the project   is to achieve (bullet points)</em></li>
      </ul></td>
    <td valign="top"><label for="ProjectObjectives"></label>
    <textarea class="form-control" name="ProjectObjectives" id="ProjectObjectives" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>&nbsp;</p></td>
    <td valign="top"><p><strong>Idea   / Key Communication</strong><br />
      <em>The   most important line of</em> communication<strong></strong></p></td>
    <td valign="top"><label for="KeyCommunication"></label>
    <textarea class="form-control" name="KeyCommunication" id="KeyCommunication" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>&nbsp;</p></td>
    <td valign="top"><p><strong>Scope   and Mechanics (if available or as decided by client)</strong></p></td>
    <td valign="top"><label for="Scope"></label>
    <textarea class="form-control" name="Scope" id="Scope" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>3</p></td>
    <td valign="top"><p><strong>Marketing   Rationale</strong></p>
      <ul>
        <li><em>Information on the need for marketing   activities</em></li>
        <li><em>Current market landscape and   competitive market analysis</em></li>
      </ul></td>
    <td valign="top"><label for="MarketingRationale"></label>
    <textarea class="form-control" name="MarketingRationale" id="MarketingRationale" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>4</p></td>
    <td valign="top"><p><strong>Target   Audience</strong></p>
      <ul>
        <li><em>The categorization of people the   project is focusing on</em></li>
      </ul></td>
    <td valign="top"><label for="TargetAudience"></label>
    <textarea class="form-control" name="TargetAudience" id="TargetAudience" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>5</p></td>
    <td valign="top"><p><strong>Consumer   Insight (if available or as seen by the client)</strong></p></td>
    <td valign="top"><label for="CustomerInsight"></label>
    <textarea class="form-control" name="CustomerInsight" id="CustomerInsight" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>7</p></td>
    <td valign="top"><p><strong>Measurement   &amp; Evaluation / KPI</strong></p>
      <ul>
        <li><em>The elements to determine the   performance and success rate of the project (Qualitative and Quantitative)</em></li>
      </ul></td>
    <td valign="top"><label for="Measurement"></label>
    <textarea class="form-control" name="Measurement" id="Measurement" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td valign="top"><p>8</p></td>
    <td valign="top"><p><strong>Timeline</strong></p>
      <ul>
        <li><em>The date for submission of   proposal/revert</em></li>
      </ul></td>
    <td valign="top"><label for="Timeline"></label>
    <input type="text" name="Timeline" class='datepicker form-control' id="Timeline" /></td>
  </tr>
  <tr>
      <td>&nbsp;</td>
  </tr>
  <tr>
     <td>
      <p>Preferred suppliers (maximum of 3)</p>
      <select class="select2" multiple name="supplier1">
          <?php 
            
            $rows = getSupplierByService("research");
          
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
      <td><a class="btn btn-primary" onclick="submitBrief('rsBrief')">Submit Brief</a></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
