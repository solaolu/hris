<form id="dependentForm" method="post" enctype="multipart/form-data">
<?php if (isset($_GET['form']) && $_GET['form']=="new") { ?>
      <p>
       Type of Dependent<br />
       <select class="select2" name="dependentCode" >
           <option value="" selected>Dependent Code</option>
           <option value="1">Spouse</option>
           <option value="2">Child</option>
       </select>
   </p>
   <p>
       <input type="text" name="name" placeholder="Dependent's Full name" class="form-control" size="30" />
   </p>
   <p>
      <input type="text" name="dob" class="form-control date-picker" placeholder="Date of Birth" />
   </p>
   <p>
      <select class="select2" name="gender">
         <option value="" selected>Gender</option>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
      </select>
   </p>
   <!--<p>Dependent's Photograph: <input type="file" name="photo" class="form-control"></p>-->
   <p>&nbsp;</p>
   <fieldset>
      <legend>Medical Records</legend>
      <select name="genotype" class="select2">
         <option value="">Genotype</option>
         <option value="AA">AA</option>
         <option value="AS">AS</option>
         <option value="SS">SS</option>
      </select>
      <br /><br />
      <select class="select2" name="bloodGroup">
         <option value="">Blood Group</option>
         <option value="A+">A+</option>
         <option value="A-">A-</option>
         <option value="AB+">AB+</option>
         <option value="AB-">AB-</option>
         <option value="B+">B+</option>
         <option value="B-">B-</option>
         <option value="O+">O+</option>
      </select>
      <br />&nbsp;
      <p>
         Known Medical Condition(s):<br><textarea class="form-control" name="medicalConditions" cols="35"></textarea>
      </p>
      <input type="text" name="hospitalName" placeholder="Preferred Hospital Name" class="form-control" size="30" ><br>
      <input type="text" name="hospitalAddress" placeholder="Hospital Address" class="form-control" size="30" >
   </fieldset>
  <?php } else { ?> 
   <input name="ID" value="${ID}" type="hidden" />
      <p>
       Type of Dependent<br />
       <select class="select2" name="dependentCode" >
           <option value="${dependentCode}" selected>${dependentCode==1?'Spouse':'Child'}</option>
           <option value="1">Spouse</option>
           <option value="2">Child</option>
       </select>
   </p>
   <p>
       <input type="text" name="name" placeholder="Dependent's Full name" class="form-control" size="30" value="${name}">
   </p>
   <p>
      <input type="text" name="dob" class="form-control date-picker" placeholder="Date of Birth" value="${dob}" />
   </p>
   <p>
      <select class="select2" name="gender">
         <option value="${gender}" selected>${gender}</option>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
      </select>
   </p>
   <!--<p>Dependent's Photograph: <input type="file" name="photo" class="form-control"></p>-->
   <p>&nbsp;</p>
   <fieldset>
      <legend>Medical Records</legend>
      <select name="genotype" class="select2">
         <option value="${genotype}">${genotype}</option>
         <option value="AA">AA</option>
         <option value="AS">AS</option>
         <option value="SS">SS</option>
      </select>
      <br /><br />
      <select class="select2" name="bloodGroup">
         <option value="${bloodGroup}">${bloodGroup}</option>
         <option value="A+">A+</option>
         <option value="A-">A-</option>
         <option value="AB+">AB+</option>
         <option value="AB-">AB-</option>
         <option value="B+">B+</option>
         <option value="B-">B-</option>
         <option value="O+">O+</option>
      </select>
      <br />&nbsp;
      <p>
         Known Medical Condition(s):<br><textarea class="form-control" name="medicalConditions" cols="35">${medicalConditions}</textarea>
      </p>
      <input type="text" name="hospitalName" placeholder="Preferred Hospital Name" class="form-control" size="30" value="${hospitalName}"><br>
      <input type="text" name="hospitalAddress" placeholder="Hospital Address" class="form-control" size="30" value="${hospitalAddress}">
   </fieldset>
<?php } ?>   
</form>