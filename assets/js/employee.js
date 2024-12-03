// Employee Management
document.addEventListener('DOMContentLoaded', function() {
    // Add Employee Form
    const addForm = document.getElementById('addEmployeeForm');
    const editForm = document.getElementById('editEmployeeForm');
    
    if (addForm) {
        addForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(addForm);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            try {
                const response = await fetch('../api/employees.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    addForm.reset();
                    const addModal = document.getElementById('addEmployeeModal');
                    bootstrap.Modal.getInstance(addModal).hide();
                    showToast('Employee added successfully', 'success');
                    // Refresh the page after a short delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    if (result.errors) {
                        Object.keys(result.errors).forEach(field => {
                            const input = document.getElementById('employee' + field.charAt(0).toUpperCase() + field.slice(1));
                            const errorDiv = document.getElementById(field + 'Error');
                            if (input && errorDiv) {
                                input.classList.add('is-invalid');
                                errorDiv.textContent = result.errors[field];
                            }
                        });
                    } else {
                        showToast(result.message || 'Failed to add employee', 'error');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to add employee', 'error');
            }
        });
    }

    if (editForm) {
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(editForm);
            const data = {};
            formData.forEach((value, key) => {
                if (key !== 'password' || value !== '') {
                    data[key] = value;
                }
            });

            try {
                const response = await fetch('../api/employees.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    editForm.reset();
                    const editModal = document.getElementById('editEmployeeModal');
                    bootstrap.Modal.getInstance(editModal).hide();
                    showToast('Employee updated successfully', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showToast(result.message || 'Failed to update employee', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to update employee', 'error');
            }
        });
    }
});

// Edit Employee
window.editEmployee = async function(id) {
    try {
        const response = await fetch(`../api/employees.php?id=${id}`);
        const result = await response.json();

        if (result.success) {
            const employee = result.employee;
            document.getElementById('editEmployeeId').value = employee.id;
            document.getElementById('editEmployeeName').value = employee.name;
            document.getElementById('editEmployeeUsername').value = employee.username;
            document.getElementById('editEmployeeStatus').value = employee.status;
            document.getElementById('editEmployeePassword').value = ''; // Clear password field

            const editModal = document.getElementById('editEmployeeModal');
            const modal = bootstrap.Modal.getInstance(editModal) || new bootstrap.Modal(editModal);
            modal.show();
        } else {
            showToast('Failed to load employee data', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Failed to load employee data', 'error');
    }
};

// Delete Employee
window.deleteEmployee = async function(id) {
    if (!confirm('Are you sure you want to delete this employee?')) {
        return;
    }

    try {
        const response = await fetch(`../api/employees.php?id=${id}`, {
            method: 'DELETE'
        });

        const result = await response.json();

        if (result.success) {
            showToast('Employee deleted successfully', 'success');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast(result.message || 'Failed to delete employee', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Failed to delete employee', 'error');
    }
};

// Function to show toast notifications
function showToast(message, type = 'success') {
    const toastContainer = document.querySelector('.toast-container');
    const toastElement = document.createElement('div');
    toastElement.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
    toastElement.setAttribute('role', 'alert');
    toastElement.setAttribute('aria-live', 'assertive');
    toastElement.setAttribute('aria-atomic', 'true');

    toastElement.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toastElement);
    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    // Remove the toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function () {
        toastElement.remove();
    });
}
