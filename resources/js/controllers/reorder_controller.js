import ApplicationController from "./application_controller"
import Sortable from 'sortablejs';

export default class extends ApplicationController {

    static values = {
        handleSelector: String,
        sortableSelector: String
    }

    connect() {
        this.initSortable();
    }

    initSortable() {
        new Sortable(this.element.closest(this.sortableSelectorValue), {
            animation: 150,
            handle: this.handleSelectorValue,
            dragClass: "reorder-drag",
            onEnd: (event) => {
                this.reorderElement(event.item, event.newIndex - event.oldIndex);
            },
        });
    }

    reorderElement(item, offset) {
        const handle = item.querySelector(this.handleSelectorValue);

        if (handle === null) {
            return;
        }

        axios
            .post(handle.dataset.action, {
                key: handle.dataset.key,
                offset: offset,
            })
            .then(
                () => this.alert(handle.dataset.successMessage, '', 'success')
            )
            .catch(
                () => this.alert(handle.dataset.failureMessage, '', 'error')
            );
    }
}
