/**
 * Advanced RFID Card Scanner Implementation
 * For Camp Access Management System
 * 
 * Enhanced with smooth animations and interactive elements
 */

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const scannerContainer = document.getElementById('rfid-scanner-container');
    const scanAnimation = document.getElementById('scan-animation');
    const scannerOverlay = document.getElementById('scanner-overlay');
    const cardNumberInput = document.getElementById('card_number');
    const startScanButton = document.getElementById('start-scan-button');
    const manualInputButton = document.getElementById('manual-input-button');
    const scannerModal = document.getElementById('scanner-modal');
    const successScanElement = document.getElementById('success-scan');
    const loadingElement = document.getElementById('loading-animation');
    const closeButton = document.getElementById('close-scanner-button');
    const cardPlaceholder = document.querySelector('.rfid-card-placeholder');
    
    // Scanning state variables
    let isScanning = false;
    let scanBuffer = '';
    let lastKeyTime = 0;
    let scanTimeout = null;
    
    // Add ripple effect to scan button
    if (startScanButton) {
        startScanButton.addEventListener('mousedown', createRipple);
    }
    
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = `${size}px`;
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;
        ripple.classList.add('ripple');
        
        // Remove existing ripples
        const existingRipple = button.querySelector('.ripple');
        if (existingRipple) {
            existingRipple.remove();
        }
        
        button.appendChild(ripple);
        
        // Remove ripple after animation completes
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    // Toggle between scanner and manual input modes
    if (manualInputButton) {
        manualInputButton.addEventListener('click', function() {
            toggleScannerMode(false);
        });
    }
    
    if (startScanButton) {
        startScanButton.addEventListener('click', function() {
            toggleScannerMode(true);
            startScanning();
        });
    }
    
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            toggleScannerMode(false);
            stopScanning();
        });
    }
    
    function toggleScannerMode(showScanner) {
        if (scannerModal) {
            if (showScanner) {
                // Show modal with smooth entrance
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
                scannerModal.classList.remove('hidden');
                scannerModal.classList.add('flex');
                
                // Add a slight delay before adding the active class for smoother animation
                setTimeout(() => {
                    scannerModal.classList.add('active');
                    if (cardPlaceholder) {
                        cardPlaceholder.classList.add('card-ready');
                    }
                }, 10);
            } else {
                // Hide modal with smooth exit
                scannerModal.classList.remove('active');
                if (cardPlaceholder) {
                    cardPlaceholder.classList.remove('card-ready');
                }
                
                setTimeout(() => {
                    scannerModal.classList.remove('flex');
                    scannerModal.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                }, 300);
            }
        }
    }
    
    function startScanning() {
        isScanning = true;
        scanBuffer = '';
        
        if (loadingElement) loadingElement.style.display = 'flex';
        if (successScanElement) successScanElement.style.display = 'none';
        
        // Add a card-scanning class to the card placeholder for animation
        if (cardPlaceholder) {
            cardPlaceholder.classList.add('scanning');
        }
        
        // Show scanning animation
        if (scanAnimation) {
            scanAnimation.classList.add('active');
        }
        
        if (scannerOverlay) {
            scannerOverlay.classList.add('scanning');
        }
        
        // Focus on the scan area
        document.body.focus();
        
        // Add audio feedback when scanning starts
        playSound('scan-start');
    }
    
    function stopScanning() {
        isScanning = false;
        
        if (scanAnimation) {
            scanAnimation.classList.remove('active');
        }
        
        if (scannerOverlay) {
            scannerOverlay.classList.remove('scanning');
            scannerOverlay.classList.remove('success');
        }
        
        if (cardPlaceholder) {
            cardPlaceholder.classList.remove('scanning');
        }
        
        // Clear any pending scan timeout
        if (scanTimeout) {
            clearTimeout(scanTimeout);
            scanTimeout = null;
        }
    }
    
    function processScanSuccess(scannedValue) {
        // Hide loading, show success message
        if (loadingElement) loadingElement.style.display = 'none';
        if (successScanElement) {
            successScanElement.style.display = 'flex';
            const scannedNumber = successScanElement.querySelector('.scanned-number');
            if (scannedNumber) {
                scannedNumber.textContent = scannedValue;
                // Add a typing animation to the scanned number
                typeWriterEffect(scannedNumber, scannedValue);
            }
        }
        
        // Update the input field with the scanned number
        if (cardNumberInput) {
            cardNumberInput.value = scannedValue;
            
            // Add a highlight effect to the input field
            cardNumberInput.classList.add('highlight-success');
            setTimeout(() => {
                cardNumberInput.classList.remove('highlight-success');
            }, 2000);
        }
        
        // Add scan complete animation
        if (scanAnimation) {
            scanAnimation.classList.remove('active');
            scanAnimation.classList.add('complete');
        }
        
        if (scannerOverlay) {
            scannerOverlay.classList.remove('scanning');
            scannerOverlay.classList.add('success');
        }
        
        if (cardPlaceholder) {
            cardPlaceholder.classList.remove('scanning');
            cardPlaceholder.classList.add('success');
        }
        
        // Add audio feedback for successful scan
        playSound('scan-complete');
        
        // Close scanner modal after showing success
        setTimeout(function() {
            toggleScannerMode(false);
            
            // Reset scanner classes after closing
            setTimeout(function() {
                if (scanAnimation) {
                    scanAnimation.classList.remove('complete');
                }
                if (scannerOverlay) {
                    scannerOverlay.classList.remove('success');
                }
                if (cardPlaceholder) {
                    cardPlaceholder.classList.remove('success');
                }
            }, 500);
        }, 1800);
    }
    
    // Typewriter effect for displaying the scanned number
    function typeWriterEffect(element, text) {
        if (!element) return;
        
        element.textContent = '';
        let i = 0;
        
        function type() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(type, 50);
            }
        }
        
        type();
    }
    
    // Play sound effects (optional - will only work if sounds are added)
    function playSound(soundName) {
        try {
            const sound = document.getElementById(soundName);
            if (sound) {
                sound.currentTime = 0;
                sound.play().catch(e => {
                    // Silent catch - browser may block autoplay
                });
            }
        } catch (e) {
            // Silent catch if sounds aren't implemented
        }
    }
    
    // Listen for RFID scanner input (typically comes as keyboard input)
    document.addEventListener('keydown', function(event) {
        // Check for escape key to close the modal
        if (event.key === 'Escape' && scannerModal && !scannerModal.classList.contains('hidden')) {
            toggleScannerMode(false);
            stopScanning();
            return;
        }
        
        // Only process input if the scanner is active
        if (!isScanning || scannerModal.classList.contains('hidden')) {
            return;
        }
        
        const currentTime = new Date().getTime();
        
        // RFID readers typically send characters rapidly
        // If there's a gap greater than 50ms between keystrokes, it's probably not from scanner
        if (currentTime - lastKeyTime > 200 && scanBuffer.length > 0) {
            // Reset the scan buffer if the timing suggests this is a new scan
            scanBuffer = '';
        }
        
        // Update the last key time
        lastKeyTime = currentTime;
        
        // Ignore specific keys that wouldn't be part of an RFID scan
        if (event.key === 'Shift' || event.key === 'Control' || event.key === 'Alt' || 
            event.key === 'Tab' || event.key === 'CapsLock' || event.key === 'Escape') {
            return;
        }
        
        // Prevent the key from being entered in any active form field
        event.preventDefault();
        
        // Animate the scanning effect when keys are received
        if (cardPlaceholder) {
            cardPlaceholder.classList.add('receiving');
            setTimeout(() => {
                cardPlaceholder.classList.remove('receiving');
            }, 150);
        }
        
        // If Enter key is received, process the complete scan
        if (event.key === 'Enter') {
            if (scanBuffer.length > 0) {
                processScanSuccess(scanBuffer.trim());
                scanBuffer = '';
            }
            return;
        }
        
        // Add the character to the scan buffer
        scanBuffer += event.key;
        
        // Clear any existing timeout
        if (scanTimeout) {
            clearTimeout(scanTimeout);
        }
        
        // Set a timeout to process the scan if no more characters are received
        scanTimeout = setTimeout(function() {
            if (scanBuffer.length > 0) {
                processScanSuccess(scanBuffer.trim());
                scanBuffer = '';
            }
        }, 300); // Adjust this timeout based on your RFID reader's behavior
    });
    
    // Add animated hover effect to the scanner container
    if (scannerContainer) {
        scannerContainer.addEventListener('mousemove', function(e) {
            const rect = scannerContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const angleX = (y - centerY) / 15;
            const angleY = (centerX - x) / 15;
            
            if (cardPlaceholder) {
                cardPlaceholder.style.transform = `translate(-50%, -50%) rotateX(${angleX}deg) rotateY(${angleY}deg)`;
            }
        });
        
        scannerContainer.addEventListener('mouseleave', function() {
            if (cardPlaceholder) {
                cardPlaceholder.style.transform = 'translate(-50%, -50%) rotateX(0deg) rotateY(0deg)';
            }
        });
    }
    
    // Enable keyboard shortcut to start scanning (Ctrl+S)
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.key === 's' && startScanButton) {
            event.preventDefault();
            startScanButton.click();
        }
    });
});