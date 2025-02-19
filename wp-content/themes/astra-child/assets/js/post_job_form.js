jQuery(document).ready(function($) {
    $('#location,#job_type,#experience,#category').select2();
    $('#company-img').on('change', function() {
        const file = this.files[0];
        const fileType = file.type;
        const validTypes = ['image/jpeg', 'image/png'];
        
        if (file) {
            $('#selected-filename').text(file.name);
        } else {
            $('#selected-filename').text('');
        }
        if (!validTypes.includes(fileType)) {
            toast({
                title: 'Error!',
                message: 'Please upload only PNG or JPEG images',
                type: 'error',
                duration: 3000,
                position: 'top-center'
            });
            this.value = '';
            return false;
        }
    });
    $('.referrify-btn').on('click', function(e) {
        e.preventDefault();  
       
        if (!validateForm()) {
            return false;
        }

        // Get form data
        const formData = new FormData();
        formData.append('title', $('#title').val());
        formData.append('category', $('#category').val());
        formData.append('location', $('#location').val());
        formData.append('job_type', $('#job_type').val());
        formData.append('experience', $('#experience').val());
        formData.append('salary', $('#salary').val());
        formData.append('description', $('#description').val());
        formData.append('company_image', $('#company-img')[0].files[0]);
        formData.append('action', 'post_job_submission');
        formData.append('nonce', jobformajax.nonce);

        // Send AJAX request
        $.ajax({
            url: jobformajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // Show loading state
                $('.referrify-btn').prop('disabled', true);
                $('.referrify-btn').text('Submitting... ');
                $('.referrify-btn').append('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                if (response.success) {
                    toast({
                        title: 'Success!', 
                        message: 'Job posted successfully!',
                        type: 'success',
                        duration: 3000,
                        position: 'top-center'
                    });
                    // Reset form
                    $('#title,#salary,#description').val('');
                    // Reset Select2 fields
                    $('#location,#job_type,#experience,#category').val('').trigger('change');
                } else {
                    toast({
                        title: 'Error!', 
                        message: 'Error: ' + response.data || 'Something went wrong ! Please try again later.',
                        type: 'error',
                        duration: 3000,
                        position: 'top-center'
                    });
                }
            },
            error: function(xhr, status, error) {
                toast({
                    title: 'Error!', 
                    message: 'Error submitting form. Please try again.',
                    type: 'error',
                    duration: 3000,
                    position: 'top-center'
                });
            },
            complete: function() {
                // Reset button state
                $('.referrify-btn').prop('disabled', false);
                $('.referrify-btn').text('Submit');
            }
        });
    });
   
    

    // Remove error class on input/change
    $('input, textarea').on('input', function() {
        $(this).removeClass('error');
        $(this).next('.error-message').remove();
    });

    $('select').on('change', function() {
        $(this).next('.select2-container').removeClass('error');
        $(this).next('.select2-container').next('.error-message').remove();
    });
    // Validate form
    const validateForm = () => {
        let isValid = true;
        const errorMessages = [];
        
        // Clear previous error messages
        $('.error-message').remove();
        
        // Field configurations
        const fields = [
            { id: 'title', type: 'text' },
            { id: 'category', type: 'select' },
            { id: 'location', type: 'select' },
            { id: 'job_type', type: 'select' },
            { id: 'experience', type: 'select' },
            { id: 'description', type: 'text' }
        ];

        // Validate each field
        fields.forEach(field => {
            const $element = $(`#${field.id}`);
            const value = field.type === 'text' ? $element.val().trim() : $element.val();
            
            if (!value) {
                isValid = false;
                const label = getLabelText(field.id);
                errorMessages.push(`${label} is required`);

                if (field.type === 'select') {
                    $element.next('.select2-container').addClass('error');
                    $element.next('.select2-container')
                           .after(`<span class="error-message">*${label} is required*</span>`);
                } else {
                    $element.addClass('error');
                    $element.after(`<span class="error-message">*${label} is required*</span>`);
                }
            } else {
                if (field.type === 'select') {
                    $element.next('.select2-container').removeClass('error');
                } else {
                    $element.removeClass('error');
                }
            }
        });

        return isValid;
    }
    // Helper function to get label text from input ID
    const getLabelText = (inputId) => {
        return $(`#${inputId}`).closest('.referrify-form-field').find('label').text().replace('*', '');
    }
});

