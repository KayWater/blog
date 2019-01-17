@extends('layouts.admin')

@push('scripts')
  <script src="https://cdn.bootcss.com/highcharts/7.0.1/highcharts.js"></script>
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