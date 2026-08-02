const successBox = document.querySelector('.success-box');
const successMessage = document.getElementById("success-message");

if (successBox) {
    setTimeout(() => {
        successBox.style.display = 'none';
    }, 3000);
}

if (successMessage) {

    setTimeout(() => {
        successMessage.remove();
    }, 3000);

    const url = new URL(window.location.href);

    url.searchParams.delete("success");

    window.history.replaceState({}, "", url);
}