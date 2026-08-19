document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bookingForm');
    const formMessage = document.getElementById('form-message');
    const submitBtn = document.getElementById('submitBtn');
    
    document.querySelectorAll('.validation-error').forEach(el => el.style.fontSize = '0.9em');

    function displayError(id, message) {
        const errorElement = document.getElementById(id + '-error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.color = 'red';
        }
    }

    function clearMessages() {
        document.querySelectorAll('.validation-error').forEach(el => el.textContent = '');
        formMessage.innerHTML = '';
        formMessage.style.backgroundColor = 'transparent';
    }

    function validateForm() {
        clearMessages();
        let isValid = true;

        if (form.name.value.trim() === '') {
            displayError('name', 'Name is required.');
            isValid = false;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (form.email.value.trim() === '') {
            displayError('email', 'Email is required.');
            isValid = false;
        } else if (!emailRegex.test(form.email.value.trim())) {
            displayError('email', 'Enter a valid email address.');
            isValid = false;
        }

        if (form.phone.value.trim() === '') {
            displayError('phone', 'Phone number is required.');
            isValid = false;
        }

        if (form.destination.value.trim() === '') {
            displayError('destination', 'Destination is required.');
            isValid = false;
        }

        if (form.travel_date.value === '') {
            displayError('travel_date', 'Travel date is required.');
            isValid = false;
        }

        const persons = parseInt(form.num_persons.value);
        if (isNaN(persons) || persons <= 0) {
            displayError('num_persons', 'Must select at least 1 person.');
            isValid = false;
        }
        
        return isValid;
    }

    // --- AJAX Form Submission Listener ---
    form.addEventListener('submit', function (e) {
        e.preventDefault(); 

        if (!validateForm()) {
            formMessage.innerHTML = 'Please fix the errors above.';
            formMessage.style.backgroundColor = '#ffe0e0';
            formMessage.style.color = 'red';
            return; 
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending... Please wait.';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form), 
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.status === 'success') {
                formMessage.innerHTML = data.message;
                formMessage.style.backgroundColor = '#d4edda';
                formMessage.style.color = '#155724';
                form.reset();
            } else {
                let errorHtml = data.message;
                if (data.errors && Array.isArray(data.errors)) {
                    errorHtml += '<ul>' + data.errors.map(err => `<li>${err}</li>`).join('') + '</ul>';
                }
                formMessage.innerHTML = errorHtml;
                formMessage.style.backgroundColor = '#ffe0e0';
                formMessage.style.color = 'red';
            }
        })
        .catch(error => {
            formMessage.innerHTML = `A network or connection error occurred. Please try again.`;
            formMessage.style.backgroundColor = '#fff3cd'; 
            formMessage.style.color = '#856404'; 
            console.error('AJAX Error:', error);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send Enquiry';
        });
    });
});