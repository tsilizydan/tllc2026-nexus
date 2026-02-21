/**
 * TSILIZY Nexus — Application JavaScript
 *
 * Core client-side utilities: CSRF, AJAX helpers, task reordering,
 * auto-save, keyboard shortcuts.
 */

const Nexus = {
    /**
     * Get CSRF token from the page
     */
    getCsrfToken() {
        const el = document.querySelector('input[name="_csrf_token"]');
        return el ? el.value : '';
    },

    /**
     * POST request with CSRF token
     */
    async post(url, data = {}) {
        data._csrf_token = this.getCsrfToken();
        const formData = new FormData();
        for (const [key, val] of Object.entries(data)) {
            formData.append(key, val);
        }
        const res = await fetch(url, { method: 'POST', body: formData });
        return res.json();
    },

    /**
     * Confirm & POST (delete actions, etc.)
     */
    async confirmPost(msg, url, data = {}) {
        if (!confirm(msg)) return false;
        return this.post(url, data);
    },

    /**
     * Auto-save: debounced POST for notes
     */
    createAutoSave(url, getDataFn, delayMs = 2000) {
        let timer = null;
        return function trigger() {
            clearTimeout(timer);
            timer = setTimeout(async () => {
                try {
                    const data = getDataFn();
                    await Nexus.post(url, data);
                    console.log('[Nexus] Auto-saved');
                } catch (err) {
                    console.error('[Nexus] Auto-save failed:', err);
                }
            }, delayMs);
        };
    },

    /**
     * Sortable: simple drag-and-drop reordering
     */
    initSortable(containerSelector, onReorderFn) {
        const container = document.querySelector(containerSelector);
        if (!container) return;

        let dragged = null;

        container.addEventListener('dragstart', (e) => {
            dragged = e.target.closest('[draggable]');
            if (dragged) dragged.classList.add('dragging');
        });

        container.addEventListener('dragend', () => {
            if (dragged) dragged.classList.remove('dragging');
            dragged = null;
        });

        container.addEventListener('dragover', (e) => {
            e.preventDefault();
            const afterElement = getDragAfterElement(container, e.clientY);
            if (afterElement) {
                container.insertBefore(dragged, afterElement);
            } else {
                container.appendChild(dragged);
            }
        });

        container.addEventListener('drop', () => {
            const items = [...container.querySelectorAll('[draggable]')];
            const order = items.map((el, idx) => ({
                id: el.dataset.id,
                sort_order: idx
            }));
            if (onReorderFn) onReorderFn(order);
        });

        function getDragAfterElement(container, y) {
            const elements = [...container.querySelectorAll('[draggable]:not(.dragging)')];
            return elements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset, element: child };
                }
                return closest;
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }
    },

    /**
     * Keyboard shortcuts
     */
    initShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Cmd/Ctrl+K → focus search
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('input[placeholder*="Rechercher"]');
                if (searchInput) searchInput.focus();
            }
        });
    },

    /**
     * Initialize
     */
    init() {
        this.initShortcuts();
    }
};

// Auto-init when DOM is ready
document.addEventListener('DOMContentLoaded', () => Nexus.init());
