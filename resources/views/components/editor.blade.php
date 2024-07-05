@props([
    'id' => null,
    'value' => '',
    'required' => false,
    'disabled' => false,
    'label' => 'Description',
    'fieldName' => 'description',
    'placeholder' => 'A brief description',
    'is_wire' => false,
    'hasLabel' => true,
])
<div wire:ignore class="form-control-wrap" id="custom_editor_{{ $id }}">
    @if ($hasLabel)
        <label for="description" class="mb-1 control-label">{{ $label }}</label>
    @endif
    <textarea wire:ignore placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        @if ($is_wire) wire:model.lazy="{{ $fieldName }}" @else name="{{ $fieldName }}" @endif
        wire:model.lazy="content" id="{{ $id }}" class="iro-editor">{{ $value }}</textarea>
    <span class="help-block field-validation-valid" data-valmsg-for="description" data-valmsg-replace="true"></span>
</div>

<style>
    .cke {
        border-color: #f1f2f7 !important;
    }

    .cke_bottom {
        border: none !important;
    }
</style>

<script>
    CKEDITOR.replace(document.getElementById(@json($id)), {
        uiColor: '#ffffff',
        toolbar: [
            @json($hasLabel) ? [{
                    name: 'document',
                    groups: ['mode', 'document', 'doctools'],
                    items: ['Source']
                },
                {
                    name: 'clipboard',
                    groups: ['clipboard', 'undo'],
                    items: ['Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo']
                }
            ] : '',
            {
                name: 'basicstyles',
                groups: ['basicstyles', 'cleanup'],
                items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-',
                    'RemoveFormat'
                ]
            },

            {
                name: 'paragraph',
                groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
                    'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',
                    '-', 'BidiLtr', 'BidiRtl', 'Language'
                ]
            },
            {
                name: 'links',
                items: ['Link', 'Anchor']
            },
            @json($hasLabel) ? [{
                name: 'insert',
                items: ['Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak',
                    'Iframe'
                ]
            }] : '',
            {
                name: 'styles',
                items: ['Styles', 'Format', 'Font', 'FontSize']
            },
            {
                name: 'colors',
                items: ['TextColor', 'BGColor']
            },
            {
                name: 'tools',
                items: ['Maximize', 'ShowBlocks']
            },
        ],
    });

    // Set link target to '_blank' by default
    CKEDITOR.on('dialogDefinition', function(ev) {
        var dialogName = ev.data.name;
        var dialogDefinition = ev.data.definition;

        if (dialogName == 'link') {
            var infoTab = dialogDefinition.getContents('target');
            var targetField = infoTab.get('linkTargetType');
            targetField['default'] = '_blank';
        }
    });
</script>
