@extends('admin.dash')
@section('content')
<div class="container" id="admin-brand-container">
	<a href="#menu-toggle" class="btn btn-default visible-xs" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
	<a href="#" onclick="window.history.back();return false;" class="btn btn-danger">Back</a>
	<h4 class="text-center">Edit unit</h4><br><br>
	<div class="col-md-12" id="admin-brand-container">
		 {!! Form::model($unit, ['method' => 'PUT', 'action' => ['UnitController@update', $unit->id]]) !!}
			{{ csrf_field() }}
			<div class="col-sm-8 col-md-8 col-md-offset-2">
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label>Unit Name</label>
					<input type="text" class="form-control" name="name" value="{{ old('name') ? : $unit->name }}" placeholder="Unit Name">
					@if($errors->has('name'))
					<span class="help-block">{{ $errors->first('name') }}</span>
					@endif
				</div>
			</div>
			<div class="form-group col-sm-8 col-md-8 col-md-offset-2 text-right">
				<button type="submit" class="btn btn-primary waves-effect waves-light">Create Brand</button>
			</div>
		</form>
	</div>
</div>
@endsection