<table cellspacing="1" cellpadding="5" width=100%>
<tr valign="top"><tD align="right">Employee ID:</tD><td><input type="text" value="${employeeID}" class="form-control" /></td></tr>
<tr><td colspan=6 align="right" valign="top"></td><td rowspan=10 valign="top"><img src="../../../uploads/profiles/${photograph}" border=1 width=150 /></td></tr>
  <tr valign="top">
    <td align="right" width="14%">First Name:</td>
    <td width="14%"><input type="text" name="firstname" value="${firstname}" class="form-control" /></td>
    <td align="right" width="14%">Last Name:</td>
    <td width="14%"><input type="text" name="lastname" value="${lastname}" class="form-control" /></td>
    <td align="right" width="14%">Middle Name:</td>
    <td width="14%"><input type="text" name="middlename" value="${middlename}" class="form-control" /></td>
  </tr>
  <tr valign="top">
    <td align="right">Date of Birth: </td>
    <td><input type="text" value="${dob}" name="dob" class="form-control date-picker" /></td>
    <td align="right">Marital Status: </td>
    <td>${maritalStatus}</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Phone Number: </td>
    <td><input type="text" value="${phonenumber}" name="phonenumber" class="form-control" /></td>
    <td align="right">Personal Email:</td>
    <td><input type="text" value="${personalEmail}" name="personalEmail" class="form-control" /></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Home Address: </td>
      <td><textarea value="${homeAddress}" name="homeAddress" class="form-control" ></textarea></td>
    <td align="right">Home City: </td>
    <td><input type="text" value="${homeCity}" name="homeCity" class="form-control" /></td>
    <td align="right">Home State: </td>
    <td><input type="text" value="${homeState}" name="homeState" class="form-control" /></td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Last Qualification <br />
    Obtained: </td>
    <td><input type="text" value="${lastQualification}" name="lastQualification" class="form-control" />${lastQualification}</td>
    <td align="right">Course Studied: </td>
    <td><input type="text" value="${courseStudied}" name="courseStudied" class="form-control" /></td>
    <td align="right">Last Institution<br> Attended: </td>
    <td><input type="text" value="${institution}" name="institution" class="form-control" /></td>
  </tr>
  <tr valign="top">
    <td align="right">Trainings Attended: </td>
    <td><input type="text" value="${trainings}" name="trainings" class="form-control" /></td>
    <td align="right">Professional <br />
    Certifications:</td>
    <td><input type="text" value="${professionalCerts}" name="professionalCerts" class="form-control" />/td>
    <td align="right">Professional <br>Membership: </td>
    <td><input type="text" value="${professionalMembership}" name="professionalMembership" class="form-control" /></td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Name (1): </td>
    <td><input type="text" value="${nokName1}" name="nokName1" class="form-control" /></td>
    <td align="right">Next of Kin <br />
    Relationship (1): </td>
    <td><input type="text" value="${nokRelationship1}" name="nokRelationship1" class="form-control" /></td>
    <td align="right">Next of Kin <br />
    Phone Number (1): </td>
    <td><input type="text" value="${nokPhone1}" name="nokPhone1" class="form-control" /></td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Address (1): </td>
      <td><textarea value="${nokAddress1}" name="nokAddress1" class="form-control"></textarea></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Name (2):</td>
    <td><input type="text" value="${nokName2}" name="nokName2" id="nokName2" class="form-control" /></td>
    <td align="right">Next of Kin <br />
    Relationship(2):</td>
    <td><input type="text" value="${nokRelationship2}" class="form-control" /></td>
    <td align="right">Next of Kin <br />
    Phone Number (2): </td>
    <td><input type="text" value="${firstname}" class="form-control" />${nokPhone2}</td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Address (2): </td>
    <td><input type="text" value="${firstname}" class="form-control" />${nokAddress2}</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Referee Name:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${refName}</td>
    <td align="right">Referee EMail: </td>
    <td><input type="text" value="${firstname}" class="form-control" />${refEmail}</td>
    <td align="right">Referee <br />
    Phone Number:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${refPhone}</td>
  </tr>
  <tr valign="top">
    <td align="right">Referee Address:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${refAddress}</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Referee (2) Name:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${refName2}</td>
    <td align="right">Referee (2) EMail: </td>
    <td><input type="text" value="${firstname}" class="form-control" />${refEmail2}</td>
    <td align="right">Referee (2) <br />
    Phone Number:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${refPhone2}</td>
  </tr>
  <tr valign="top">
    <td align="right">Referee (2) Address:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${refAddress2}</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Previous Employer: </td>
    <td><input type="text" value="${firstname}" class="form-control" />${previousEmployer}</td>
    <td align="right">Previous Employer <br />
    Contact Email:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${pEmployerEmail}</td>
    <td align="right">Previous Employer <br />
    Contact Phone: </td>
    <td><input type="text" value="${firstname}" class="form-control" />${pEmployerPhone}</td>
  </tr>
  <tr valign="top">
    <td align="right">Previous Employer <br />
    Contact Address: <br /></td>
    <td><input type="text" value="${firstname}" class="form-control" />${pEmployerAddress}</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Bank Name:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${bankName}</td>
    <td align="right">Nuban Number:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${NubanNumber}</td>
    <td align="right">Account Name:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${AccountName}</td>
  </tr>
  <tr valign="top">
    <td align="right">Bank Branch:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${bankBranch}</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Pension Administrator Name:</td>
    <td><input type="text" value="${firstname}" class="form-control" />${pensionAdministratorName}</td>
    <td align="right">Pension Administrator Account Number</td>
    <td><input type="text" value="${firstname}" class="form-control" />${pensionAdministratorAccountNumber}</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Resumption Date</td>
    <td><input type="text" value="${firstname}" class="form-control date-picker" />${resumptionDate}</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>