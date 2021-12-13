@if ($crud->get('reorder.enabled') && $crud->hasAccess('reorder'))
  <a href="{{ url($crud->route.'/reorder') }}" class="btn btn-outline-primary btn-sm shadow-sm" data-style="zoom-in"><span class="ladda-label"><i class="la la-arrows"></i> {{ trans('starmoozie::crud.reorder') }}</span></a>
@endif