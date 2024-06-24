document.addEventListener('DOMContentLoaded', (event) => {
    const textElement = document.getElementById('changingText');
    const textArray = [
        "Hello, my name is Efren!",
        "Welcome to my portfolio!",
        "I am a Data Intelligence and Cybersecurity Engineer!",
        "I love learning new languages and musical instruments!",
        "Let's collaborate and build something amazing!"
    ];
    let index = 0;
    let charIndex = 0;
    let currentText = '';
    let isDeleting = false;

    function typeText() {
        textElement.textContent = currentText;
        
        if (!isDeleting && charIndex < textArray[index].length) {
            currentText += textArray[index].charAt(charIndex);
            charIndex++;
            setTimeout(typeText, 100);
        } else if (isDeleting && charIndex > 0) {
            currentText = currentText.substring(0, currentText.length - 1);
            charIndex--;
            setTimeout(typeText, 50);
        } else if (!isDeleting && charIndex === textArray[index].length) {
            isDeleting = true;
            setTimeout(typeText, 2000); // wait for 2 seconds before deleting
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            index = (index + 1) % textArray.length;
            setTimeout(typeText, 500); // start typing next text after a short delay
        }
    }

    typeText();

    const listItems = document.querySelectorAll('.myInfo ul li');

    listItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.setAttribute('data-original', item.textContent);
            item.textContent = item.getAttribute('data-spanish');
        });

        item.addEventListener('mouseleave', () => {
            item.textContent = item.getAttribute('data-original');
        });
    });
});
