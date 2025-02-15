jQuery(document).ready(function($) {
    $('#location,#job_type,#experience,#category').select2();
    $('.referrify-btn').on('click', function(e) {
        e.preventDefault();

        if (!validateForm()) {
            return false;
        }

        // If validation passes, submit the form
        this.submit();
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

