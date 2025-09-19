<?php //echo getcwd(); 
require_once("../../../classes/dao.php");  
require_once('suppliers.php');
?>
<h2>LOGO DESIGN CREATIVE BRIEF</h2>
<form id="logoBrief" method="post" action="create_tbl.php?t=logoRequest_tbl">
<table>
    <tr>
        <td>
<p>Idea/Business/Venture name. <br />
  <label for="Name"></label>
  <input class="form-control" name="Name" type="text" id="Name" size="50" />
</p>
<p>Slogan/tagline. (Even if not finalised. Any ideas you have at present.)<br />
  <label for="Slogan"></label>
  <input class="form-control" name="Slogan" type="text" id="Slogan" size="50" />
  <br />
  <br /> 
<strong>Overview/Background </strong></p>
<ol>
  <li>Describe the business entity, its purpose/mission/vision/reason for being.<br />
    <label for="Description"></label>
    <textarea class="form-control" name="Description" id="Description" cols="50" rows="5"></textarea>
    <br />
    <br />
  </li>
  <li>What is the entity&rsquo;s structure? (sole corporation, subsidiary, franchisor, joint venture, etc.)<br />
    <label for="structure"></label>
    <input class="form-control" name="structure" type="text" id="structure" size="50" />
    <br />
    <br />
  </li>
  <li>    What products/services does the entity provide? Will these products/services be branded separately from the entity brand or will they &ldquo;reside&rdquo; under the entity brand?<br />
    <label for="provides"></label>
    <input class="form-control" name="provides" type="text" id="provides" size="50" />
    <br />
    <br />
  </li>
  <li>What market(s) does the entity compete in?<br />
    <label for="market"></label>
    <input class="form-control" name="market" type="text" id="market" size="50" />
    <br />
    <br />
  </li>
  <li>Who are the competitors? If possible, please provide the names, links to websites and descriptions of their products/services.<br />
    <label for="competitors"></label>
    <input class="form-control" name="competitors" type="text" id="competitors" size="50" />
    <br />
    <br />
  </li>
  <li>Within each served market, describe the major buying influences. Include demographics &amp; lifestyles for consumers. Include customer motivations, habits and as much demographic as possible for your market and its customers. <br />
    <label for="influences"></label>
    <input class="form-control" name="influences" type="text" id="influences" size="50" />
    <br />
    <br />
  </li>
  <li>What are the key features and characteristics that differentiate this entity from its competitors?<br />
    <label for="features"></label>
    <textarea class="form-control" name="features" id="features" cols="45" rows="5"></textarea>
    <br />
    <br />
  </li>
  <li>
    What colour(s) best describe the entity and why? 
    <br />
    <label for="color"></label>
    <input class="form-control" name="color" type="text" id="color" size="50" />
  </li>
</ol>
<p>&nbsp;</p>
<p><strong>Logo Functions &amp; Description</strong></p>
<ol>
  <li>Below is a list of characteristics and attributes you may use to describe an entity, and to which an entity might aspire. (Please tick the most important/appropriate descriptions that honestly reflect the entity, its vision and culture, while also imparting the &ldquo;image&rdquo; most appropriate in attracting target markets).<br />
    <br />
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Adventurous" />Adventurous</label>
        </em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Cheerful" />Cheerful</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Dependable" />Dependable</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="First-class" />First-class</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Helpful" />Helpful</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Intense" />Intense</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Prestigious" />Prestigious</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Respectful" />Respectful</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Sophisticated" />Sophisticated</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Thrilling" />Thrilling</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Trendy" />Trendy</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Ageless" />Ageless</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Competent" />Competent</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Devoted" />Devoted</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Friendly" />Friendly</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Honest" />Honest</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Likable" />Likable</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Timeless" />Timeless</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Progressive" />Progressive</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Romantic" />Romantic</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Spiritual" />Spiritual</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Trustworthy" />Trustworthy</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Aggressive" />Aggressive</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Competitive" />Competitive</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Excellent" />Excellent</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Fun" />Fun</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Innovative" />Innovative</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Eco-friendly" />Eco-friendly</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Corporate" />Corporate</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Optimistic" />Optimistic</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Protective" />Protective</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Safe" />Safe</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Strong" />Strong</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Timely" />Timely</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Whimsical" />Whimsical</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Brilliant" />Brilliant</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Confident" />Confident</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Exciting" />Exciting</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Happy" />Happy</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Insightful" />Insightful</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Persistent" />Persistent</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Quality" />Quality</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Skillful" />Skillful</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Successful" />Successful</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Tranquil" />Tranquil</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Assertive" />Assertive</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Classic" />Classic</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Energetic" />Energetic</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Healthy" />Healthy</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Joyful" />Joyful</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="No-nonsense" />No-nonsense</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Powerful" />Powerful</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Rare" />Rare</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Sentimental" />Sentimental</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Sympathetic" />Sympathetic</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Virtuous" />Virtuous</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Beautiful" />Beautiful</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Competitive" />Competitive</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Flamboyant" />Flamboyant</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Homestyle" />Homestyle</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Leader-like" />Leader-like</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Nostalgic" />Nostalgic</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Practical" />Practical</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Romantic" />Romantic</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Sparkling" />Sparkling</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Tangy" />Tangy</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Wholesome" />Wholesome</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Bright" />Bright</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Co-operative" />Co-operative</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Flirtatious" />Flirtatious</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Humorous" />Humorous</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Macho" />Macho</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Green/Eco" />Green/Eco</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Passionate" />Passionate</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Protective" />Protective</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Scientific" />Scientific</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Steady" />Steady</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Technical" />Technical</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Woodsy" />Woodsy</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Business-like" />Business-like</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Creative" />Creative</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Futuristic" />Futuristic</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Intellectual" />Intellectual</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Mysterious" />Mysterious</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Patriotic" />Patriotic</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Quick" />Quick</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Elderly" />Elderly</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Subtle" />Subtle</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Striking" />Striking</label></em></p></td>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Youth-oriented" />Youth-oriented</label></em></p></td>
      </tr>
      <tr>
        <td valign="top"><p><em><label><input type="checkbox" name="words" value="Other." />Other.</label></em></p></td>
        <td valign="top"><p>&nbsp;</p></td>
        <td valign="top"><p>&nbsp;</p></td>
        <td valign="top"><p>&nbsp;</p></td>
        <td valign="top"><p>&nbsp;</p></td>
      </tr>
    </table>
    <br />
  </li>
  <li>Please list the applications to which the new logo will be applied.<br />
    <label for="applications"></label>
    <textarea class="form-control" name="applications" cols="50" rows="5" id="applications"></textarea>
    <br />
    <br />
  </li>
  <li>Please outline any direction or specific ideas you may have that you want explored or need included in the final outcome.  (ie Specific colours, symbols/shapes or objects to include).<br />
    <label for="direction"></label>
    <textarea class="form-control" name="direction" cols="50" rows="5" id="direction"></textarea>
  </li>
</ol>
</td>
    </tr>
  <tr>
      <td>&nbsp;</td>
  </tr>
  <tr>
     <td>
      <p>Preferred suppliers (maximum of 3)</p>
      <select class="select2" multiple name="supplier1">
          <?php 
            
            $rows = getSupplierByService("logo");
          
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
      <td><a class="btn btn-primary" onclick="submitBrief('logoBrief')">Submit Brief</a></td>
  </tr>
</table>
</form>