import ClassicEditor from '@ckeditor/ckeditor5-build-classic/build/ckeditor.js';
window.ClassicEditor = ClassicEditor;

window.productCreateAlpine = () => {
    return {
        init() {
            ClassicEditor.create(this.$refs.descriptionEditor)
                        .then(editor => {
                            editor.model.document.on('change:data', () => {
                                const wireComponent = document.getElementById("wireCreateProductComponent");
                                Livewire.find(wireComponent.getAttribute("wire:id")).set('description', editor.getData());
                            })
                        });
        }
    };
}
