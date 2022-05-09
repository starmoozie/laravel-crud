<!-- bootstrap daterange picker input -->

<?php
    // if the column has been cast to Carbon or Date (using attribute casting)
    // get the value as a date string
    if (! function_exists('formatDate')) {
        function formatDate($entry, $dateFieldName)
        {
            $formattedDate = null;
            if (isset($entry) && ! empty($entry->{$dateFieldName})) {
                $dateField = $entry->{$dateFieldName};
                if ($dateField instanceof \Carbon\CarbonInterface) {
                    $formattedDate = $dateField->format('Y-m-d H:i:s');
                } else {
                    $formattedDate = date('Y-m-d H:i:s', strtotime($entry->{$dateFieldName}));
                }
            }

            return $formattedDate;
        }
    }

    if (isset($field['value'])) {
        if (isset($entry) && ! is_array($field['value'])) {
            $start_value = formatDate($entry, $field['name'][0]);
            $end_value = formatDate($entry, $field['name'][1]);
        } elseif (is_array($field['value'])) { // gets here when inside repeatable
            $start_value = current($field['value']); // first array item
            $end_value = next($field['value']); // second array item
        }
    }

    $start_default = $field['default'][0] ?? date('Y-m-d H:i:s');
    $end_default = $field['default'][1] ?? date('Y-m-d H:i:s');

    // make sure the datepicker configuration has at least these defaults
    $field['date_range_options'] = array_replace_recursive([
        'autoApply' => true,
        'startDate' => $start_default,
        'endDate' => $end_default,
        'locale' => [
            'firstDay' => 0,
            'format' => config('starmoozie.base.default_date_format'),
            'applyLabel'=> trans('starmoozie::crud.apply'),
            'cancelLabel'=> trans('starmoozie::crud.cancel'),
        ],
    ], $field['date_range_options'] ?? []);
?>

@include('crud::fields.inc.wrapper_start') 
    <input class="datepicker-range-start" type="hidden" name="{{ $field['name'][0] }}" value="{{ old_empty_or_null($field['name'][0], null) ??  $start_value ?? $start_default ?? null }}">
    <input class="datepicker-range-end" type="hidden" name="{{ $field['name'][1] }}" value="{{ old_empty_or_null($field['name'][1], null) ??  $end_value ?? $end_default ?? null }}">
    <label>{!! $field['label'] !!}</label>
    <div class="input-group date">
        <input
            data-bs-daterangepicker="{{ json_encode($field['date_range_options'] ?? []) }}"
            data-init-function="bpFieldInitDateRangeElement"
            type="text"
            @include('crud::fields.inc.attributes')
            >
        	<div class="input-group-append">
	            <span class="input-group-text">
                <span class="la la-calendar"></span>
            </span>
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}

{{-- FIELD CSS - will be loaded in the after_styles section --}}
@push('crud_fields_styles')
    @loadOnce('packages/bootstrap-daterangepicker/daterangepicker.css')
@endpush

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    @loadOnce('packages/moment/min/moment-with-locales.min.js')
    @loadOnce('packages/bootstrap-daterangepicker/daterangepicker.js')
    @loadOnce('bpFieldInitDateRangeElement')
    <script>
        function bpFieldInitDateRangeElement(element) {

                moment.locale('{{app()->getLocale()}}');

                var $visibleInput = element;
                var $startInput = $visibleInput.closest('.input-group').parent().find('.datepicker-range-start');
                var $endInput = $visibleInput.closest('.input-group').parent().find('.datepicker-range-end');

                var $configuration = $visibleInput.data('bs-daterangepicker');
                // set the startDate and endDate to the defaults
                $configuration.startDate = moment($configuration.startDate);
                $configuration.endDate = moment($configuration.endDate);

                // if the hidden inputs have values
                // then startDate and endDate should be the values there
                if ($startInput.val() != '') {
                    $configuration.startDate = moment($startInput.val());
                }
                if ($endInput.val() != '') {
                    $configuration.endDate = moment($endInput.val());
                }

                $visibleInput.daterangepicker($configuration);

                var $picker = $visibleInput.data('daterangepicker');

                $visibleInput.on('keydown', function(e){
                    e.preventDefault();
                    return false;
                });

                $visibleInput.on('apply.daterangepicker hide.daterangepicker', function(e, picker){
                    $startInput.val( picker.startDate.format('YYYY-MM-DD HH:mm:ss') );
                    $endInput.val( picker.endDate.format('YYYY-MM-DD HH:mm:ss') );
                });
        }
    </script>
    @endLoadOnce
@endpush
{{-- End of Extra CSS and JS --}}
