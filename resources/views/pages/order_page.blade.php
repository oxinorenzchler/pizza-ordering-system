@extends('layouts.pizza_template')
@section('title','Pizzaza Order Page')
@section('content')

@if (Session::has('success_msg'))
<div class="alert alert-success" role="alert">
	{{Session::get('success_msg')}}
</div>
@endif

<div class="col-md-8 offset-md-2">
	<h1>Choose order</h1>
	<form action="{{ route('store.order') }}" method="POST">
		@csrf
		<div class="form-group" id="pizza-type-container">
			<h3>Step 1: Select type.</h3>
			<select id="pizza-type" name="pizzatype" class="form-control" required>
				<option value="">....</option>
				@foreach ($types as $type)
				<option value="{{$type->id}}">{{title_case($type->name)}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group" id="pizza-container">
			<h3>Step 2: Select pizza.</h3>
			<select id="pizza-items" name="pizzaitems" class="form-control" required>
				<option value="">....</option>
			</select>
		</div>

		<div id="hidden-items" class="d-none">
			<div class="btn-group btn-group-toggle" data-toggle="buttons">
				<select id="size-type" name="sizetype" required>
					<option>Whole</option>
					<option>Half-Half</option>
					<option>4-quarters</option>
				</select>
			</div>

			<div data-toggle="buttons">
				<div class="btn-group btn-group-toggle d-block mt-3 mb-3 sub-selection" id="pizza-size-price-container">
					<h4>Available sizes:</h4>

				</div>
			</div>

			<div class="form-group">
				<h3>Step 3: Add toppings.  <small>(optional)</small></h3>
				<div class="form-row sub-selection" id="topping-items">

				</div>
				<hr class="px-4">
				<h4>Subtotal:</h4>
				<p>Pizza: <span id="pizza-total" class="sub-selection"></span><input type="hidden" name="pizzatotal" id="pizza-price" class="reset-input"></p>
				<input type="hidden" name="toppingscost" id="toppings-cost" class="reset-input">
				<p>Toppings: <span  id="toppings-total" class="sub-selection"></span></p>

				<h4>Total:</h4>
				<input type="hidden" name="totalprice" id="total-price" class="reset-input">
				<p id="total" class="sub-selection"></p>
			</div>

			<hr class="px-4">

			<h4>Customer Information:</h4>
			<div class="form-row mb-5">
				<div class="col-md-6">
					<input type="text" name="name" required class="form-control" placeholder="Full name">
				</div>
				<div class="col-md-6 mb-3">
					<input type="email" name="email" required class="form-control" placeholder="Email">
				</div>
				<div class="col-md-6">
					<input type="text" name="contact" required class="form-control" placeholder="Contact number">
				</div>
				<div class="col-md-6">
					<textarea name="address" class="form-control" placeholder="Delivery address"></textarea>
				</div>

			</div>

			<div class="form-group">
				<button class="btn btn-primary">Place Order</button>
			</div>

		</div>
	</form>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){


		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});  

		//format name to title case
		function toTitleCase(str) {
			return str.replace(
				/\w\S*/g,
				function(txt) {
					return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
				}
				);
		}
		//format price
		function formatPrice(price){
			var result = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(price);
			return result;
		}

		//fetch pizza
		$('#pizza-type').on('change',function(){
			$('.reset-input').val('');
			$('.sub-selection').empty();
			$('.first-item').remove()
			//get type id
			var id = $(this).val();

			//reset pizza items
			$('#pizza-items').find('option').remove();

			//fetch pizzas by type
			$.ajax({
				url:'get-pizza',
				method:'GET',
				data:{'id':id}
			}).done(function(data){

				var pizzas = Object.values(data);

				//assign pizzas to option
				for(var pizza of pizzas){

					var pizzaItems = '<option value="'+pizza.id+'">'+toTitleCase(pizza.name)+'</option>'

					$('#pizza-items').append(pizzaItems);
				}

				var select = '<option value="" selected>Select</option>';
				$('#pizza-items').prepend(select);
			});

		});


		//fetch pizza size price
		$('#pizza-items').on('change',function(){
			$('#hidden-items').removeClass('d-none');
			var id = $(this).val();
			$('.reset-input').val('');
			$('.sub-selection').empty();
			$('.first-item').remove()
			//fetch size
			$.ajax({
				url:'get-pizza-size',
				method:'GET',
				data:{'id':id},
			}).done(function(data){

				var sizePrice = Object.values(data);
				
				for (var i = 0; i < sizePrice.length; i++){

					var option = '<label class="btn btn-success price-option-'+i+'"><input type="radio" id="size-price-'+sizePrice[i]['id']+'" autocomplete="off" value="'+sizePrice[i]['id']+'"class="sr-only" required name="pizzainfo">'+ sizePrice[i].size['size'] +'" - <span id="price-'+i+'" class="price"></span></label> <input type="hidden" id="old-price-'+i+'" value="'+sizePrice[i]['price']+'" class="old-price"> ';

					$('#pizza-size-price-container').append(option);
					$('#size-type :nth-child('+ (i + 1) +')').attr('value',i);
					
				}

				$('#size-type').prepend('<option class="first-item" selected value="">Size</option>');			

				
			});

		});

		$('#size-type').on('change',function(){

			$('.reset-input').val('');
			$('#total').empty();
			$('#pizza-total').empty();

			var id = $(this).val();
			var oldPrice = $('.old-price');
			var newPrice = [];

			switch(id){
				case '0':

				for(var i = 0; i < oldPrice.length; i++){
					var result = oldPrice.eq(i).val() * 1;
					newPrice[i] = result;

					var formatPrice = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(newPrice[i]);

					$('#price-'+i+'').text(formatPrice);
					$('.price-option-'+i+'').attr('onclick', 'setPrice('+newPrice[i]+')');

				}

				$('#toppings-cost').val('');


				break;
				case '1':


				for(var i = 0; i < oldPrice.length; i++){
					var result = oldPrice.eq(i).val() / 2;
					newPrice[i] = result;

					var formatPrice = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(newPrice[i]);

					$('#price-'+i+'').text(formatPrice);
					
					$('.price-option-'+i+'').attr('onclick', 'setPrice('+newPrice[i]+')');

				}

				
				$('#toppings-cost').val('');

				
				break;
				case '2':


				for(var i = 0; i < oldPrice.length; i++){
					var result = oldPrice.eq(i).val() / 4;
					newPrice[i] = result;

					var formatPrice = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(newPrice[i]);

					$('#price-'+i+'').text(formatPrice);
					$('.price-option-'+i+'').attr('onclick', 'setPrice('+newPrice[i]+')');
					

				}
				
				$('#toppings-cost').val('');

				break;

				default:
				$('.price').empty();
				$('#topping-items').empty();
				$('.reset-input').val('');
				$('.sub-selection').empty();
			}


			//fetch toppings price
			var sizeType = $('#size-type option[value="'+id+'"]').text();
			// console.log(sizeType);
			var sizeId = parseInt(id) + 1;
			if(sizeType == 'Whole'){
				getToppings(sizeId);
			}else if(sizeType == 'Half-Half'){
				getToppings(sizeId);
			}else if(sizeType == '4-quarters'){
				getToppings(sizeId);
			}


		});


	//fetch toppings
	function getToppings(id){

		$('#topping-items').empty();

		$.ajax({
			url:'get-topping-price',
			method:'GET',
			data:{'id':id},
		}).done(function(data){
			
			var sizePrice = Object.values(data);

			for(var i = 0; i < sizePrice.length; i++){
				var topping = '<div class="col-md-4"><label><input type="checkbox" name="toppings[]" class="toppings-'+sizePrice[i]['id']+' topping-class" onchange="getSubtotal('+sizePrice[i]['id']+')" value="'+sizePrice[i]['id']+'">'+toTitleCase(sizePrice[i].topping['name'])+'</label><input id="topping-price" class="topping-price-'+sizePrice[i]['id']+'" type="hidden" value="'+sizePrice[i]['price']+'"><small>('+formatPrice(sizePrice[i]['price'])+')</small></div>';

				$('#topping-items').append(topping);			
				
			}



		});
	}


	});//end doc ready

