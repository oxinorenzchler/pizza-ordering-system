@extends('layouts.pizza_template')
@section('title', 'Admin Panel')
@section('content')
@include('partials.nav')

<h1>Orders Table</h1>
<table id="order-table">
	<thead>
		<tr>
			<td>Name</td>
			<td>Email</td>
			<td>Contact</td>
			<td>Address</td>
			<td>Pizza</td>
			<td>Size</td>
			<td>Size Type</td>
			<td>Combinations</td>
			<td>Pizza Price</td>
			<td>Toppings Price</td>
			<td>Total</td>
		</tr>
	</thead>
	<tbody>
		@foreach ($orders as $order)
		<tr>
			<td>{{$order->name}}</td>
			<td>{{$order->email}}</td>
			<td>{{$order->contact}}</td>
			<td>{{$order->address}}</td>
			<td>{{$order->orderPizza->pizza->name}}</td>
			<td>{{$order->orderPizza->size->size}} "</td>
			<td>{{title_case($order->orderPizza->sizeType->size)}}</td>
			<td>
				@if ($order->orderPizza->combinations != null)
				<button onclick="getCombinations({{$order->orderPizza->id}})" class="btn btn-sm btn-primary">View</button>
				@endif
			</td>
			<td class="small">&#8369; {{number_format($order->orderPizza->pizza_price, 2)}}</td>
			<td class="small">&#8369; {{number_format($order->orderPizza->toppings_price, 2)}}</td>
			<td class="small">&#8369;
				{{number_format($order->total, 2)}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<div id="combinations-modal" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Combination</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table">
						<thead>
							<tr>
								<th>Topping</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody id="pizza-combinations">
							
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			//initialize datatables
			$('#order-table').DataTable();
		} );

		//fetch combinations
		function getCombinations(id){
			$('#combinations-modal').modal('show');
			$.ajax({
				url:'/get-combinations',
				method:'GET',
				data:{'id':id},
			}).done(function(data){

				//fetch response and display
				var topping = Object.values(data);

				for (var i = 0; i < topping.length - 1; i++) {
 
					var item =	'<tr><td>'+ topping[i]['name'] +'</td><td>&#8369;'+ topping[i]['size_price'][i]['price'] +'</td></tr>'
					$('#pizza-combinations').append(item);

				}
			});
		}
	</script>
	@endsection