var tries = 10;
const randomNumber = Math.floor(Math.random() * 100) + 1;

function GRN() {
    const givenNumber = document.getElementById('numero').value;

    if (givenNumber === '') {
        const submittedMessage = document.querySelector('.alert-warning');
        submittedMessage.style.display = 'block';
        submittedMessage.innerText = 'Por favor ingresa un número.';
        const correctMargin = document.querySelector('p');
        correctMargin.style.paddingTop = '6px';
        return;
    } else if (givenNumber < 1 || givenNumber > 100) {
        const submittedMessage = document.querySelector('.alert-warning');
        submittedMessage.style.display = 'block';
        submittedMessage.innerText = 'Por favor ingresa un número entre 1 y 100.';
        const correctMargin = document.querySelector('p');
        correctMargin.style.paddingTop = '6px';
    } else {
        if (tries < 1) {
            const submittedMessage = document.querySelector('.alert-danger');
            submittedMessage.style.display = 'block';
            const deleteMessage = document.querySelector('.alert-warning');
            deleteMessage.style.display = 'none';
            submittedMessage.innerText = '¡Lo siento! Has agotado tus intentos. El número era: ' + randomNumber + '. Intenta de nuevo.';
            const correctMargin = document.querySelector('p');
            correctMargin.style.paddingTop = '6px';

            // Block the input field
            document.getElementById('numero').disabled = true;

            return;
        } else {
            tries--;
            if (randomNumber == givenNumber) {
                const submittedMessage = document.querySelector('.alert-success');
                submittedMessage.style.display = 'block';
                submittedMessage.innerText = `¡Felicidades! Has adivinado el número: ${randomNumber}`;
                const correctMargin = document.querySelector('p');
                correctMargin.style.paddingTop = '6px';
            } else if (randomNumber > givenNumber) {
                const submittedMessage = document.querySelector('.alert-warning');
                submittedMessage.style.display = 'block';
                submittedMessage.innerText = `Incorrecto, te quedan ${tries} intentos. El número es mayor a ${givenNumber}.`;
                const correctMargin = document.querySelector('p');
                correctMargin.style.paddingTop = '6px';
            } else {
                const submittedMessage = document.querySelector('.alert-warning');
                submittedMessage.style.display = 'block';
                submittedMessage.innerText = `Incorrecto, te quedan ${tries} intentos. El número es menor a ${givenNumber}.`;
                const correctMargin = document.querySelector('p');
                correctMargin.style.paddingTop = '6px';
            }
            }
    }
}