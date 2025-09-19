<?php //echo getcwd(); 
require_once("../../../classes/dao.php");  
require_once('suppliers.php');
?>
<h5>Creative Brief Form for Event / Activation / Special Project</h5>
<p>&nbsp;</p>
<form id="eventsBrief" method="post" action="create_tbl.php?t=eventRequest_tbl">
<p><strong>SECTION 1</strong></p>
<p><strong>1.Who</strong>:&nbsp; Who is the event being held for (target audience?)</p>
<p><input type="text" class="form-control" name="who" size=50 id="who" /></p>
<p><br>
  <strong>2.What</strong>:&nbsp; What kind of event will it be, a seminar or workshop, a conference or symposium, a black-tie dinner or a picnic? (If it&rsquo;s a special project, what is the purpose of your request?)</p>
<p><input type="text" class="form-control" name="what" size=50 id="what" /></p>
<p><br>
  <strong>3.When</strong>:&nbsp; When will the event be held.&nbsp; This includes the date and time as well as how long will the event run for?</p>
<p><input type="text" class="form-control datetime-picker" name="when" size=50 id="when" /></p>
<p><br>
  <strong>4.Where</strong>:&nbsp; Where will the event be held.&nbsp; </p>
<p><input type="text" class="form-control" name="where" size=50 id="where" /></p>
<p><br>
  <strong>5.Why</strong>:&nbsp; Why is the event being held, what is the objective of the event?</p>
<p><input type="text" class="form-control" name="why" size=50 id="why" /></p>
<p>&nbsp;</p>
<p><strong>SECTION 2A</strong><br>
  <em>(Please fill this part if request is for event)</em></p>
<p><strong>Sitting   </strong></p>
<table cellpadding="5" cellspacing="2">
  <tr>
    <td>1.What table arrangement is required?   </td>
    <td><label>
      <input type="radio" name="tablearrangement" value="Banquet" id="tablearrangement_0">
      Banquet</label></td>
    <td><label>
      <input type="radio" name="tablearrangement" value="Classroom" id="tablearrangement_1">
      Classroom</label></td>
    <td><label>
      <input type="radio" name="tablearrangement" value="Theatre" id="tablearrangement_2">
      Theatre</label></td>
  </tr>
  <tr>
    <td align="right">Guest per table </td>
    <td colspan="3"><input type="text" class="form-control" name="guestspertable" id="guestspertable"></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" cellspacing="2" cellpadding="4">
  <tr>
    <td>2. What chair type is required</td>
    <td><input type="text" class="form-control" name="chairtype" id="chairtype"></td>
  </tr>
  <tr>
    <td align="right">Chair Cover </td>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="chaircover" value="Yes" id="chaircover_0">
          Yes</label></td>
        <td><label>
          <input type="radio" name="chaircover" value="No" id="chaircover_1">
          No</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right">Colour</td>
    <td><input type="text" class="form-control" name="chaircolor" id="chaircolor"></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" cellspacing="2" cellpadding="4">
  <tr>
    <td>3.What table shape is required</td>
    <td><table cellpadding="5" cellspacing="2">
      <tr>
        <td><label>
          <input type="radio" name="tableshape" value="Rectangle" id="tableshape_0">
          Rectangle</label></td>
        <td><label>
          <input type="radio" name="tableshape" value="Square" id="tableshape_1">
          Square</label></td>
        <td><label>
          <input type="radio" name="tableshape" value="Circle" id="tableshape_2">
          Circle</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right">Table Cover</td>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="tablecover" value="Yes" id="tablecover_0">
          Yes</label></td>
        <td><label>
          <input type="radio" name="tablecover" value="No" id="tablecover_1">
          No</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right">Colour</td>
    <td><input type="text" class="form-control" name="tablecovercolor" id="tablecovercolor"></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" cellspacing="2" cellpadding="4">
  <tr>
    <td>4. Is a Centre Piece required</td>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="centrepiece" value="Yes" id="centrepiece_0">
          Yes</label></td>
        <td><label>
          <input type="radio" name="centrepiece" value="No" id="centrepiece_1">
          No</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right">if yes, please describe</td>
    <td><input type="text" class="form-control" name="centrepiece" size=50 /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>5.Describe the table top set up</p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p><strong>Decoration</strong><br>
  Is décor required</p>
