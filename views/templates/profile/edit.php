<?php
session_start();
$companyID = $_SESSION['user__info']['companyID'];
$profile = $_SESSION['profile'];
?>
 <h4>EDIT PROFILE</h4>
 <hr size=1 />
  <form id="profileForm" method="post" enctype="multipart/form-data">
   <div class='container'>
       <div class=row>
           <div  class='col-md-4' >Staff ID<br><input type=text class='form-control' name='employeeID' value='<?php echo $profile['employeeID']; ?>' size='32' title='Staff ID' label='Staff ID' /><br>    </div>
        </div>
       <div class=row>
           <div  class='col-md-4' >Firstname<br><input type=text class='form-control' name='firstname' value='<?php echo $profile['firstname']; ?>' size='32' title='Firstname' label='Firstname' /><br>    </div>  
          <div  class='col-md-4' >Lastname<br><input type=text class='form-control' name='lastname' value='<?php echo $profile['lastname']; ?>' size='32' title='Lastname' label='Lastname' /><br>    </div>
           <div  class='col-md-4' >Middlename<br><input type=text class='form-control' name='middlename' value='<?php echo $profile['middlename']; ?>' size='32' title='Middlename' label='Middlename' /><br>    </div>
       </div>
       <div class=row>
           <div  class='col-md-4' >Date of Birth<br><input type=text class='form-control date-picker' name='dob' value='<?php echo $profile['dob']; ?>' size='32' title='' label='Date of Birth' /><br>    </div>
           <div  class='col-md-4' >Phone Number<br><input type=text class='form-control' name='phonenumber' value='<?php echo $profile['phonenumber']; ?>' size='32' title='Phonenumber' label='Phonenumber' /><br>    </div>
           <div  class='col-md-4' >Personal Email<br><input type=text class='form-control' name='personalEmail' value='<?php echo $profile['personalEmail']; ?>' size='32' title='Personal Email' label='Personal Email' /><br>    </div>
       </div>
       <div class=row>
           <div  class='col-md-4' >
              Marital Status<br />
               <select name='maritalStatus' class="select2">
                   <option value='Single' <?php if ($profile['maritalStatus']=='Single') echo "Selected"; ?> >Single</option>
                   <option value='Married' <?php if ($profile['maritalStatus']=='Married') echo "Selected"; ?>>Married</option>
               </select>
           </div>
            <div class='col-md-4' >Home City<br><input type=text class='form-control' name='homeCity' value='<?php echo $profile['homeCity']; ?>' size='32' title='Home City' label='Home City' /><br>    </div>
            <div  class='col-md-4' >Home State<br><input type=text class='form-control' name='homeState' value='<?php echo $profile['homeState']; ?>' size='32' title='Home State' label='Home State' /><br>    </div>
        </div>
        <div class=row>
            <div  class='col-md-6' ><p>Home Address<br/><textarea class='form-control' name='homeAddress' cols=35 rows=6><?php echo $profile['homeAddress']; ?></textarea></p>    </div>
        </div>
        <div class=row>
            <div class="col-md-4"  >Last Qualification Obtained<br><input type=text class='form-control' name='lastQualification' value='<?php echo $profile['lastQualification']; ?>' size='32' title='Last Qualification Obtained' label='Last Qualification Obtained' /><br>    </div>
            <div class="col-md-4">Course Studied<br><input type=text class='form-control' name='courseStudied' value='<?php echo $profile['courseStudied']; ?>' size='32' title='Course Studied' label='Course Studied' /><br>    </div>
            <div class="col-md-4">Last Institution Attended<br><input type=text class='form-control' name='institution' value='<?php echo $profile['institution']; ?>' size='32' title='Last Institution Attended' label='Last Institution Attended' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-4"><p>Trainings Attended<br/><textarea class='form-control' name='trainings' cols=35 rows=6><?php echo $profile['trainings']; ?></textarea></p>    </div>
        </div>
        <div class=row>
            <div class="col-md-6"><p>Professional Certifications<br/><textarea class='form-control' name='professionalCerts' cols=35 rows=6><?php echo $profile['professionalCerts']; ?></textarea></p>    </div>
            <div  class="col-md-6"><p>Professional Membership<br/><textarea class='form-control' name='professionalMembership' cols=35 rows=6><?php echo $profile['professionalMembership']; ?></textarea></p>    </div>
        </div>
        <div class=row>
            <div  class="col-md-4">Next of Kin Name (1)<br><input type=text class='form-control' name='nokName1' value='<?php echo $profile['nokName1']; ?>' size='32' title='Next of Kin Name (1)' label='Next of Kin Name (1)' /><br>   </div>
            <div class="col-md-4">Next of Kin Relationship (1)<br><input type=text class='form-control' name='nokRelationship1' value='<?php echo $profile['nokRelationship1']; ?>' size='32' title='Next of Kin Relationship (1)' label='Next of Kin Relationship (1)' /><br>    </div>
            
            <div  class='col-md-4' >Next of Kin Phone Number (1)<br><input type=text class='form-control' name='nokPhone1' value='<?php echo $profile['nokPhone1']; ?>' size='32' title='Next of Kin Phone Number (1)' label='Next of Kin Phone Number (1)' /><br>    </div>
        </div>
        <div class=row>
            <div  class='col-md-6' ><p>Next of Kin Address (1)<br/><textarea class='form-control' name='nokAddress1' cols=35 rows=6><?php echo $profile['nokAddress1']; ?></textarea></p>    </div>
        </div>
        <!--<div class=row>
            <div class="col-md-4" >Next of Kin Name (2)<br><input type=text class='form-control' name='nokName2' value='<?php echo $profile['nokName2']; ?>' size='32' title='Next of Kin Name (2)' label='Next of Kin Name (2)' /><br>   </div>
            <div class="col-md-4" >Next of Kin Relationship (2)<br><input type=text class='form-control' name='nokRelationship2' value='<?php echo $profile['nokRelationship2']; ?>' size='32' title='Next of Kin Relationship (2)' label='Next of Kin Relationship (2)' /><br>    </div>
            <div class="col-md-4" >Next of Kin Phone Number (2)<br><input type=text class='form-control' name='nokPhone2' value='<?php echo $profile['nokPhone2']; ?>' size='32' title='Next of Kin Phone Number (2)' label='Next of Kin Phone Number (2)' /><br>    </div>
        </div>
        <div class=row>
            <div  class='col-md-6' ><p>Next of Kin Address (2)<br/><textarea class='form-control' name='nokAddress2' cols=35 rows=6><?php echo $profile['nokAddress2']; ?></textarea></p>    </div>
        </div>-->
        <div class=row>
            <div class="col-md-4"  >Referee Name<br><input type=text class='form-control' name='refName' value='<?php echo $profile['refName']; ?>' size='32' title='Referee Name' label='Referee Name' /><br>    </div>
            <div  class='col-md-4' >Referee EMail<br><input type=text class='form-control' name='refEmail' value='<?php echo $profile['refEmail']; ?>' size='32' title='Referee EMail' label='Referee EMail' /><br>    </div>
            <div class="col-md-4" >Referee Phone Number<br><input type=text class='form-control' name='refPhone' value='<?php echo $profile['refPhone']; ?>' size='32' title='Referee Phone Number' label='Referee Phone Number' /><br>   </div>
        </div>
        <div class=row>
            <div class="col-md-6" >Referee Address<br><input type=text class='form-control' name='refAddress' value='<?php echo $profile['refAddress']; ?>' size='32' title='Referee Address' label='Referee Address' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-4"  >Referee (2) Name<br><input type=text class='form-control' name='refName2' value='<?php echo $profile['refName2']; ?>' size='32' title='Referee (2) Name' label='Referee (2) Name' /><br>    </div><div class="col-md-4" >Referee (2) Phone Number<br><input type=text class='form-control' name='refPhone2' value='<?php echo $profile['refPhone2']; ?>' size='32' title='Referee (2) Phone Number' label='Referee (2) Phone Number' /><br>    </div>
            <div class="col-md-4">Referee (2) EMail<br><input type=text class='form-control' name='refEmail2' value='<?php echo $profile['refEmail2']; ?>' size='32' title='Referee (2) EMail' label='Referee (2) EMail' /><br>    </div>
        </div>
        <div class="row">
            <div  class="col-md-6" >Referee (2) Address<br><input type=text class='form-control' name='refAddress2' value='<?php echo $profile['refAddress2']; ?>' size='32' title='Referee (2) Address' label='Referee (2) Address' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-4" > Referee(3) Name<br><input type=text class='form-control' name='refAName3' value='<?php echo $profile['refAName3']; ?>' size='32' title=' Referee(3) Name' label=' Referee(3) Name' /><br>    </div><div  class="col-md-4" >Ref Email3<br><input type=text class='form-control' name='refEmail3' value='<?php echo $profile['refEmail3']; ?>' size='32' title='Ref Email3' label='Ref Email3' /><br>    </div>
            <div class="col-md-4" >Ref Phone3<br><input type=text class='form-control' name='refPhone3' value='<?php echo $profile['refPhone3']; ?>' size='32' title='Ref Phone3' label='Ref Phone3' /><br>    </div>
        </div>
        <div class="row">
            <div class="col-md-4" >Previous Employer<br><input type=text class='form-control' name='previousEmployer' value='<?php echo $profile['previousEmployer']; ?>' size='32' title='Previous Employer' label='Previous Employer' /><br>    </div>
            <div class="col-md-4" >Previous Employer Contact Email<br><input type=text class='form-control' name='pEmployerEmail' value='<?php echo $profile['pEmployerEmail']; ?>' size='32' title='Previous Employer Contact Email' label='Previous Employer Contact Email' /><br>    </div>
            <div class="col-md-4"  >Previous Employer Contact Phone<br><input type=text class='form-control' name='pEmployerPhone' value='<?php echo $profile['pEmployerPhone']; ?>' size='32' title='Previous Employer Contact Phone' label='Previous Employer Contact Phone' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-6" >Previous Employer Contact Address<br/><textarea class='form-control' name='pEmployerAddress' cols=35 rows=6><?php echo $profile['pEmployerAddress']; ?></textarea>    </div>
        </div>
        <div class=row>
            <div  class='col-md-4' >Bank Name<br><input type=text class='form-control' name='bankName' value='<?php echo $profile['bankName']; ?>' size='32' title='Bank Name' label='Bank Name' /><br>    </div>
            <div class="col-md-4" >Bank Branch<br><input type=text class='form-control' name='bankBranch' value='<?php echo $profile['bankBranch']; ?>' size='32' title='Bank Branch' label='Bank Branch' /><br>    </div>
            <div  class='col-md-4' >NUBAN Number<br><input type=text class='form-control' name='NubanNumber' value='<?php echo $profile['NubanNumber']; ?>' size='32' title='Nuban Number' label='Nuban Number' /><br>    </div>
        </div>
        <div class=row>
            <div  class='col-md-4' >Account Name<br><input type=text class='form-control' name='AccountName' value='<?php echo $profile['AccountName']; ?>' size='32' title='Account Name' label='Account Name' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-6" >Pension Administrator Name<br><input type=text class='form-control' name='pensionAdministratorName' value='<?php echo $profile['pensionAdministratorName']; ?>' size='32' title='Pension Administrator Name' label='Pension Administrator Name' /><br>    </div>
            <div class="col-md-6" >Pension Administrator Account Number<br><input type=text class='form-control' name='pensionAdministratorAccountNumber' value='<?php echo $profile['pensionAdministratorAccountNumber']; ?>' size='32' title='Pension Administrator Account Number' label='Pension Administrator Account Number' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-4">Resumption Date<br><input type=text class='form-control date-picker' name='resumptionDate' value='<?php echo $profile['resumptionDate']; ?>' size='32' title='' label='Resumption Date' /><br> </div>
        </div>
        <?php 
        $workTools = explode(", ", $profile['workToolsInPossession']);
        if ($companyID!=8) { ?>
        <div class=row>
            <div class="col-md-8" ><table width=70%><tr><td colspan=1><strong>Work Tools In Possession</strong><td></tr><tr><td><label><input name="workToolsInPossession" type="checkbox" value="Blackberry" <?php if (in_array("Blackberry",$workTools)) echo "checked"; ?> >&nbsp;Blackberry</label>&nbsp;&nbsp;<label><input name="workToolsInPossession" type="checkbox" value="Official Car" <?php if (in_array("Official Car",$workTools)) echo "checked"; ?>>&nbsp;Official Car</label>&nbsp;&nbsp;<label><input name="workToolsInPossession" type="checkbox" value="Laptop" <?php if (in_array("Laptop",$workTools)) echo "checked"; ?>>&nbsp;Laptop</label>&nbsp;&nbsp;<label><input name="workToolsInPossession" type="checkbox" value="Laptop Bag" <?php if (in_array("Laptop Bag",$workTools, TRUE)) echo "checked"; ?>>&nbsp;Laptop Bag</label>&nbsp;&nbsp;<label><input name="workToolsInPossession" type="checkbox" value="ID Card" <?php if (in_array("ID Card",$workTools)) echo "checked"; ?>>&nbsp;ID-card</label></td></tr></table>    </div>
            <div class="col-md-4" >Laptop Serial No<br><input type=text class='form-control' name='laptopSerialNo' value='<?php echo $profile['laptopSerialNo']; ?>' size='32' title='Laptop Serial No' label='Laptop Serial No' /><br>    </div>
        </div>
        <?php } else {?>
        <div class=row>
            <div class="col-md-8" ><table width=70%><tr><td colspan=1><strong>Work Tools In Possession</strong><td></tr><tr><td><label><input name="workToolsInPossession" type="checkbox" value="Samsung Phone" <?php if (in_array("Samsung Phone",$workTools)) echo "checked"; ?>>&nbsp;Samsung Phone</label>&nbsp;&nbsp;<label><input name="workToolsInPossession" type="checkbox" value="Laptop" <?php if (in_array("Laptop",$workTools)) echo "checked"; ?>>&nbsp;Laptop</label>&nbsp;&nbsp;<label><input name="workToolsInPossession" type="checkbox" value="Laptop Bag" <?php if (in_array("Laptop Bag",$workTools)) echo "checked"; ?>>&nbsp;Laptop Bag</label>&nbsp;&nbsp;<label><input name="workToolsInPossession" type="checkbox" value="ID Card" <?php if (in_array("ID-Card",$workTools)) echo "checked"; ?>>&nbsp;ID-card</label></td></tr></table>    </div>
            <div class="col-md-4" >Laptop Serial No<br><input type=text class='form-control' name='laptopSerialNo' value='<?php echo $profile['laptopSerialNo']; ?>' size='32' title='Laptop Serial No' label='Laptop Serial No' /><br>    </div>
        </div>
        <div class="row">
            <div class="col-md-4">
               Work Tools Details (1)<br/>
                <textarea class="form-control" name="workToolsInfo1" rows='5' title="Device Information (1)" placeholder="Device Information (1)"><?php echo $profile['workToolsInfo1']; ?></textarea>
            </div>
            <div class="col-md-4">
               Work Tools Details (2)<br/>
                <textarea class="form-control" name="workToolsInfo2" rows='5' title="Device Information (2)" placeholder="Device Information (2)"><?php echo $profile['workToolsInfo2']; ?></textarea>
            </div>
            <div class="col-md-4">
               Work Tools Details (3)<br/>
                <textarea class="form-control" name="workToolsInfo3" rows='5' title="Device Information (3)" placeholder="Device Information (3)"><?php echo $profile['workToolsInfo3']; ?></textarea>
            </div>
        </div>
        <div class=row>
            <div class="col-md-4">Personal Code<small><em>(MCS Code)</em></small> <br><input type=text class='form-control' name='personalCode' value='<?php echo $profile['personalCode']; ?>' size='32' title='Personal Code' label='Personal Code' /><br>   </div>
            <div class="col-md-4"  >CUG Number<br><input type=text class='form-control' name='CUGNumber' value='<?php echo $profile['CUGNumber']; ?>' size='32' title='CUG Number' label='CUG Number' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-4" >Designation<br><input type=text class='form-control' name='designation' value='<?php echo $profile['designation']; ?>' size='32' title='Designation' label='Designation' /><br>    </div>
            <div class="col-md-4" >Work Status<br><input type=text class='form-control' name='workStatus' value='<?php echo $profile['workStatus']; ?>' size='32' title='Work Status' label='Work Status' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-4"  >Outlet Covering<br><input type=text class='form-control' name='outletCovering' value='<?php echo $profile['outletCovering']; ?>' size='32' title='Outlet Covering' label='Outlet Covering' /><br>    </div>
            <div class="col-md-4" >Outlet Code<br><input type=text class='form-control' name='outletCode' value='<?php echo $profile['outletCode']; ?>' size='32' title='Outlet Code' label='Outlet Code' /><br>    </div>
            <div class="col-md-4" >
                  Outlet Location
                   <select name='outletLocation' class="select2">
                       <option value='<?php echo $profile['outletLocation']; ?>' selected><?php echo $profile['outletLocation']; ?></option>
                       <option value='Lagos'>Lagos</option>
                       <option value="Oyo">Oyo</option>
                       <option value="Osun">Osun</option>
                       <option value="Ogun">Ogun</option>
                       <option value="Edo">Edo</option>
                       <option value="Ondo">Ondo</option>
                       <option value="Ekiti">Ekiti</option>
                       <option value="Delta">Delta</option>
                    </select>  
            </div>
        </div>
        <div class=row>
            <div class="col-md-6" >Outlet Address<br/><textarea class='form-control' name='outletAddress' cols=35 rows=6><?php echo $profile['outletAddress']; ?></textarea></div>
            <div class="col-md-6"  >Outlet Region<br><input type=text class='form-control' name='outletRegion' value='<?php echo $profile['outletRegion']; ?>' size='32' title='Outlet Region' label='Outlet Region' /><br>    </div>
        </div>
        <div class=row>
            <div class="col-md-6" ><p>Guarantor Details (1)<br/><textarea class='form-control' name='guarantorDetails1' cols=35 rows=6><?php echo $profile['guarantorDetails1']; ?></textarea></p>    </div>
            <div class="col-md-6" ><p>Guarantor Details (2)<br/><textarea class='form-control' name='guarantorDetails2' cols=35 rows=6><?php echo $profile['guarantorDetails2']; ?></textarea></p>    </div>
        </div>
        <div class=row>
            <div class="col-md-6" >Skype Name<br><input type=text class='form-control' name='skypeName' value='<?php echo $profile['skypeName']; ?>' size='32' title='Skype Name' label='Skype Name' /><br>    </div>
        </div>  
        <?php } ?>  
        <div class=row>
            <div class="col-md-4" >Passport Photograph: <br><input class='form-control' type=file name='photograph' /><br>    </div>
        </div>
   <p>&nbsp;</p>
   
   <p><input type="reset" class="reset hide"></p>
   <a class="btn btn-primary" onclick="saveProfile('update')">Save Profile Changes</a>&nbsp;&nbsp;<a class="btn btn-danger" onclick="$('#profileForm .reset').click();">Reset</a>
   <p></p>
   </div>
