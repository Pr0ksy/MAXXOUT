function openModal() {
    document.getElementById("productModal").style.display = "block";
}

function closeModal() {
    document.getElementById("productModal").style.display = "none";
}

window.onclick = function(event) {
    const modal = document.getElementById("productModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

const editButtons = document.querySelectorAll('.edit-btn');

editButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_name').value = this.dataset.name;
        document.getElementById('edit_price').value = this.dataset.price;
        document.getElementById('edit_stock').value = this.dataset.stock;
        document.getElementById('edit_image').value = this.dataset.image;

        document.getElementById("editModal").style.display = "block";
    });
});

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}


const deleteButtons = document.querySelectorAll('.delete-btn');

deleteButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('delete_id').value = this.dataset.id;
        document.getElementById("deleteModal").style.display = "block";
    });
});

function closeDeleteModal() {
    document.getElementById("deleteModal").style.display = "none";
}