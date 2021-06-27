<?php


class CandidateModel extends database
{

    public function getEducations(){

        if($this->Query("SELECT * FROM educations WHERE status = 1")){

            $data = $this->fetchAll();
            return $data;

        }

    }

    public function getEducationLevels(){

        if($this->Query("SELECT * FROM education_levels WHERE status = 1")){

            $data = $this->fetchAll();
            return $data;

        }

    }

    public function getIndustries(){

        if($this->Query("SELECT * FROM industries WHERE status = 1")){

            $data = $this->fetchAll();
            return $data;

        }

    }

    public function getWorkExperiences(){

        if($this->Query("SELECT * FROM work_experiences WHERE status = 1")){

            $data = $this->fetchAll();
            return $data;

        }

    }

    public function create($userData){

        $timeStamp = date('Y-m-d H:i:s');

        if($this->checkEmail($userData['email'])){

            $updateData = [$userData['first_name'],$userData['last_name'], $userData['phone_number'],
                $userData['education'], $userData['education_level'], $userData['industry'],
                $userData['work_experience'], $timeStamp, $userData['email']
            ];
            if($this->Query("UPDATE candidates SET first_name = ? , last_name = ? , phone_number = ?, education = ?, education_level = ?, industry = ?, work_experince = ?, updated_at = ? WHERE email = ? ", $updateData)){
                return true;
            }

        } else {

            $data = [$userData['first_name'],$userData['last_name'], $userData['email'],
                $userData['phone_number'],$userData['education'], $userData['education_level'], $userData['industry'],
                $userData['work_experience'], $timeStamp, $timeStamp
            ];

            if($this->Query("INSERT INTO candidates (first_name, last_name, email, phone_number, education, education_level, industry, work_experince, created_at, updated_at) VALUES (?,?,?,?,?,?,?,?,?,?)", $data)){
                return true;
            }
        }

        return false;
    }

    public function checkEmail($email){

        if($this->Query("SELECT email FROM candidates WHERE email = ?", [$email])){

            if($this->rowCount() > 0 ){
                return true;
            } else {
                return false;
            }

        }

    }

    public function getIndustryDropDownValues($id){

        if($this->Query("SELECT name FROM industries WHERE id = ?", [$id])){

            $data = $this->fetch();
            return $data;

        }

    }


    public function getDropDownValues($email){

        if($this->Query("SELECT e.name as education, el.name as education_level, i.name as industry, w.name as work_experince 
                              FROM candidates c 
                              LEFT JOIN educations e ON c.education=e.id 
                              LEFT JOIN education_levels el ON c.education_level=el.id 
                              LEFT JOIN industries i ON c.industry=i.id 
                              LEFT JOIN work_experiences w ON c.work_experince=w.id 
                              WHERE c.email= ?", [$email])){

            $data = $this->fetch();
            return $data;

        }

    }



}