@if ($crud->hasAccess('create'))
	<a href="{{ url($crud->route.'/create') }}" class="btn btn-sm btn-primary shadow" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> {{ trans('starmoozie::crud.add') }}</span></a>
@endif