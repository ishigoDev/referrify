document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('deleteModal');
    const cancelBtn = document.getElementById('cancelDelete');
    const confirmBtn = document.getElementById('confirmDelete');
    let deleteUrl = '';

    // Open modal
    document.querySelectorAll('.delete-job').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            deleteUrl = this.dataset.deleteUrl;
            modal.style.display = 'block';
        });
    });

    // Close modal on cancel
    cancelBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Close modal on outside click
    window.addEventListener('click', function (e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    });

    // Handle delete confirmation
    confirmBtn.addEventListener('click', function () {
        if (deleteUrl) {
            console.log(deleteUrl);
            window.location.href = deleteUrl;
        }
    });
});
