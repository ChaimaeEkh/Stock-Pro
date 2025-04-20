<!-- Import Products Modal -->
<div id="importProductModal" class="modal">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Products</h5>
                <button type="button" class="close-btn" id="closeModalBtn">&times;</button>
            </div>
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" id="importProductForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Select Excel File <span class="required">*</span></label>
                        <input type="file" name="file" id="file" required>
                        <div class="error-feedback"></div>
                    </div>
                    <div class="helper-text">Please upload an Excel file with the correct product format.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel-btn" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn submit-btn"><i class="fa fa-file"></i> Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        overflow: auto;
    }

    .modal.show {
        display: block;
    }

    .modal-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100%;
        padding: 20px;
    }

    .modal-content {
        background-color: white;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-title {
        margin: 0;
        font-size: 18px;
        font-weight: 500;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        color: #666;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 15px 20px;
        border-top: 1px solid #e9ecef;
    }
    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    input[type="file"] {
        display: block;
        width: 100%;
        padding: 8px 0;
    }

    .required {
        color: #dc3545;
    }

    .helper-text {
        font-size: 14px;
        color: #6c757d;
    }

    .error-feedback {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
    .cancel-btn {
        background-color: #6c757d;
        color: white;
    }

    .submit-btn {
        background-color: #28a745;
        color: white;
    }

    input.is-invalid {
        border: 1px solid #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const modal = document.getElementById('importProductModal');
    const openBtn = document.getElementById('openImportModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('importProductForm');

    // Open modal
    openBtn.addEventListener('click', function() {
        modal.classList.add('show');
    });

    // Close modal functions
    function closeModal() {
        modal.classList.remove('show');
        resetForm();
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    function resetForm() {
        form.reset();
        const invalidInputs = form.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        const errorMessages = form.querySelectorAll('.error-feedback');
        errorMessages.forEach(div => {
            div.textContent = '';
        });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw data;
                });
            }
            return response.json();
        })
        .then(data => {
            closeModal();
            window.location.reload();
        })
        .catch(error => {
            if (error.errors) {
                Object.keys(error.errors).forEach(field => {
                    const input = form.querySelector(`[name=${field}]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.nextElementSibling;
                        if (feedback && feedback.classList.contains('error-feedback')) {
                            feedback.textContent = error.errors[field][0];
                        }
                    }
                });
            } else {
                alert('An error occurred during import. Please try again.');
            }
        });
    });
});
</script>
@endpush
