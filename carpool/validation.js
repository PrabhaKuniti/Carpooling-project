document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll('.needs-validation');

    Array.prototype.forEach.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});

const fields = document.querySelectorAll('input');
fields.forEach(field => {
    field.addEventListener('blur', () => {
        if (field.value === '') {
            field.style.borderColor = 'red';
        } else {
            field.style.borderColor = 'green';
        }
    });
});
