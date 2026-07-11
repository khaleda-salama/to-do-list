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

function addLinkAndSteps(
    selector,
    btn,
    selector1,
    selector2,
    selector3,
    selector4,
) {
    if (selector) {
        selector.addEventListener("click", (e) => {
            if (!e.target.closest(btn)) return;

            const stepOrLink = selector1.value.trim();
            if (!stepOrLink) return;

            const clone = selector2.content.cloneNode(true);
            const input = clone.querySelector(selector4);
            input.value = stepOrLink;

            selector3.appendChild(clone);

            selector1.value = "";
        });
    }
}

addLinkAndSteps(
    document.querySelector(".link-box"),
    ".add-link-btn",
    document.getElementById("new-link"),
    document.getElementById("link-template"),
    document.getElementById("hidden-links"),
    ".links-container .link",
);
addLinkAndSteps(
    document.querySelector(".step-box"),
    ".add-step-btn",
    document.getElementById("new-step"),
    document.getElementById("step-template"),
    document.getElementById("hidden-steps"),
    ".steps-container .step",
);

function removeLinkAndSteps(selector, selector2, selector3) {
    if (!document.getElementById(selector)) return;
    document.getElementById(selector).addEventListener("click", (e) => {
        if (!e.target.closest(selector2)) return;

        const container = e.target.closest(selector3);

        container.remove();
    });
}

removeLinkAndSteps("hidden-links", ".remove-link", ".links-container");
removeLinkAndSteps("hidden-steps", ".remove-step", ".steps-container");
