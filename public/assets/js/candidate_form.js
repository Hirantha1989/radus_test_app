$(document).ready(function () {

    let $candidateForm = $("#candidate-form");

    if ($candidateForm.length) {
        $candidateForm.validate({
            rules: {
                last_name: {
                    required: true
                },
                phone_number: {
                    maxlength: 10
                },
                email: {
                    required: true,
                    email: true
                },
                education: {
                    required: true
                },
                education_level: {
                    required: true
                },
                industry: {
                    required: true
                },
                work_experience: {
                    required: true
                }
            },
            messages: {
                last_name: {
                    required: 'Last name is required.'
                },
                email: {
                    required: 'Email is required.'
                },
                education: {
                    required: 'Please select the education.'
                },
                education_level: {
                    required: 'Please select the education level'
                },
                industry: {
                    required: 'Please select the industry'
                },
                work_experience: {
                    required: 'Please select the work experience'
                }
            }
        });
    }

    $('#phone_number').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $("#candidate-form").submit(function (event) {
        event.preventDefault();

        let $candidateForm = $(this);

        // check if the input is valid using a 'valid' property
        if ($candidateForm.valid) {
            $('form#candidate-form')[0].submit();
        }
    });

    $('#industry').on('change', function() {
        if ( $(this).find("option:selected").text() == 'N/A')
        {
            $("#work_experience_div").hide();
        }
        else
        {
            $("#work_experience_div").show();
        }
    });
});