@php
  // -----------------------
  // Starmoozie ChartJS Widget
  // -----------------------
  // Uses:
  // - Starmoozie\CRUD\app\Http\Controllers\ChartController
  // - https://github.com/ConsoleTVs/Charts
  // - https://github.com/chartjs/Chart.js

  $controller = new $widget['controller'];
  $chart = $controller->chart;
  $path = $controller->getLibraryFilePath();

  // defaults
  $widget['wrapper']['class'] = $widget['wrapper']['class'] ?? $widget['wrapperClass'] ?? 'col-sm-6 col-md-4';
@endphp

@includeWhen(!empty($widget['wrapper']), 'starmoozie::widgets.inc.wrapper_start')
  <div class="{{ $widget['class'] ?? 'card' }}">
    @if (isset($widget['content']['header']))
    <div class="card-header">{!! $widget['content']['header'] !!}</div>
    @endif
    <div class="card-body">

      {!! $widget['content']['body'] ?? '' !!}

      <div class="card-wrapper">
        {!! $chart->container() !!}
      </div>

    </div>
  </div>
@includeWhen(!empty($widget['wrapper']), 'starmoozie::widgets.inc.wrapper_end')

@push('after_scripts')
<!-- JavaScript Bundle with Popper -->
  @if (is_array($path))
    @foreach ($path as $string)
     @loadScriptOnce($string)
    @endforeach
  @elseif (is_string($path))
    @loadScriptOnce($path)
  @endif

  {!! $chart->script() !!}

@endpush
