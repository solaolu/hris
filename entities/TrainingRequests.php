<?php 
namespace Entity;

class TrainingRequests{
	
    public $id;

    public function getId(){
        return $this->id;
    }

    public $owner;

    public function getOwner(){
        return $this->owner;
    }


    public function setOwner($owner){
        $this->owner = $owner;
        return $this;
    }

    public $proposedTraining;

    public function getProposedtraining(){
        return $this->proposedTraining;
    }


    public function setProposedtraining($proposedtraining){
        $this->proposedTraining = $proposedTraining;
        return $this;
    }

    public $trainingType;

    public function getTrainingtype(){
        return $this->trainingType;
    }


    public function setTrainingtype($trainingtype){
        $this->trainingType = $trainingType;
        return $this;
    }

    public $trainingContent;

    public function getTrainingcontent(){
        return $this->trainingContent;
    }


    public function setTrainingcontent($trainingcontent){
        $this->trainingContent = $trainingContent;
        return $this;
    }

    public $trainingDate;

    public function getTrainingdate(){
        return $this->trainingDate;
    }


    public function setTrainingdate($trainingdate){
        $this->trainingdate = $trainingDate;
        return $this;
    }

    public $trainingLocation;

    public function getTraininglocation(){
        return $this->trainingLocation;
    }


    public function setTraininglocation($traininglocation){
        $this->trainingLocation = $traininglocation;
        return $this;
    }

    public $trainingHours;

    public function getTraininghours(){
        return $this->trainingHours;
    }


    public function setTraininghours($traininghours){
        $this->trainingHours = $traininghours;
        return $this;
    }

    public $sessionCount;

    public function getSessioncount(){
        return $this->sessionCount;
    }


    public function setSessioncount($sessioncount){
        $this->sessionCount = $sessioncount;
        return $this;
    }

    public $sessionLength;

    public function getSessionlength(){
        return $this->sessionLength;
    }


    public function setSessionlength($sessionlength){
        $this->sessionLength = $sessionlength;
        return $this;
    }

    public $registrationFee;

    public function getRegistrationfee(){
        return $this->registrationFee;
    }


    public function setRegistrationfee($registrationfee){
        $this->registrationFee = $registrationfee;
        return $this;
    }

    public $otherCosts;

    public function getOthercosts(){
        return $this->otherCosts;
    }


    public function setOthercosts($othercosts){
        $this->otherCosts = $othercosts;
        return $this;
    }

    public $totalCost;

    public function getTotalcost(){
        return $this->totalCost;
    }


    public function setTotalcost($totalcost){
        $this->totalCost = $totalcost;
        return $this;
    }

    public $proposedFundSource;

    public function getProposedfundsource(){
        return $this->proposedFundSource;
    }


    public function setProposedfundsource($proposedfundsource){
        $this->proposedFundSource = $proposedfundsource;
        return $this;
    }

    public $requiresReleaseTime;

    public function getRequiresreleasetime(){
        return $this->requiresReleaseTime;
    }


    public function setRequiresreleasetime($requiresreleasetime){
        $this->requiresReleaseTime = $requiresreleasetime;
        return $this;
    }

    public $requiresReplacement;

    public function getRequiresreplacement(){
        return $this->requiresReplacement;
    }


    public function setRequiresreplacement($requiresreplacement){
        $this->requiresReplacement = $requiresreplacement;
        return $this;
    }

    public $trainingDescription;

    public function getTrainingdescription(){
        return $this->trainingDescription;
    }


    public function setTrainingdescription($trainingdescription){
        $this->trainingDescription = $trainingdescription;
        return $this;
    }

    public $trainingRationale;

    public function getTrainingrationale(){
        return $this->trainingRationale;
    }


    public function setTrainingrationale($trainingrationale){
        $this->trainingRationale = $trainingrationale;
        return $this;
    }

    public $desiredCompetency;

    public function getDesiredcompetency(){
        return $this->desiredCompetency;
    }


    public function setDesiredcompetency($desiredcompetency){
        $this->desiredCompetency = $desiredcompetency;
        return $this;
    }

    public $personalOutcome;

    public function getPersonaloutcome(){
        return $this->personalOutcome;
    }


    public function setPersonaloutcome($personaloutcome){
        $this->personalOutcome = $personaloutcome;
        return $this;
    }

    public $unitOutcome;

    public function getUnitoutcome(){
        return $this->unitOutcome;
    }


    public function setUnitoutcome($unitoutcome){
        $this->unitOutcome = $unitoutcome;
        return $this;
    }

    public $cmsOutcome;

    public function getCmsoutcome(){
        return $this->cmsOutcome;
    }


    public function setCmsoutcome($cmsoutcome){
        $this->cmsOutcome = $cmsoutcome;
        return $this;
    }

    public $sharedHow;

    public function getSharedhow(){
        return $this->sharedHow;
    }


    public function setSharedhow($sharedhow){
        $this->sharedHow = $sharedhow;
        return $this;
    }

    public $partOfCertification;

    public function getPartofcertification(){
        return $this->partOfCertification;
    }


    public function setPartofcertification($partOfCertification){
        $this->partOfCertification = $partOfCertification;
        return $this;
    }

    public $certificationCourses;

    public function getCertificationcourses(){
        return $this->certificationCourses;
    }


    public function setCertificationcourses($certificationcourses){
        $this->certificationCourses = $certificationCourses;
        return $this;
    }

    public $unitHeadApproval;

    public function getUnitheadapproval(){
        return $this->unitHeadApproval;
    }


    public function setUnitheadapproval($unitHeadApproval){
        $this->unitHeadApproval = $unitheadapproval;
        return $this;
    }

    public $fundingApproval;

    public function getFundingapproval(){
        return $this->fundingApproval;
    }


    public function setFundingapproval($fundingapproval){
        $this->fundingApproval = $fundingapproval;
        return $this;
    }

}