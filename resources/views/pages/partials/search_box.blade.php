{!! Form::open(array('route' => 'queries.search')) !!}
{{csrf_field()}}
<!-- <div class="typeahead__container">
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
</div> -->
<div class="input-group">
	<div class="input-group-btn search-panel">
		<button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" style="height: 28px;">
		<span id="search_concept">Category</span> <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			@foreach ($category_search as $element)
				<li><a href="#{{$element->id}}">{{$element->category}}</a></li>
			@endforeach
			<li class="divider"></li>
			<li><a href="#all">All</a></li>
		</ul>
	</div>
	<input type="hidden" name="cat_id" value="all" id="search_param">
	<input type="text" class="form-control" name="search" placeholder="Search term..." style="height: 28px;margin-top: 10px; font-size: small;">
	<span class="input-group-btn">
		<button class="btn btn-secondary btn-sm" type="submit" style="height: 28px;"><span class="fa fa-search"></span></button>
	</span>
</div>
{!! Form::close() !!}

@section('footer')
	<script type="text/javascript">
		$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).attr("href").replace("#","");
		var concept = $(this).text();
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #search_param').val(param);
	});
});
	</script>
@stop