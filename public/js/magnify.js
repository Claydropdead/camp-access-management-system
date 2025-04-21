/**
 * Image Magnify/Zoom Functionality
 * For Camp Access Management System
 */

class ImageMagnifier {
    constructor() {
        this.zoomLevel = 2; // Default zoom level
        this.activeContainers = new Map(); // Track active containers and their elements
        this.init();
    }

    init() {
        // Find all elements with magnify-container class
        document.addEventListener('DOMContentLoaded', () => {
            this.setupMagnifiers();
        });

        // Also allow dynamic initialization for modals that load after DOMContentLoaded
        window.initMagnifiers = () => this.setupMagnifiers();
    }

    setupMagnifiers() {
        const magnifiables = document.querySelectorAll('.magnify-container');
        
        magnifiables.forEach(container => {
            // Avoid re-initializing
            if (container.dataset.magnifierInitialized === 'true') {
                return;
            }
            
            const image = container.querySelector('img');
            if (!image) return;

            // Create magnify button
            const magnifyBtn = document.createElement('button');
            magnifyBtn.className = 'magnify-btn';
            magnifyBtn.innerHTML = '<i class="material-icons">zoom_in</i>';
            magnifyBtn.title = 'Click to magnify image';
            container.appendChild(magnifyBtn);

            // Create lens element (will be shown when magnifying)
            const lens = document.createElement('div');
            lens.className = 'magnify-lens';
            lens.style.display = 'none';
            container.appendChild(lens);

            // Create magnified view container
            const magnifiedView = document.createElement('div');
            magnifiedView.className = 'magnified-view';
            magnifiedView.style.display = 'none';
            document.body.appendChild(magnifiedView);

            // Store these elements for this container
            this.activeContainers.set(container, {
                image: image,
                lens: lens,
                magnifiedView: magnifiedView,
                isActive: false
            });

            // Mark as initialized
            container.dataset.magnifierInitialized = 'true';

            // Button click event
            magnifyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggleMagnifier(container);
            });

            // Event: Mouse movement over image
            container.addEventListener('mousemove', (e) => {
                const elements = this.activeContainers.get(container);
                if (elements && elements.isActive) {
                    this.moveLens(e, container);
                }
            });

            // Event: Mouse leave container
            container.addEventListener('mouseleave', () => {
                const elements = this.activeContainers.get(container);
                if (elements && elements.isActive) {
                    // Only hide lens when mouse leaves, but keep magnifier active
                    this.hideLens(container);
                }
            });
            
            // Event: Mouse enter container
            container.addEventListener('mouseenter', (e) => {
                const elements = this.activeContainers.get(container);
                if (elements && elements.isActive) {
                    this.showLens(container);
                    this.moveLens(e, container);
                }
            });
        });
    }

    toggleMagnifier(container) {
        const elements = this.activeContainers.get(container);
        if (!elements) return;
        
        elements.isActive = !elements.isActive;
        
        if (elements.isActive) {
            this.activateMagnifier(container);
        } else {
            this.deactivateMagnifier(container);
        }
    }

    activateMagnifier(container) {
        const elements = this.activeContainers.get(container);
        if (!elements) return;
        
        const { image, lens, magnifiedView } = elements;
        
        // Set background image for magnified view
        magnifiedView.style.backgroundImage = `url('${image.src}')`;
        container.classList.add('magnify-active');
        
        // Position the magnified view
        this.positionMagnifiedView(container);
        
        // Show lens and magnified view
        this.showLens(container);
        
        // Update button to show active state
        const magnifyBtn = container.querySelector('.magnify-btn');
        if (magnifyBtn) {
            magnifyBtn.innerHTML = '<i class="material-icons">zoom_out</i>';
            magnifyBtn.title = 'Click to disable magnify';
            magnifyBtn.classList.add('active');
        }
    }

    deactivateMagnifier(container) {
        const elements = this.activeContainers.get(container);
        if (!elements) return;
        
        const { lens, magnifiedView } = elements;
        
        // Hide lens and magnified view
        lens.style.display = 'none';
        magnifiedView.style.display = 'none';
        container.classList.remove('magnify-active');
        
        // Update button to show inactive state
        const magnifyBtn = container.querySelector('.magnify-btn');
        if (magnifyBtn) {
            magnifyBtn.innerHTML = '<i class="material-icons">zoom_in</i>';
            magnifyBtn.title = 'Click to magnify image';
            magnifyBtn.classList.remove('active');
        }
    }

    showLens(container) {
        const elements = this.activeContainers.get(container);
        if (!elements) return;
        
        const { lens, magnifiedView } = elements;
        lens.style.display = 'block';
        magnifiedView.style.display = 'block';
    }

    hideLens(container) {
        const elements = this.activeContainers.get(container);
        if (!elements) return;
        
        const { lens, magnifiedView } = elements;
        lens.style.display = 'none';
        magnifiedView.style.display = 'none';
    }

    moveLens(e, container) {
        // Prevent default behavior
        e.preventDefault();
        
        const elements = this.activeContainers.get(container);
        if (!elements) return;
        
        const { image, lens, magnifiedView } = elements;
        
        // Get cursor position
        const pos = this.getCursorPos(e, container);
        
        // Calculate position
        let x = pos.x - (lens.offsetWidth / 2);
        let y = pos.y - (lens.offsetHeight / 2);
        
        // Get image dimensions
        const imageWidth = image.offsetWidth;
        const imageHeight = image.offsetHeight;
        
        // Prevent lens from going outside the image
        if (x > imageWidth - lens.offsetWidth) {
            x = imageWidth - lens.offsetWidth;
        }
        if (x < 0) {
            x = 0;
        }
        if (y > imageHeight - lens.offsetHeight) {
            y = imageHeight - lens.offsetHeight;
        }
        if (y < 0) {
            y = 0;
        }
        
        // Position the lens
        lens.style.left = x + "px";
        lens.style.top = y + "px";
        
        // Move the magnified view background
        const ratioX = magnifiedView.offsetWidth / lens.offsetWidth;
        const ratioY = magnifiedView.offsetHeight / lens.offsetHeight;
        
        magnifiedView.style.backgroundPosition = `-${x * ratioX}px -${y * ratioY}px`;
        magnifiedView.style.backgroundSize = `${imageWidth * ratioX}px ${imageHeight * ratioY}px`;
    }

    getCursorPos(e, container) {
        let rect = container.getBoundingClientRect();
        let x = e.clientX - rect.left;
        let y = e.clientY - rect.top;
        return { x, y };
    }

    positionMagnifiedView(container) {
        const elements = this.activeContainers.get(container);
        if (!elements) return;
        
        const { image, magnifiedView } = elements;
        
        // Position the magnified view next to the image
        const imageRect = container.getBoundingClientRect();
        
        // Check if there's enough space on the right
        if (imageRect.right + 20 + 300 < window.innerWidth) {
            // Position to right
            magnifiedView.style.left = `${imageRect.right + 20}px`;
            magnifiedView.style.top = `${imageRect.top}px`;
        } else if (imageRect.left - 20 - 300 > 0) {
            // Position to left
            magnifiedView.style.left = `${imageRect.left - 20 - 300}px`;
            magnifiedView.style.top = `${imageRect.top}px`;
        } else {
            // Position below
            magnifiedView.style.left = `${imageRect.left}px`;
            magnifiedView.style.top = `${imageRect.bottom + 20}px`;
        }
    }
}

// Initialize the magnifier
const imageMagnifier = new ImageMagnifier();