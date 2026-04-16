/**
 * Tag Management System
 * Handles AJAX tag search, creation, and selection across admin modals
 */

class TagManager {
    constructor(config) {
        this.inputId = config.inputId;
        this.dropdownId = config.dropdownId;
        this.selectedTagsId = config.selectedTagsId;
        this.hiddenInputId = config.hiddenInputId;
        this.searchUrl = config.searchUrl;
        this.createUrl = config.createUrl;

        this.selectedTags = config.existingTags || {};
        this.init();
        
        // Update display to attach event listeners to existing tags
        if (Object.keys(this.selectedTags).length > 0) {
            this.updateDisplay();
        }
    }

    init() {
        const input = document.getElementById(this.inputId);
        if (!input) return;

        input.addEventListener('input', (e) => this.handleSearch(e));
        document.addEventListener('click', (e) => this.handleClickOutside(e));
    }

    async handleSearch(e) {
        const search = e.target.value.trim();
        const dropdown = document.getElementById(this.dropdownId);

        if (search.length < 1) {
            dropdown.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`${this.searchUrl}?search=${encodeURIComponent(search)}`);
            const tags = await response.json();

            dropdown.innerHTML = '';

            // Show existing tags
            if (tags.length > 0) {
                tags.forEach(tag => {
                    if (!this.selectedTags[tag.id]) {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-2 hover:bg-gray-800 cursor-pointer text-white text-sm';
                        div.innerHTML = `<i class="fas fa-tag text-purple-400 mr-2"></i>${tag.name}`;
                        div.onclick = () => this.addTag(tag.id, tag.name);
                        dropdown.appendChild(div);
                    }
                });
            }

            // Show "create new" option
            const createDiv = document.createElement('div');
            createDiv.className = 'px-4 py-2 hover:bg-gray-800 cursor-pointer text-white text-sm border-t border-gray-700';
            createDiv.innerHTML = `<i class="fas fa-plus text-green-400 mr-2"></i>Create new: <strong>"${search}"</strong>`;
            createDiv.onclick = () => this.createTag(search);
            dropdown.appendChild(createDiv);

            dropdown.classList.remove('hidden');
        } catch (error) {
            console.error('Error searching tags:', error);
        }
    }

    addTag(id, name) {
        this.selectedTags[id] = name;
        this.updateDisplay();
        document.getElementById(this.inputId).value = '';
        document.getElementById(this.dropdownId).classList.add('hidden');
    }

    async createTag(name) {
        try {
            const response = await fetch(this.createUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                body: JSON.stringify({ name }),
            });

            const tag = await response.json();
            this.addTag(tag.id, tag.name);
        } catch (error) {
            console.error('Error creating tag:', error);
            alert('Failed to create tag. It may already exist.');
        }
    }

    updateDisplay() {
        const container = document.getElementById(this.selectedTagsId);
        const hiddenInput = document.getElementById(this.hiddenInputId);

        container.innerHTML = '';
        const tagIds = Object.keys(this.selectedTags);

        tagIds.forEach(id => {
            const span = document.createElement('span');
            span.className = 'px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs font-medium flex items-center gap-2';
            span.innerHTML = `
                <i class="fas fa-tag"></i>
                ${this.selectedTags[id]}
                <button type="button" class="text-purple-300 hover:text-purple-200 remove-tag-btn" data-tag-id="${id}">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;
            container.appendChild(span);
        });

        // Attach event listeners to remove buttons
        container.querySelectorAll('.remove-tag-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.removeTag(btn.dataset.tagId);
            });
        });

        // Only set hidden input if it exists (for backwards compatibility)
        if (hiddenInput) {
            hiddenInput.value = JSON.stringify(tagIds);
        }
    }

    removeTag(id) {
        delete this.selectedTags[id];
        this.updateDisplay();
    }

    getSelectedTags() {
        return this.selectedTags;
    }

    handleClickOutside(e) {
        const input = document.getElementById(this.inputId);
        const dropdown = document.getElementById(this.dropdownId);

        if (input && dropdown && e.target !== input && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    }

    submitForm(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return;

        form.addEventListener('submit', (e) => {
            // Remove the hidden JSON input if it exists (to avoid validation issues)
            const hiddenInput = document.getElementById(this.hiddenInputId);
            if (hiddenInput) {
                hiddenInput.remove();
            }

            // Create hidden inputs for each tag
            const tagIds = Object.keys(this.selectedTags);
            tagIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'tags[]';
                input.value = this.selectedTags[id];
                form.appendChild(input);
            });

            // Add a flag to indicate form was submitted (for backend to know whether to clear tags)
            const submitFlag = document.createElement('input');
            submitFlag.type = 'hidden';
            submitFlag.name = '_tags_submitted';
            submitFlag.value = '1';
            form.appendChild(submitFlag);
        });
    }
}

// Global tag managers registry
const tagManagers = {};

// Helper function to initialize tag manager
function initializeTagManager(config) {
    const manager = new TagManager(config);
    tagManagers[config.inputId] = manager;
    return manager;
}
