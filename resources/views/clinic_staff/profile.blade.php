<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Staff Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .stepper { display:flex; justify-content:center; margin-bottom:30px; padding-left: 0; }
        .step { list-style:none; text-align:center; padding:0 15px; position: relative; flex: 1; }
        .step:not(:last-child)::after { content: ''; position: absolute; top: 15px; left: 50%; width: 100%; height: 2px; background-color: #ddd; z-index: 1; }
        .step span { position: relative; z-index: 2; display:inline-block; width:30px; height:30px; line-height:30px; border-radius:50%; margin-bottom:5px; font-weight:bold; background:#ddd; color:#000; }
        .step.active span { background:#0d6efd;color:#fff; }
        .step.completed span, .step.completed::after { background:#198754; color:#fff; }
        .step div { font-size:0.85rem; }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { display: block; }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4 text-center">Clinic Staff Profile</h2>

    <ul class="stepper">
        <li class="step active" data-step-indicator="1">
            <span>1</span>
            <div>Personal Info</div>
        </li>
        <li class="step" data-step-indicator="2">
            <span>2</span>
            <div>Contact Info</div>
        </li>
        <li class="step" data-step-indicator="3">
            <span>3</span>
            <div>Credentials</div>
        </li>
    </ul>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clinic_staff.profile.update') }}" method="POST" id="profileForm">
        @csrf
        @method('PUT')

        <div class="card mb-4 step-card" data-step="1">
            <div class="card-header bg-primary text-white">Personal Information</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">School ID *</label>
                    <input type="text" name="school_id" class="form-control" value="{{ old('school_id', $info?->school_id) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">First Name *</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $info?->first_name) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $info?->middle_name) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $info?->last_name) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender *</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="male" @selected(old('gender', $info?->gender) == 'male')>Male</option>
                            <option value="female" @selected(old('gender', $info?->gender) == 'female')>Female</option>
                            <option value="other" @selected(old('gender', $info?->gender) == 'other')>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date of Birth *</label>
                        <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $info?->birthdate) }}" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary next-btn">Next</button>
                </div>
            </div>
        </div>

        <div class="card mb-4 step-card" data-step="2" style="display:none;">
            <div class="card-header bg-info text-white">Contact Information</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Address *</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $info?->address) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone *</label>
                    <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no', $info?->contact_no) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Emergency Contact Name *</label>
                        <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $info?->emergency_contact_name) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Emergency Contact Number *</label>
                        <input type="text" name="emergency_contact_no" class="form-control" value="{{ old('emergency_contact_no', $info?->emergency_contact_no) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Relationship *</label>
                        <input type="text" name="emergency_contact_relationship" class="form-control" value="{{ old('emergency_contact_relationship', $info?->emergency_contact_relationship) }}" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary prev-btn">Back</button>
                    <button type="button" class="btn btn-primary next-btn">Next</button>
                </div>
            </div>
        </div>

        <div class="card mb-4 step-card" data-step="3" style="display:none;">
            <div class="card-header bg-success text-white">Professional Credentials</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Credential Type *</label>
                    <select name="credential_type" class="form-select" id="credential_type" required>
                        <option value="">Select Credential Type</option>
                        <option value="license" @selected(old('credential_type', optional($credential)->credential_type) == 'license')>License</option>
                        <option value="degree" @selected(old('credential_type', optional($credential)->credential_type) == 'degree')>Degree</option>
                    </select>
                </div>
                <div class="mb-3" id="license_div" style="display:none;">
                    <label class="form-label">License Name *</label>
                    <input type="text" name="license_type" class="form-control" value="{{ old('license_type', optional($credential)->license_type) }}">
                </div>
                <div class="mb-3" id="degree_div" style="display:none;">
                    <label class="form-label">Degree Name *</label>
                    <input type="text" name="degree" class="form-control" value="{{ old('degree', optional($credential)->degree) }}">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary prev-btn">Back</button>
                    <button type="submit" class="btn btn-success">Save Profile</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.step-card');
    const stepIndicators = document.querySelectorAll('.stepper .step');
    let currentStep = 0;

    // Function to show a specific step
    const showStep = (index) => {
        steps.forEach((step, i) => {
            step.style.display = i === index ? 'block' : 'none';
        });
        updateStepper(index);
        currentStep = index;
    };

    // Function to update the visual stepper indicators
    const updateStepper = (index) => {
        stepIndicators.forEach((indicator, i) => {
            indicator.classList.remove('active', 'completed');
            if (i < index) {
                indicator.classList.add('completed');
            } else if (i === index) {
                indicator.classList.add('active');
            }
        });
    };

    // Function to validate fields in the current step
    const validateStep = (index) => {
        let isValid = true;
        const currentCard = steps[index];
        const inputs = currentCard.querySelectorAll('input[required], select[required]');
        
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
            if (!input.value) {
                isValid = false;
                input.classList.add('is-invalid');
            }
        });
        return isValid;
    };

    // Event listeners for "Next" buttons
    document.querySelectorAll('.next-btn').forEach(button => {
        button.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep < steps.length - 1) {
                    showStep(currentStep + 1);
                }
            }
        });
    });

    // Event listeners for "Back" buttons
    document.querySelectorAll('.prev-btn').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                showStep(currentStep - 1);
            }
        });
    });

    // --- Credential Toggle Logic ---
    const credentialType = document.getElementById('credential_type');
    const licenseDiv = document.getElementById('license_div');
    const licenseInput = licenseDiv.querySelector('input');
    const degreeDiv = document.getElementById('degree_div');
    const degreeInput = degreeDiv.querySelector('input');

    const toggleCredentialFields = () => {
        if (!credentialType) return;
        
        if (credentialType.value === 'license') {
            licenseDiv.style.display = 'block';
            licenseInput.required = true;
            degreeDiv.style.display = 'none';
            degreeInput.required = false;
        } else if (credentialType.value === 'degree') {
            licenseDiv.style.display = 'none';
            licenseInput.required = false;
            degreeDiv.style.display = 'block';
            degreeInput.required = true;
        } else {
            licenseDiv.style.display = 'none';
            licenseInput.required = false;
            degreeDiv.style.display = 'none';
            degreeInput.required = false;
        }
    };
    
    credentialType?.addEventListener('change', toggleCredentialFields);
    
    // Initialize form state on page load
    showStep(0);
    toggleCredentialFields();
});
</script>
</body>
</html>