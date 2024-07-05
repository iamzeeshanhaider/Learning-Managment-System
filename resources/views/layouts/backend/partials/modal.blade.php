<div id="general_modal_wrapper"></div>

<script>
    function handleGeneralModal(el) {
        if (el.dataset.link) {
            $('#general_modal_wrapper').load(el.dataset.link, function() {
                $('#generalModal').modal('show');
                Livewire.start(); // or Livewire.rescan();
                // Livewire.hook('component.initialized', component => {
                //     console.log('component')
                // })
            });
        }
    }
</script>
