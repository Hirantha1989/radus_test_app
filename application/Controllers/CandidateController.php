<?php

use Mpdf\Mpdf;

require realpath(__DIR__."/../../vendor/autoload.php");

class candidateController extends framework
{
    private $model;

    public function __construct()
    {
        $this->helper('link');
        $this->helper('mail');
        $this->candidateModel = $this->model('CandidateModel');
    }

    public function index()
    {
        $formConfigData ['educations'] = $this->candidateModel->getEducations();
        $formConfigData ['education_levels'] = $this->candidateModel->getEducationLevels();
        $formConfigData ['industries'] = $this->candidateModel->getIndustries();
        $formConfigData ['work_experiences'] = $this->candidateModel->getWorkExperiences();

        $this->view("candidate_form", $formConfigData);

    }

    public function create()
    {
        $errors = [];

        $userData = [

            'first_name' => $this->input('first_name'),
            'last_name' => $this->input('last_name'),
            'email' => $this->input('email'),
            'phone_number' => $this->input('phone_number'),
            'education' => $this->input('education'),
            'education_level' => $this->input('education_level'),
            'industry' => $this->input('industry'),
            'work_experience' => $this->input('work_experience'),
        ];


        if (empty($userData['last_name'])) {
            $errors['last_name_error'] = 'Last Name is required';
        }

        if (empty($userData['email'])) {
            $errors['email_error'] = 'Email is required';
        }

        if (empty($userData['education'])) {
            $errors['education_error'] = 'Education is required';
        }

        if (empty($userData['education_level'])) {
            $errors['education_level_error'] = ' level is required';
        }

        if (empty($userData['industry'])) {
            $errors['industry_error'] = ' Industry is required';
        }

        $industryDropDownValue = $this->candidateModel->getIndustryDropDownValues($userData['industry']);

        if ($industryDropDownValue->name != 'N/A' && empty($userData['work_experience'])) {
            $errors['work_experience_error'] = ' Work experience is required';
        }

        $userData['errors'] = $errors;

        if (empty($errors)) {

            if ($this->candidateModel->create($userData)) {
                $uniqueCode = $this->generatePdf($userData);
                $emailDataForAdmin = $this->generateEmailDataForAdmin($userData);
                $emailDataForCandidate = $this->generateEmailDataForCandidate($userData, $uniqueCode);
                sendEmail($emailDataForAdmin);
                sendEmail($emailDataForCandidate);
                $this->redirect("CandidateController/formSuccess");

            }

        } else {

            $this->setFlash("error", "Please fill all the required fields");
            $this->redirect("CandidateController");
        }

    }

    public function formSuccess(){
        $this->view("candidate_form_success");
    }

    public function generatePdf($data)
    {
        $dropDownValues = $this->candidateModel->getDropDownValues($data['email']);
        $workExperince = (int) preg_replace('/\D/', '', $dropDownValues->work_experince);
        $uniqueCode = uniqid();
        if($dropDownValues->education == 'Others' || $dropDownValues->education_level == 'Others' || $dropDownValues->industry == 'Others' || $workExperince < 4){
            $decision = 'not selected this time';
        } else {
            $decision = 'selected to next round';
        }
        $pdfName = $uniqueCode.'_'.str_replace(' ', '', $data['first_name']).'_'.str_replace(' ', '', $data['last_name']);

        $mpdf = new Mpdf();
        $mpdf->WriteHTML('<br>Dear '.$data['first_name']. ' ' . $data['last_name'].'<br><br>');
        $mpdf->WriteHTML('You application was processed. According to your qualifications and skills you are <b>' .$decision. '</b> for the current opportunity at our organization.<br><br>');
        $mpdf->WriteHTML('Cheers<br>Managing Director<br>');
        $mpdf->Output('candidate_pdfs/'.$pdfName.'.pdf', 'F');

        return $uniqueCode;
    }

    public function generateEmailDataForAdmin($data)
    {
        $emailData = [];
        $emailBody = '';

        $dropDownValues = $this->candidateModel->getDropDownValues($data['email']);

        $emailBody .= 'New Candidate details are following, <br><br>';
        $emailBody .= 'Name : '.$data['first_name'].' '.$data['last_name'].' <br>';
        $emailBody .= 'Email : '.$data['email'].' <br>';
        $emailBody .= 'Phone Number : '.$data['phone_number'].' <br>';
        $emailBody .= 'Education : '.$dropDownValues->education.' <br>';
        $emailBody .= 'Education Level : '.$dropDownValues->education_level.' <br>';
        $emailBody .= 'Industry : '.$dropDownValues->industry.' <br>';
        $emailBody .= 'Work Experience : '.$dropDownValues->work_experince.' <br><br>';
        $emailBody .= 'Radus Team.<br><br>';
        $emailBody .= 'This is a system generated email. Please do not reply.';

        $emailData['subject'] = 'New Candidate Details';
        $emailData['receiver'] = RADUS_RECEIVER_EMAIL;
        $emailData['body'] = $emailBody;
        $emailData['attachment'] = '';

        return $emailData;

    }

    public function generateEmailDataForCandidate($data, $uniqueId)
    {
        $emailData = [];
        $emailBody = '';


        $emailBody .= 'Dear,'.$data['first_name'].' '.$data['last_name'].' <br><br>';
        $emailBody .= 'Thank you for submitting the candidate form. Please find the attachment to check your status. <br><br>';
        $emailBody .= 'Thank you. <br>Radus Team.<br><br>';
        $emailBody .= 'This is a system generated email. Please do not reply.';

        $emailData['subject'] = 'Thank You from Radus';
        $emailData['receiver'] = RADUS_RECEIVER_EMAIL;
        $emailData['body'] = $emailBody;
        $emailData['attachment'] = realpath(__DIR__. '/../../public/candidate_pdfs/'.$uniqueId.'_'.str_replace(' ', '', $data['first_name']).'_'.str_replace(' ', '', $data['last_name']).'.pdf');
        return $emailData;

    }

    public function input($inputName)
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == 'post') {

            return trim(strip_tags($_POST[$inputName]));

        } else if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'get') {

            return trim(strip_tags($_GET[$inputName]));

        }

    }

    public function helper($helperName)
    {

        if (file_exists("../system/helpers/" . $helperName . ".php")) {

            require_once "../system/helpers/" . $helperName . ".php";

        } else {
            echo "<div style='margin:0;padding: 10px;background-color:silver;'>Sorry helper $helperName file not found </div>";
        }

    }

}