<p><input type="text" class="form-control" name="" size=50 /></p>
<p>If yes, wall drape or plitting <em>(Please describe)</em></p>
<p><input type="text" class="form-control" name="" size=50 /></p>
<p><strong>Cocktail</strong><br>
  Does the event have a cocktail arm to it?</p>
<table width="200">
  <tr>
    <td><label>
      <input type="radio" name="EventHasCocktail" value="Yes" id="EventHasCocktail_0">
      Yes</label></td>
    <td><label>
      <input type="radio" name="EventHasCocktail" value="No" id="EventHasCocktail_1">
      No</label></td>
  </tr>
</table>
<p>&nbsp; </p>
<p>Do you require Cocktail Stands? <em>(If yes, please describe)</em></p>
<p><textarea class="form-control" name="" rows="5" cols="50" size="50"></textarea></p>
<p>Please describe other experiences that make up the cocktail in detail <em>(Lounge Chairs, table, Sitting Arrangement)</em></p>
<p><textarea class="form-control" name="" rows="5" cols="50" size="50"></textarea></p>
<p><strong>Ushers</strong><br>
  What is their outfit? <em>Please describe for male and female if possible with image</em></p>
<p>
  <textarea class="form-control" name="ushersOutfitDescription" rows="5" cols="50" size="50"></textarea>
</p>
<p><strong>SECTION 2B</strong><br>
<em>(Please fill this part if request is for Activation)</em></p>
<p><strong>Set-up</strong><br>
  1.What is the objective of the activation?</p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p>2.Please list out the expected branded items.</p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p>3.Please describe the layout/floorplan</p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p>4A. What artwork is available?</p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p>4B. If artwork is not available, what creative direction are you looking at for the artwork? <br>
  <em>(Please send a reference picture or web-link)</em></p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p>5A. Please list out the expected merchandise </p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p>5B. Please type of giveaway items are expected</p>
<p><input type="text" class="form-control" name="" size="50" /></p>
<p><strong>SECTION 3</strong><br>
  <strong>Stage Design</strong><br>
  (Conference/Concert/Gala/Launch/Training?)</p>
<p><input type="text" class="form-control" name="" size=50 /></p>
<p>                                                                                                             </p>
<table border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td>Screen Required? </td>
    <td>How many screens?</td>
    <td>Type of screens</td>
  </tr>
  <tr>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="ScreenRequired" value="Yes" id="ScreenRequired_0">
          Yes</label></td>
<td><label>
          <input type="radio" name="ScreenRequired" value="No" id="ScreenRequired_1">
          No</label></td>
      </tr>
    </table></td>
    <td><input type="text" class="form-control" name="ScreenCount" id="ScreenCount"></td>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="screenType" value="LED" id="RadioGroup1_0">
          LED</label></td>
 <td><label>
          <input type="radio" name="screenType" value="Projector" id="RadioGroup1_1">
          Projector</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Backdrop required?</td>
    <td>How many backdrops?</td>
    <td>Artwork available? <em>Shared?</em></td>
  </tr>
  <tr>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="BackdropRequired" value="Yes" id="BackdropRequired_0">
          Yes</label></td>

        <td><label>
          <input type="radio" name="BackdropRequired" value="No" id="BackdropRequired_1">
          No</label></td>
      </tr>
    </table></td>
    <td><input type="text" class="form-control" name="BackdropCount" id="BackdropCount"></td>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="ArtworkAvailable" value="Yes" id="ArtworkAvailable_0">
          Yes</label></td>

        <td><label>
          <input type="radio" name="ArtworkAvailable" value="No" id="ArtworkAvailable_1">
          No</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Panel discussion?</td>
    <td>How many sits are required?</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="PanelDiscussion" value="Yes" id="PanelDiscussion_0">
          Yes</label></td>

        <td><label>
          <input type="radio" name="PanelDiscussion" value="No" id="PanelDiscussion_1">
          No</label></td>
      </tr>
    </table></td>
    <td><input type="text" class="form-control" name="SitsRequired" id="SitsRequired"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Require Screen Monitor for speaker?</td>
    <td colspan="2"><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="ScreenMonitorforSpeaker" value="Yes" id="ScreenMonitorforSpeaker_0">
          Yes</label></td>
        <td><label>
          <input type="radio" name="ScreenMonitorforSpeaker" value="No" id="ScreenMonitorforSpeaker_1">
          No</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Stage Performances</td>
    <td colspan="2"><table width="200">
      <tr>
        <td><label>
          <input type="radio" name="StagePerformance" value="No Stage Performance" id="StagePerformance_0">
          No Stage Performance</label></td>
      </tr>
      <tr>
        <td><label>
          <input type="radio" name="StagePerformance" value="Heavy Stage Performance" id="StagePerformance_1">
          Heavy Stage Performance</label></td>
      </tr>
      <tr>
        <td><label>
          <input type="radio" name="StagePerformance" value="Light Stage Performance" id="StagePerformance_2">
          Light Stage Performance</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Special Effect (Please describe)</td>
    <td colspan="2"><textarea class="form-control" name="SpecialEffect" id="SpecialEffect" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>                        </p>
