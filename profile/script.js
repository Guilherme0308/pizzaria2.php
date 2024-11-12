document.addEventListener("DOMContentLoaded", function () {
    // Select the modal and close button elements
    const confirmDeleteModal = document.getElementById("confirmDelete");
    const closeModalButtons = document.querySelectorAll('[data-dismiss="modal"]');
    const deleteButton = document.querySelector(".delete-button");

    // Show modal when delete button is clicked
    deleteButton.addEventListener("click", function () {
        confirmDeleteModal.classList.add("show");
        confirmDeleteModal.style.display = "block";
    });

    // Hide modal on cancel/close buttons click
    closeModalButtons.forEach(button => {
        button.addEventListener("click", function () {
            confirmDeleteModal.classList.remove("show");
            confirmDeleteModal.style.display = "none";
        });
    });
});
