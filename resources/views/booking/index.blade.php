<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visitor Pre-Registration - CAMS</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #1565c0;
            --secondary-color: #0d47a1;
            --accent-color: #bbdefb;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            font-family: 'Roboto', sans-serif;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        .nav-wrapper {
            padding: 0 15px;
        }
        
        .brand-logo {
            display: flex;
            align-items: center;
        }
        
        .section {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .page-title {
            font-weight: 500;
            margin-bottom: 1.5rem;
        }
        
        .form-card {
            border-radius: 8px;
        }
        
        .input-field .prefix.active {
            color: var(--primary-color);
        }

        .file-field .btn {
            background-color: var(--primary-color);
        }

        .input-field label.active {
            color: var(--primary-color);
        }

        .success-message {
            padding: 10px;
            background-color: #dcedc8;
            color: #33691e;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        /* Date picker style override */
        .datepicker-date-display {
            background-color: var(--primary-color);
        }

        .datepicker-table td.selected {
            background-color: var(--primary-color);
        }

        .datepicker-table td.is-today {
            color: var(--primary-color);
        }

        .datepicker-cancel, 
        .datepicker-done {
            color: var(--primary-color);
        }

        .timepicker-digital-display {
            background-color: var(--primary-color);
        }

        .timepicker-close {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="navbar-fixed">
        <nav class="blue darken-3">
            <div class="nav-wrapper">
                <a href="/" class="brand-logo">
                    <i class="material-icons">security</i>
                    CAMS
                </a>
                <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="/#features">Features</a></li>
                    <li><a href="/#about">About</a></li>
                    <li class="active"><a href="/booking"><i class="material-icons left">event</i>Visitor Pre-Registration</a></li>
                </ul>
            </div>
        </nav>
    </div>
    
    <!-- Mobile Navigation -->
    <ul class="sidenav" id="mobile-nav">
        <li><a href="/#features">Features</a></li>
        <li><a href="/#about">About</a></li>
        <li class="active"><a href="/booking"><i class="material-icons left">event</i>Visitor Pre-Registration</a></li>
    </ul>

    <main>
        <div class="section">
            <div class="container">
                <h2 class="page-title blue-text text-darken-3 center-align">Visitor Pre-Registration</h2>
                
                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="row">
                    <div class="col s12">
                        <div class="card form-card">
                            <div class="card-content">
                                <span class="card-title center-align">Please fill out the form below</span>
                                <p class="center-align">Your request will be reviewed and you will receive a confirmation.</p>
                                
                                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="row">
                                    @csrf
                                    
                                    <div class="col s12">
                                        <h5 class="blue-text text-darken-3">Visitor Information</h5>
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">person</i>
                                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="validate @error('name') invalid @enderror" required>
                                        <label for="name">Full Name</label>
                                        @error('name')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">email</i>
                                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="validate @error('email') invalid @enderror" required>
                                        <label for="email">Email Address</label>
                                        @error('email')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">phone</i>
                                        <input id="contact_number" name="contact_number" type="text" value="{{ old('contact_number') }}" class="validate @error('contact_number') invalid @enderror" required>
                                        <label for="contact_number">Contact Number</label>
                                        @error('contact_number')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">badge</i>
                                        <select id="id" name="id" class="validate @error('id') invalid @enderror">
                                            <option value="" disabled {{ old('id') ? '' : 'selected' }}>Select ID Type</option>
                                            <option value="Philippine Passport" {{ old('id') == 'Philippine Passport' ? 'selected' : '' }}>Philippine Passport</option>
                                            <option value="Philippine National ID" {{ old('id') == 'Philippine National ID' ? 'selected' : '' }}>Philippine National ID</option>
                                            <option value="Driver's License" {{ old('id') == "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                                            <option value="SSS UMID Card" {{ old('id') == 'SSS UMID Card' ? 'selected' : '' }}>SSS UMID Card</option>
                                            <option value="GSIS eCard" {{ old('id') == 'GSIS eCard' ? 'selected' : '' }}>GSIS eCard</option>
                                            <option value="PRC ID" {{ old('id') == 'PRC ID' ? 'selected' : '' }}>PRC ID</option>
                                            <option value="Postal ID" {{ old('id') == 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                                            <option value="Voter's ID / Voter's Certification" {{ old('id') == "Voter's ID / Voter's Certification" ? 'selected' : '' }}>Voter's ID / Voter's Certification</option>
                                            <option value="PhilHealth ID" {{ old('id') == 'PhilHealth ID' ? 'selected' : '' }}>PhilHealth ID</option>
                                            <option value="TIN ID" {{ old('id') == 'TIN ID' ? 'selected' : '' }}>TIN ID</option>
                                            <option value="OFW/OWWA ID" {{ old('id') == 'OFW/OWWA ID' ? 'selected' : '' }}>OFW/OWWA ID</option>
                                            <option value="PWD ID" {{ old('id') == 'PWD ID' ? 'selected' : '' }}>PWD ID</option>
                                            <option value="Senior Citizen ID" {{ old('id') == 'Senior Citizen ID' ? 'selected' : '' }}>Senior Citizen ID</option>
                                            <option value="PNP ID" {{ old('id') == 'PNP ID' ? 'selected' : '' }}>PNP ID</option>
                                        </select>
                                        <label>ID Type</label>
                                        @error('id')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="file-field input-field col s12">
                                        <div class="btn">
                                            <span>Upload ID</span>
                                            <input type="file" name="picture_of_id" accept="image/*" required>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate @error('picture_of_id') invalid @enderror" type="text" placeholder="Upload a photo of your ID">
                                            @error('picture_of_id')
                                                <span class="helper-text red-text">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">description</i>
                                        <textarea id="purpose" name="purpose" class="materialize-textarea validate @error('purpose') invalid @enderror" required>{{ old('purpose') }}</textarea>
                                        <label for="purpose">Purpose of Visit</label>
                                        @error('purpose')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">message</i>
                                        <textarea id="message" name="message" class="materialize-textarea @error('message') invalid @enderror">{{ old('message') }}</textarea>
                                        <label for="message">Additional Message (Optional)</label>
                                        @error('message')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col s12">
                                        <h5 class="blue-text text-darken-3">Group Information</h5>
                                        <div class="switch">
                                            <label>
                                                Individual Visit
                                                <input type="checkbox" id="is_group" name="is_group" value="1" {{ old('is_group') ? 'checked' : '' }}>
                                                <span class="lever"></span>
                                                Group Visit
                                            </label>
                                        </div>
                                    </div>

                                    <div id="group-section" class="col s12" style="display: none; margin-top: 20px;">
                                        <div class="row">
                                            <div class="input-field col s12 m6">
                                                <i class="material-icons prefix">group</i>
                                                <input id="group_size" name="group_size" type="number" min="2" max="20" value="{{ old('group_size', 2) }}" class="validate @error('group_size') invalid @enderror">
                                                <label for="group_size">Number of Visitors (Including yourself)</label>
                                                @error('group_size')
                                                    <span class="helper-text red-text">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div id="additional-visitors">
                                            <div class="row additional-visitor" data-index="1">
                                                <div class="col s12">
                                                    <h6>Additional Visitor #1</h6>
                                                </div>
                                                <div class="input-field col s12 m6">
                                                    <i class="material-icons prefix">person</i>
                                                    <input id="visitor_name_1" name="additional_visitors[0][name]" type="text" value="{{ old('additional_visitors.0.name') }}" class="validate">
                                                    <label for="visitor_name_1">Full Name</label>
                                                </div>
                                                <div class="input-field col s12 m6">
                                                    <i class="material-icons prefix">phone</i>
                                                    <input id="visitor_contact_1" name="additional_visitors[0][contact_number]" type="text" value="{{ old('additional_visitors.0.contact_number') }}" class="validate">
                                                    <label for="visitor_contact_1">Contact Number</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col s12">
                                                <button type="button" id="add-visitor" class="btn waves-effect waves-light blue">
                                                    <i class="material-icons left">add</i>Add More Visitors
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col s12">
                                        <h5 class="blue-text text-darken-3">Vehicle Information</h5>
                                        <div class="switch">
                                            <label>
                                                No Vehicle
                                                <input type="checkbox" id="has_vehicle" name="has_vehicle" value="1" {{ old('has_vehicle') ? 'checked' : '' }}>
                                                <span class="lever"></span>
                                                Arriving with Vehicle
                                            </label>
                                        </div>
                                    </div>

                                    <div id="vehicle-section" class="col s12" style="display: none; margin-top: 20px;">
                                        <div id="vehicles-container">
                                            <div class="row vehicle-info" data-index="0">
                                                <div class="input-field col s12 m6">
                                                    <i class="material-icons prefix">directions_car</i>
                                                    <select id="vehicle_type_0" name="vehicles[0][type]" class="validate">
                                                        <option value="" selected>Select Vehicle Type</option>
                                                        <option value="Car">Car</option>
                                                        <option value="SUV">SUV</option>
                                                        <option value="Van">Van</option>
                                                        <option value="Motorcycle">Motorcycle</option>
                                                        <option value="Truck">Truck</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <label for="vehicle_type_0">Vehicle Type</label>
                                                </div>
                                                <div class="input-field col s12 m6">
                                                    <i class="material-icons prefix">pin</i>
                                                    <input id="license_plate_0" name="vehicles[0][plate_number]" type="text" value="{{ old('vehicles.0.plate_number') }}" class="validate">
                                                    <label for="license_plate_0">License Plate Number</label>
                                                </div>
                                                <div class="input-field col s12 m6">
                                                    <i class="material-icons prefix">color_lens</i>
                                                    <input id="vehicle_color_0" name="vehicles[0][color]" type="text" value="{{ old('vehicles.0.color') }}" class="validate">
                                                    <label for="vehicle_color_0">Vehicle Color</label>
                                                </div>
                                                <div class="input-field col s12 m6">
                                                    <i class="material-icons prefix">construction</i>
                                                    <input id="vehicle_model_0" name="vehicles[0][model]" type="text" value="{{ old('vehicles.0.model') }}" class="validate">
                                                    <label for="vehicle_model_0">Make & Model (Optional)</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col s12">
                                                <button type="button" id="add-vehicle" class="btn waves-effect waves-light blue">
                                                    <i class="material-icons left">add</i>Add Another Vehicle
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col s12">
                                        <h5 class="blue-text text-darken-3">Visit Details</h5>
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">event</i>
                                        <input id="visit_date" name="visit_date" type="text" class="datepicker validate @error('visit_date') invalid @enderror" value="{{ old('visit_date') }}" required>
                                        <label for="visit_date">Visit Date</label>
                                        @error('visit_date')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">access_time</i>
                                        <input id="visit_time" name="visit_time" type="text" class="timepicker validate @error('visit_time') invalid @enderror" value="{{ old('visit_time') }}" required>
                                        <label for="visit_time">Visit Time</label>
                                        @error('visit_time')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">contacts</i>
                                        <input id="contact_person" name="contact_person" type="text" value="{{ old('contact_person') }}" class="validate @error('contact_person') invalid @enderror" required>
                                        <label for="contact_person">Contact Person</label>
                                        @error('contact_person')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">business</i>
                                        <input id="office" name="office" type="text" value="{{ old('office') }}" class="validate @error('office') invalid @enderror" required>
                                        <label for="office">Office/Department</label>
                                        @error('office')
                                            <span class="helper-text red-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col s12 center-align" style="margin-top: 20px;">
                                        <button type="submit" class="btn-large blue darken-3 waves-effect waves-light">
                                            Submit Pre-Registration
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="page-footer grey darken-3">
        <div class="footer-copyright">
            <div class="container">
                © {{ date('Y') }} Camp Access Management System. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Materialize components
            M.AutoInit();
            
            // Date picker initialization with options
            var datePicker = document.querySelectorAll('.datepicker');
            M.Datepicker.init(datePicker, {
                format: 'yyyy-mm-dd',
                minDate: new Date(),
                setDefaultDate: false,
                autoClose: true
            });
            
            // Time picker initialization with options
            var timePicker = document.querySelectorAll('.timepicker');
            M.Timepicker.init(timePicker, {
                defaultTime: '09:00',
                twelveHour: true, // Changed to true to show AM/PM
                autoClose: true,
                showClearBtn: true,
                vibrate: true,
                onCloseEnd: function() {
                    // Add AM/PM indicator to the input if it's missing
                    var timeInput = document.getElementById('visit_time');
                    var timeValue = timeInput.value;
                    if (timeValue && !timeValue.match(/AM|PM/i)) {
                        // Convert 24-hour format to 12-hour with AM/PM if needed
                        var hour = parseInt(timeValue.split(':')[0]);
                        var minute = timeValue.split(':')[1];
                        var period = hour >= 12 ? 'PM' : 'AM';
                        hour = hour % 12 || 12; // Convert to 12-hour format
                        timeInput.value = hour + ':' + minute + ' ' + period;
                    }
                }
            });

            // Show/hide group section based on checkbox
            var isGroupCheckbox = document.getElementById('is_group');
            var groupSection = document.getElementById('group-section');
            isGroupCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    groupSection.style.display = 'block';
                } else {
                    groupSection.style.display = 'none';
                }
            });

            // Add more visitors functionality
            var addVisitorButton = document.getElementById('add-visitor');
            var additionalVisitorsContainer = document.getElementById('additional-visitors');
            var visitorIndex = 1;

            addVisitorButton.addEventListener('click', function() {
                visitorIndex++;
                var newVisitorRow = document.createElement('div');
                newVisitorRow.classList.add('row', 'additional-visitor');
                newVisitorRow.setAttribute('data-index', visitorIndex);
                newVisitorRow.innerHTML = `
                    <div class="col s12">
                        <h6>Additional Visitor #${visitorIndex}</h6>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">person</i>
                        <input id="visitor_name_${visitorIndex}" name="additional_visitors[${visitorIndex - 1}][name]" type="text" class="validate">
                        <label for="visitor_name_${visitorIndex}">Full Name</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">phone</i>
                        <input id="visitor_contact_${visitorIndex}" name="additional_visitors[${visitorIndex - 1}][contact_number]" type="text" class="validate">
                        <label for="visitor_contact_${visitorIndex}">Contact Number</label>
                    </div>
                    <div class="col s12 right-align">
                        <button type="button" class="btn red remove-visitor"><i class="material-icons">remove</i>Remove</button>
                    </div>
                `;
                additionalVisitorsContainer.appendChild(newVisitorRow);
                M.updateTextFields();
                // Add remove event
                newVisitorRow.querySelector('.remove-visitor').addEventListener('click', function() {
                    newVisitorRow.remove();
                });
            });
            // Add remove button for first visitor if more than one
            function updateRemoveButtonsForVisitors() {
                var visitorRows = additionalVisitorsContainer.querySelectorAll('.additional-visitor');
                visitorRows.forEach(function(row, idx) {
                    var removeBtn = row.querySelector('.remove-visitor');
                    if (removeBtn) removeBtn.remove();
                    if (visitorRows.length > 1 && idx > 0) {
                        var col = document.createElement('div');
                        col.className = 'col s12 right-align';
                        var btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn red remove-visitor';
                        btn.innerHTML = '<i class="material-icons">remove</i>Remove';
                        btn.addEventListener('click', function() { row.remove(); updateRemoveButtonsForVisitors(); });
                        col.appendChild(btn);
                        row.appendChild(col);
                    }
                });
            }

            // Show/hide vehicle section based on checkbox
            var hasVehicleCheckbox = document.getElementById('has_vehicle');
            var vehicleSection = document.getElementById('vehicle-section');
            hasVehicleCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    vehicleSection.style.display = 'block';
                } else {
                    vehicleSection.style.display = 'none';
                }
            });

            // Add more vehicles functionality
            var addVehicleButton = document.getElementById('add-vehicle');
            var vehiclesContainer = document.getElementById('vehicles-container');
            var vehicleIndex = 0;

            addVehicleButton.addEventListener('click', function() {
                vehicleIndex++;
                var newVehicleRow = document.createElement('div');
                newVehicleRow.classList.add('row', 'vehicle-info');
                newVehicleRow.setAttribute('data-index', vehicleIndex);
                newVehicleRow.innerHTML = `
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">directions_car</i>
                        <select id="vehicle_type_${vehicleIndex}" name="vehicles[${vehicleIndex}][type]" class="validate">
                            <option value="" selected>Select Vehicle Type</option>
                            <option value="Car">Car</option>
                            <option value="SUV">SUV</option>
                            <option value="Van">Van</option>
                            <option value="Motorcycle">Motorcycle</option>
                            <option value="Truck">Truck</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="vehicle_type_${vehicleIndex}">Vehicle Type</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">pin</i>
                        <input id="license_plate_${vehicleIndex}" name="vehicles[${vehicleIndex}][plate_number]" type="text" class="validate">
                        <label for="license_plate_${vehicleIndex}">License Plate Number</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">color_lens</i>
                        <input id="vehicle_color_${vehicleIndex}" name="vehicles[${vehicleIndex}][color]" type="text" class="validate">
                        <label for="vehicle_color_${vehicleIndex}">Vehicle Color</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">construction</i>
                        <input id="vehicle_model_${vehicleIndex}" name="vehicles[${vehicleIndex}][model]" type="text" class="validate">
                        <label for="vehicle_model_${vehicleIndex}">Make & Model (Optional)</label>
                    </div>
                    <div class="col s12 right-align">
                        <button type="button" class="btn red remove-vehicle"><i class="material-icons">remove</i>Remove</button>
                    </div>
                `;
                vehiclesContainer.appendChild(newVehicleRow);
                M.updateTextFields();
                M.FormSelect.init(newVehicleRow.querySelectorAll('select'));
                // Add remove event
                newVehicleRow.querySelector('.remove-vehicle').addEventListener('click', function() {
                    newVehicleRow.remove();
                });
            });
            // Add remove button for first vehicle if more than one
            function updateRemoveButtonsForVehicles() {
                var vehicleRows = vehiclesContainer.querySelectorAll('.vehicle-info');
                vehicleRows.forEach(function(row, idx) {
                    var removeBtn = row.querySelector('.remove-vehicle');
                    if (removeBtn) removeBtn.remove();
                    if (vehicleRows.length > 1 && idx > 0) {
                        var col = document.createElement('div');
                        col.className = 'col s12 right-align';
                        var btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn red remove-vehicle';
                        btn.innerHTML = '<i class="material-icons">remove</i>Remove';
                        btn.addEventListener('click', function() { row.remove(); updateRemoveButtonsForVehicles(); });
                        col.appendChild(btn);
                        row.appendChild(col);
                    }
                });
            }

            // Add form validation for ID Type
            const form = document.querySelector('form[action="{{ route('booking.store') }}"]');
            form.addEventListener('submit', function(e) {
                const idType = document.getElementById('id');
                if (!idType.value) {
                    M.toast({html: 'Please select an ID Type!', classes: 'red'});
                    idType.focus();
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize select inputs
            var selects = document.querySelectorAll('select');
            M.FormSelect.init(selects);

            // Group registration toggle
            const isGroupCheckbox = document.getElementById('is_group');
            const groupSection = document.getElementById('group-section');

            if (isGroupCheckbox) {
                isGroupCheckbox.addEventListener('change', function() {
                    groupSection.style.display = this.checked ? 'block' : 'none';
                });
                
                // Initialize on page load
                if (isGroupCheckbox.checked) {
                    groupSection.style.display = 'block';
                }
            }

            // Add more visitors
            const addVisitorBtn = document.getElementById('add-visitor');
            const additionalVisitorsContainer = document.getElementById('additional-visitors');
            let visitorIndex = 1; // Start with 1 since we already have one additional visitor

            if (addVisitorBtn) {
                addVisitorBtn.addEventListener('click', function() {
                    visitorIndex++;
                    const newVisitor = document.createElement('div');
                    newVisitor.className = 'row additional-visitor';
                    newVisitor.dataset.index = visitorIndex;

                    newVisitor.innerHTML = `
                        <div class="col s12">
                            <h6>Additional Visitor #${visitorIndex} <a href="#" class="remove-visitor red-text"><i class="material-icons tiny">delete</i></a></h6>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">person</i>
                            <input id="visitor_name_${visitorIndex}" name="additional_visitors[${visitorIndex - 1}][name]" type="text" class="validate">
                            <label for="visitor_name_${visitorIndex}">Full Name</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">phone</i>
                            <input id="visitor_contact_${visitorIndex}" name="additional_visitors[${visitorIndex - 1}][contact_number]" type="text" class="validate">
                            <label for="visitor_contact_${visitorIndex}">Contact Number</label>
                        </div>
                    `;

                    additionalVisitorsContainer.appendChild(newVisitor);
                    
                    // Initialize the new select elements
                    const newSelects = newVisitor.querySelectorAll('select');
                    M.FormSelect.init(newSelects);

                    // Add event listener to remove button
                    const removeBtn = newVisitor.querySelector('.remove-visitor');
                    removeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        newVisitor.remove();
                        reindexVisitors();
                    });
                });
            }

            // Vehicle information toggle
            const hasVehicleCheckbox = document.getElementById('has_vehicle');
            const vehicleSection = document.getElementById('vehicle-section');

            if (hasVehicleCheckbox) {
                hasVehicleCheckbox.addEventListener('change', function() {
                    vehicleSection.style.display = this.checked ? 'block' : 'none';
                });
                
                // Initialize on page load
                if (hasVehicleCheckbox.checked) {
                    vehicleSection.style.display = 'block';
                }
            }

            // Add more vehicles
            const addVehicleBtn = document.getElementById('add-vehicle');
            const vehiclesContainer = document.getElementById('vehicles-container');
            let vehicleIndex = 0;

            if (addVehicleBtn) {
                addVehicleBtn.addEventListener('click', function() {
                    vehicleIndex++;
                    const newVehicle = document.createElement('div');
                    newVehicle.className = 'row vehicle-info';
                    newVehicle.dataset.index = vehicleIndex;

                    newVehicle.innerHTML = `
                        <div class="col s12">
                            <h6>Vehicle #${vehicleIndex + 1} <a href="#" class="remove-vehicle red-text"><i class="material-icons tiny">delete</i></a></h6>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">directions_car</i>
                            <select id="vehicle_type_${vehicleIndex}" name="vehicles[${vehicleIndex}][type]" class="validate">
                                <option value="" selected>Select Vehicle Type</option>
                                <option value="Car">Car</option>
                                <option value="SUV">SUV</option>
                                <option value="Van">Van</option>
                                <option value="Motorcycle">Motorcycle</option>
                                <option value="Truck">Truck</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="vehicle_type_${vehicleIndex}">Vehicle Type</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">pin</i>
                            <input id="license_plate_${vehicleIndex}" name="vehicles[${vehicleIndex}][plate_number]" type="text" class="validate">
                            <label for="license_plate_${vehicleIndex}">License Plate Number</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">color_lens</i>
                            <input id="vehicle_color_${vehicleIndex}" name="vehicles[${vehicleIndex}][color]" type="text" class="validate">
                            <label for="vehicle_color_${vehicleIndex}">Vehicle Color</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">construction</i>
                            <input id="vehicle_model_${vehicleIndex}" name="vehicles[${vehicleIndex}][model]" type="text" class="validate">
                            <label for="vehicle_model_${vehicleIndex}">Make & Model (Optional)</label>
                        </div>
                    `;

                    vehiclesContainer.appendChild(newVehicle);

                    // Add event listener to remove button
                    const removeBtn = newVehicle.querySelector('.remove-vehicle');
                    removeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        newVehicle.remove();
                        reindexVehicles();
                    });
                });
            }

            // Helper function to reindex visitors
            function reindexVisitors() {
                const visitors = document.querySelectorAll('.additional-visitor');
                visitors.forEach((visitor, index) => {
                    const visitorNumber = index + 1;
                    visitor.dataset.index = visitorNumber;
                    
                    // Update heading
                    const heading = visitor.querySelector('h6');
                    heading.innerHTML = `Additional Visitor #${visitorNumber} <a href="#" class="remove-visitor red-text"><i class="material-icons tiny">delete</i></a>`;
                    
                    // Update input names and IDs
                    const inputs = visitor.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const fieldName = input.name.split('[')[0];
                        const fieldType = input.name.split('][')[1].replace(']', '');
                        
                        input.name = `${fieldName}[${index}][${fieldType}]`;
                        input.id = input.id.replace(/\d+$/, visitorNumber);
                        
                        // Update associated label
                        const label = visitor.querySelector(`label[for="${input.id.replace(/\d+$/, visitorNumber - 1)}"]`);
                        if (label) {
                            label.setAttribute('for', input.id);
                        }
                    });

                    // Reattach event listener to remove button
                    const removeBtn = visitor.querySelector('.remove-visitor');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            visitor.remove();
                            reindexVisitors();
                        });
                    }
                });
            }

            // Helper function to reindex vehicles
            function reindexVehicles() {
                const vehicles = document.querySelectorAll('.vehicle-info');
                vehicles.forEach((vehicle, index) => {
                    vehicle.dataset.index = index;
                    
                    // Update heading if it exists
                    const heading = vehicle.querySelector('h6');
                    if (heading) {
                        heading.innerHTML = `Vehicle #${index + 1} <a href="#" class="remove-vehicle red-text"><i class="material-icons tiny">delete</i></a>`;
                    }
                    
                    // Update input names and IDs
                    const inputs = vehicle.querySelectorAll('input');
                    inputs.forEach(input => {
                        const fieldName = input.name.split('[')[0];
                        const fieldType = input.name.split('][')[1].replace(']', '');
                        
                        input.name = `${fieldName}[${index}][${fieldType}]`;
                        input.id = input.id.replace(/\d+$/, index);
                        
                        // Update associated label
                        const label = vehicle.querySelector(`label[for="${input.id.replace(/\d+$/, index + 1)}"]`);
                        if (label) {
                            label.setAttribute('for', input.id);
                        }
                    });

                    // Reattach event listener to remove button
                    const removeBtn = vehicle.querySelector('.remove-vehicle');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            vehicle.remove();
                            reindexVehicles();
                        });
                    }
                });
            }
        });
    </script>
    @endsection
</body>
</html>