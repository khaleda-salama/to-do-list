

let flashMessage = document.querySelector('.message');

if(flashMessage) {

    setTimeout(() => {
        flashMessage.classList.remove('animate-toast-in');
        flashMessage.classList.add('animate-toast-out');
    }, 5000);


    flashMessage.addEventListener('animationend', (e) => {
        if (e.animationName === 'toast-out') {
            flashMessage.remove();
        }
    });
}
