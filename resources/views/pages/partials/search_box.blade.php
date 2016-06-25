{!! Form::open(array('route' => 'queries.search')) !!}
{{csrf_field()}}
<div class="typeahead__container">
	<div class="typeahead__field">		
		<span class="typeahead__query">
			<input class="js-typeahead-country_v1" name="search" placeholder="Search" autocomplete="off" type="search">
		</span>
		<span class="typeahead__button">
			<button type="submit">
			<i class="typeahead__search-icon"></i>
			</button>
		</span>
	</div>
</div>
{!! Form::close() !!}