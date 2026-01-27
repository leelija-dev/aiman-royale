document.addEventListener('DOMContentLoaded', function() {
    class MultiSelect {
        constructor(selectElement) {
            this.select = selectElement;
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'custom-multiselect';
            this.wrapper.tabIndex = 0;
            
            this.selectedContainer = document.createElement('div');
            this.selectedContainer.className = 'selected-items';
            
            this.dropdown = document.createElement('div');
            this.dropdown.className = 'dropdown-options';
            
            this.setup();
            this.bindEvents();
        }
        
        setup() {
            // Create wrapper structure
            this.wrapper.innerHTML = `
                <div class="select-box">
                    <div class="selected-items"></div>
                    <div class="arrow">▼</div>
                </div>
                <div class="dropdown-options"></div>
            `;
            
            // Replace original select with our custom one
            this.select.style.display = 'none';
            this.select.parentNode.insertBefore(this.wrapper, this.select);
            
            this.selectedContainer = this.wrapper.querySelector('.selected-items');
            this.dropdown = this.wrapper.querySelector('.dropdown-options');
            
            // Create options
            Array.from(this.select.options).forEach(option => {
                if (option.value) {
                    const optionEl = document.createElement('div');
                    optionEl.className = 'option';
                    optionEl.innerHTML = `
                        <input type="checkbox" id="${this.select.name}-${option.value}" 
                               value="${option.value}" ${option.selected ? 'checked' : ''}>
                        <label for="${this.select.name}-${option.value}">${option.text}</label>
                    `;
                    this.dropdown.appendChild(optionEl);
                }
            });
            
            this.updateSelected();
        }
        
        bindEvents() {
            // Toggle dropdown
            this.wrapper.querySelector('.select-box').addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleDropdown();
            });
            
            // Handle option selection
            this.dropdown.addEventListener('click', (e) => {
                const checkbox = e.target.closest('input[type="checkbox"]');
                if (checkbox) {
                    this.updateSelected();
                    this.updateOriginalSelect();
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', () => {
                this.closeDropdown();
            });
        }
        
        toggleDropdown() {
            this.wrapper.classList.toggle('open');
        }
        
        closeDropdown() {
            this.wrapper.classList.remove('open');
        }
        
        updateSelected() {
            const selected = [];
            const checkboxes = this.dropdown.querySelectorAll('input[type="checkbox"]:checked');
            
            checkboxes.forEach(checkbox => {
                const label = checkbox.nextElementSibling.textContent;
                selected.push(`<span class="selected-item">${label}</span>`);
            });
            
            if (selected.length > 0) {
                this.selectedContainer.innerHTML = selected.join('');
                this.wrapper.classList.add('has-selection');
            } else {
                this.selectedContainer.innerHTML = '<span class="placeholder">' + this.select.getAttribute('data-placeholder') + '</span>';
                this.wrapper.classList.remove('has-selection');
            }
        }
        
        updateOriginalSelect() {
            const checkboxes = this.dropdown.querySelectorAll('input[type="checkbox"]');
            
            // Update original select options
            Array.from(this.select.options).forEach(option => {
                if (option.value) {
                    const checkbox = this.dropdown.querySelector(`input[value="${option.value}"]`);
                    option.selected = checkbox.checked;
                }
            });
            
            // Trigger change event on original select
            const event = new Event('change');
            this.select.dispatchEvent(event);
        }
    }
    
    // Initialize all multiselects
    document.querySelectorAll('select[multiple]').forEach(select => {
        new MultiSelect(select);
    });
});