<p>&nbsp;</p>
<p><strong>SECTION 4</strong><br>
  <strong>Branding</strong><br>
Is the Branding Artwork available? <em>(If No, please request for it CorelDraw/Ai/PSD/EPS format)</em></p>
<table width="200">
  <tr>
    <td><label>
      <input type="radio" name="BrandingArtworkAvailable" value="Yes" id="BrandingArtworkAvailable_0">
      Yes</label></td>

    <td><label>
      <input type="radio" name="BrandingArtworkAvailable" value="No" id="BrandingArtworkAvailable_1">
      No</label></td>
  </tr>
</table>
<p>Has any Supplier/Vendor been engaged</p>
<table>
  <tr>
    <td><label>
      <input type="radio" name="EngagedSupplier" value="Yes" id="EngagedSupplier_0">
      Yes</label>
      , <em>please     share contact details below: </em><br>      <textarea class="form-control" name="EngagedSupplierContactInfo" cols="50" rows="5" id="EngagedSupplierContactInfo"></textarea></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="EngagedSupplier" value="No" id="EngagedSupplier_1">
      No</label></td>
  </tr>
</table>
<p>Is the Branding Plan required?</p>
<table>
  <tr>
    <td><label>
      <input type="radio" name="BrandingPlan" value="Yes" id="EngagedSupplier_2">
      Yes</label>
      , <em>please indicate budget below:</em>
      <br>
      <input name="BrandingBudget" class="form-control" type="text" id="BrandingBudget" value="" size="50"></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="BrandingPlan" value="No" id="EngagedSupplier_3">
      No</label></td>
  </tr>
</table>
<p> Is Recce done? </p>
<table>
  <tr>
    <td colspan="2"><label>
      <input type="radio" name="EngagedSupplier" value="Yes" id="EngagedSupplier_4">
      Yes</label>, <em>please email pictures and dimensions</em><br></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="EngagedSupplier" value="No" id="EngagedSupplier_5">
      No</label></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>Is Recce done?</p>
<table>
  <tr>
    <td><label>
      <input type="radio" name="RecceDone" value="Yes" id="EngagedSupplier_6">
      Yes</label>      
      <br></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="RecceDone" value="No" id="EngagedSupplier_7">
      No, <em>please share site contact person details  <br>
      <textarea class="form-control" name="RecceContact" cols="50" rows="5" id="RecceContact"></textarea>
      </em></label></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><strong>SECTION 5</strong><br>
  <strong>Multimedia</strong><br>
1.What is the multimedia requirement for this project?</p>
<p><input type="text" class="form-control" name="" size=50 /></p>
<p>2.Are these requirements readily available? </p>
<table>
  <tr>
    <td><label>
      <input type="radio" name="MultimediaRequirementsAvailable" value="Yes" id="MultimediaRequirementsAvailable_0">
      Yes (please send by mail)</label></td>
  </tr>
  <tr>
    <td><label>
      <input type="radio" name="MultimediaRequirementsAvailable" value="No" id="MultimediaRequirementsAvailable_1">
      No (Please request for the multimedia materials and send)</label></td>
  </tr>
  <tr>
      <td>&nbsp;</td>
  </tr>
  <tr>
     <td>
      <p>Preferred suppliers (maximum of 3)</p>
      <select class="select2" multiple name="supplier1">
          <?php 
            
            $rows = getSupplierByService("events");
          
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
      <td><a class="btn btn-primary" onclick="submitBrief('eventsBrief')">Submit Brief</a></td>
  </tr>
</table>
</form>
