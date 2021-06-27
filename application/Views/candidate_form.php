<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Candidate Registration Form</title>
    <?php include "layouts/header.php" ?>
</head>
<body>
<?php include "layouts/nav.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            <h2>Candidate Registration Form</h2>
            <br/>
            <?php $this->flash('error', 'alert alert-success') ?>

            <form class="row g-3" id="candidate-form" action="<?php echo BASEURL; ?>/CandidateController/create"
                  method="post">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name">
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number">
                </div>
                <div class="col-md-6">
                    <label for="education" class="form-label">Education</label>
                    <select class="form-select" id="education" name="education">
                        <option value="">Please Select</option>
                        <?php foreach ($data['educations'] as $educations) { ?>
                            <option value="<?php echo $educations->id ?>"><?php echo $educations->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="education_level" class="form-label">Education Level</label>
                    <select class="form-select" id="education_level" name="education_level">
                        <option value="">Please Select</option>
                        <?php foreach ($data['education_levels'] as $educationLevel) { ?>
                            <option value="<?php echo $educationLevel->id ?>"><?php echo $educationLevel->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="industry" class="form-label">Industry</label>
                    <select class="form-select" id="industry" name="industry">
                        <option value="">Please Select</option>
                        <?php foreach ($data['industries'] as $industry) { ?>
                            <option value="<?php echo $industry->id ?>"><?php echo $industry->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6" id="work_experience_div">
                    <label for="work_experience" class="form-label">Work experience</label>
                    <select class="form-select" id="work_experience" name="work_experience">
                        <option value="">Please Select</option>
                        <?php foreach ($data['work_experiences'] as $workExperience) { ?>
                            <option value="<?php echo $workExperience->id ?>"><?php echo $workExperience->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- Close col-md-5 -->
    </div>
    <!-- Close row -->
</div>
<?php include "layouts/footer.php"; ?>
</body>
</html>
