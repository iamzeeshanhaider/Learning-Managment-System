@props([
    'selected' => null,
    'title' => 'Batches:',
    'has_route' => false,
])
<div class="">
    <label for="batches-select" class="text-muted p-2">{{ $title }}</label>

    <select class="form-control-lg" data-search="on" id="batches-select">
        @if ($selected !== null)
            <option value="{{ $selected->slug }}">
                {{ $selected->name }}
            </option>
        @endif
    </select>
</div>

<style>
    .select2.select2-container {
        width: 100% !important;
    }
</style>

@push('scripts')
    <script>
        window.batchesMap = [];
        @if ($selected !== null)
            window.batchesMap[{{ $selected->id }}] = @json($selected);
        @endif
        $('#batches-select').select2({
            placeholder: 'Select and begin typing',
            ajax: {
                url: '{{ route('batches.list') }}',
                delay: 250,
                cache: true,
                data: function(params) {
                    return {
                        search: params.term,
                    }
                },
                processResults: function(result) {
                    return {
                        results: result.batches.data.map(function(batch) {
                            window.batchesMap[batch.id] = batch
                            return {
                                id: batch.id,
                                slug: batch.slug,
                                text: batch.name,
                            }
                        })
                    }
                },
            }
        });
        $('#batches-select').on('select2:select', function(e) {
            var data = e.params.data;
            if (@json($has_route) && data) {
                let lorem = location;
                lorem.replace("?batch", 'sdf')
                console.log(lorem);
            }
        });
    </script>
@endpush
