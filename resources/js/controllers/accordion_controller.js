import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     * Automatically called when the controller is connected to the DOM.
     */
    connect() {
        // Ensures elements are focusable using Tab
        this.accordionHeadings = this.element.querySelectorAll('.accordion-heading');

        this.accordionHeadings.forEach(heading => {
            heading.setAttribute('tabindex', '0');

            // Adds the listener for keyboard behavior
            heading.addEventListener('keydown', this.handleKeydown);
        });
    }

    /**
     * Disconnects events/handlers when the controller is removed from the DOM.
     */
    disconnect() {
        this.accordionHeadings.forEach(heading => {
            // Removes the listener to avoid memory leaks
            heading.removeEventListener('keydown', this.handleKeydown);
        });
    }

    /**
     * Handles keyboard behavior for opening/closing the accordion.
     */
    handleKeydown = (event) => {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();

            const heading = event.currentTarget;
            const isExpanded = heading.getAttribute('aria-expanded') === 'true';
            heading.setAttribute('aria-expanded', !isExpanded);

            // Show/hide the associated content
            const targetId = heading.getAttribute('data-bs-target') || heading.getAttribute('aria-controls');
            if (targetId) {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.classList.toggle('show', !isExpanded);
                }
            }
        }
    };
}