function setPrice(price){
	console.log(price);

	var formatprice = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(price);
	// isaylo ja sa set price.
	$('#pizza-total').text(formatprice);
	$('#pizza-price').val(price);
	$('#total').text(formatprice);
	$('#total-price').val(price);
}

function getToppingsSum(total, num){
	return total + num;
	// return total;
}

function getSubtotal(id){

	var checked = $('.toppings-'+id+'').is(':checked');
	var price = parseInt($('.topping-price-'+id+'').val());
	var list = $('.topping-class:checkbox:checked');

	var total;

	var choices = [];

	if(checked){

		for(var i = 0; i < list.length; i++){
			choices.push(price);
		}

		var toppingssum = choices.reduce(getToppingsSum); 

		$('#toppings-cost').val(toppingssum);
		var cost = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(toppingssum);

		$('#toppings-total').text(cost);

		total =parseInt( $('#pizza-price').val()) + parseInt($('#toppings-cost').val());
		

		var formatTotal = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }
			).format(total)

		$('#total-price').val(total);

		$('#total').text(formatTotal);

	}else{

		var newcost = $('#toppings-cost').val() - price;

		$('#toppings-cost').val(newcost);
		var formatnewcost = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(newcost);


		var newtotal = parseInt($('#total-price').val()) - price;

		$('#toppings-total').text(formatnewcost);

		var formatTotal = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(newtotal)

		$('#total-price').val(newtotal);
		$('#total').text(formatTotal);
	}
}

</script>


@endsection

