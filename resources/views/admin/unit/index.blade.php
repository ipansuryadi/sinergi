@extends('admin.dash')
@section('content')
<div class="container-fluid" id="admin-brand-container">
	<a href="#menu-toggle" class="btn btn-default visible-xs" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
	<div class="col-md-8" id="admin-brand-container">
	<a href="{{ route('admin.unit.create') }}" class="btn btn-primary">Add new unit</a>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center blue white-text col-md-1">Delete</th>
					<th class="text-center blue white-text col-md-1">Edit</th>
					<th class="text-center blue white-text">Name</th>
				</tr>
			</thead>
			<tbody>
				@foreach($units as $unit)
				<tr>
					<td class="text-center">
						<form method="post" action="{{ route('admin.unit.destroy', $unit->id) }}" class="delete_form_unit">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="DELETE">
							<button id="delete-unit-btn" style="border: none;">
							<i class="fa fa-trash red-text" aria-hidden="true"></i>
							</button>
						</form>
					</td><td class="text-center">
						<a href="{{ route('admin.unit.edit', $unit->id) }}">
							<i class="fa fa-pencil green-text" aria-hidden="true"></i>
						</a>
					</td>
					<td>{{ $unit->name }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	</div>  <!-- close container -->
@endsection