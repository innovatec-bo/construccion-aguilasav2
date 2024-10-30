import { Modal } from 'bootstrap';

let modalsElement = document.getElementById('livewire-bootstrap-modal');

modalsElement.addEventListener('hidden.bs.modal', () => {
    Livewire.dispatch('resetModal');
});

Livewire.on('showBootstrapModal', (e) => {
    setTimeout(() => {
        let modal = Modal.getOrCreateInstance(modalsElement)
        modal.show();    
    }, 100);
});

Livewire.on('hideModal', () => {
    let modal = Modal.getInstance(modalsElement);
    modal.hide();
   ;
    Livewire.dispatch('resetModal');


});
