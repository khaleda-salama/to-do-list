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

const btnCreate = document.querySelector(".create-idea");
const btnEdit = document.querySelector(".edit-idea");
const modal = document.querySelector(".idea-modal");
const closeModal = document.querySelector(".close-modal");
const cancelBtn = document.querySelector(".cancel-btn");

if (modal) {
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

    btnCreate?.addEventListener("click", openModal);
    btnEdit?.addEventListener("click", openModal);
    closeModal.addEventListener("click", hideModal);
    cancelBtn.addEventListener("click", hideModal);

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && !modal.classList.contains("hidden")) {
            hideModal();
        }
    });
}

const statusBtns = document.querySelectorAll(".status-btn");
const statusInput = document.querySelector(".input-status");

if (statusInput && statusBtns.length) {
    function selectStatus(status) {
        statusBtns.forEach((btn) => {
            btn.classList.toggle("btn-outlined", btn.dataset.status !== status);
        });

        statusInput.value = status;
    }

    selectStatus(statusInput.value || statusBtns[0].dataset.status);

    statusBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            selectStatus(btn.dataset.status);
        });
    });
}

function addLinkAndSteps(
    selector,
    btn,
    input,
    template,
    container,
    inputSelector,
) {
    function append(value) {
        const clone = template.content.cloneNode(true);

        clone.querySelector(inputSelector).value = value;

        container.appendChild(clone);
    }

    if (selector) {
        selector.addEventListener("click", (e) => {
            if (!e.target.closest(btn)) return;

            const value = input.value.trim();

            if (!value) return;

            append(value);

            input.value = "";
        });
    }

    return append;
}

const appendLink = addLinkAndSteps(
    document.querySelector(".link-box"),
    ".add-link-btn",
    document.getElementById("new-link"),
    document.getElementById("link-template"),
    document.getElementById("hidden-links"),
    ".links-container .link",
);

const appendStep = addLinkAndSteps(
    document.querySelector(".step-box"),
    ".add-step-btn",
    document.getElementById("new-step"),
    document.getElementById("step-template"),
    document.getElementById("hidden-steps"),
    ".steps-container .step",
);

window.oldSteps?.forEach((step) => {
    appendStep(step);
});

window.oldLinks?.forEach((link) => {
    appendLink(link);
});

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

const deleteImageBtn = document.querySelector(".delete-image");
const deleteImageForm = document.querySelector(".delete-image-form");

deleteImageBtn?.addEventListener("click", () => {
    deleteImageForm?.requestSubmit();
});
