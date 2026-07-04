let flashMessage = document.querySelector(".message");

if (flashMessage) {
    setTimeout(() => {
        flashMessage.classList.remove("animate-toast-in");
        flashMessage.classList.add("animate-toast-out");
    }, 5000);

    flashMessage.addEventListener("animationend", (e) => {
        if (e.animationName === "toast-out") {
            flashMessage.remove();
        }
    });
}

const btnCreate = document.querySelector(".create-idea-btn");
const modal = document.querySelector(".create-idea-modal");
const closeModal = document.querySelector(".close-modal");
const cancelBtn = document.querySelector(".cancel-btn");

if (modal && btnCreate) {
    function openModal() {
        modal.classList.remove("hidden", "animate-slide-out");
        modal.classList.add("animate-slide-in");
    }

    function hideModal() {
        modal.classList.remove("animate-slide-in");
        modal.classList.add("animate-slide-out");

        setTimeout(() => {
            modal.classList.add("hidden");
        }, 300);
    }

    btnCreate.addEventListener("click", openModal);
    closeModal?.addEventListener("click", hideModal);
    cancelBtn?.addEventListener("click", hideModal);

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && !modal.classList.contains("hidden")) {
            hideModal();
        }
    });
}

const statusBtns = document.querySelectorAll(".status-btn");
const statusInput = document.querySelector(".input-status");

statusBtns.forEach((btn) => btn.classList.add("btn-outlined"));

if (statusBtns.length) {
    statusBtns[0].classList.remove("btn-outlined");
    statusInput.value = statusBtns[0].dataset.status;
}

statusBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        statusBtns.forEach((b) => {
            b.classList.add("btn-outlined");
        });

        btn.classList.remove("btn-outlined");
        statusInput.value = btn.dataset.status;
    });
});
