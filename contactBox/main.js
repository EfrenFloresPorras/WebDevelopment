// Function to handle form submission
function SubmitForm(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the form elements
    const email = document.getElementById('email').value;
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;

    // Perform form validation
    if (email === '' || subject === '' || message === '') {
        alert('Please fill out all fields.');
        return;
    }

    // Display a message indicating that the form has been submitted
    const submittedMessage = document.querySelector('.submited');
    submittedMessage.style.display = 'block';
    submittedMessage.innerText = 'Your message has been sent successfully!';

    document.getElementById('contact-form').submit();

    // Clear the form fields after submission
    document.getElementById('email').value = '';
    document.getElementById('subject').value = '';
    document.getElementById('message').value = '';
}

// Attach the SubmitForm function to the form's submit event
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelector('form').addEventListener('submit', SubmitForm);
});