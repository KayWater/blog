@extends('layouts.admin')

@push('scripts')
  <script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
  <script src='{{ asset("js/statistics.js") }}'></script>
@endpush

@section('aside')
	@include('layouts.aside')
@endsection

@section('content')
<section class="content container-fluid mt-4">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<div id="container" ></div>
			</div>
		</div>
	</div>
</section>
@endsection