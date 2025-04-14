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
                                        <select id="id" name="id" class="validate @error('id') invalid @enderror" required>
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
        });
    </script>
</body>
</html>