</form>
                    <!-- <div class="modal fade" id="dependentModal" data-keyboard="false">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header"><h5>Add New Dependent</h5></div>
                                <div class="modal-body">
                                    <form id="dependentForm" method="post" enctype="multipart/form-data">
                                       <p>
                                           Type of Dependent<br />
                                           <select class="select2" name="dependentCode" >
                                               <option value="1">Spouse</option>
                                               <option value="2">Child</option>
                                           </select>
                                       </p>
                                       <p>
                                           <input type="text" name="name" placeholder="Dependent's Full name" class="form-control" size="30">
                                       </p>
                                       <p>
                                          <input type="text" class="form-control datepicker" placeholder="Date of Birth" />
                                       </p>
                                       <p>
                                          <select class="select2" name="gender">
                                             <option value="">Gender</option>
                                             <option value="male">Male</option>
                                             <option value="female">Female</option>
                                          </select>
                                       </p>
                                       <p>Dependent's Photograph: <input type="file" name="photo" class="form-control"></p>
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
                                          <input type="text" name="hospitalName" placeholder="Preferred Hospital Name" class="form-control" size="30"><br>
                                          <input type="text" name="hospitalAddress" placeholder="Hospital Address" class="form-control" size="30">
                                       </fieldset>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-link" onclick="addDependent()" >Add Dependent</button>
                                </div>
                            </div>
                        </div>
                    </div> -->