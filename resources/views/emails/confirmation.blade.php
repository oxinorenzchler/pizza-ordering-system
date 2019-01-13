<h1>Order Confirmation</h1>
<ul>
	<li>Customer: {{ $name }}</li>
	<li>Email: {{ $email }}</li>
	<li>Contact: {{ $contact }}</li>
	<li>Address: {{ $address }}</li>
	<li>Contact: {{ $contact }}</li>
	<li>Pizza: {{ $pizza }}</li>
	<li>Size: {{ $size }}</li>
	<li>Pizza price: &#8369; {{number_format($price, 2)}}</li>
	<li>Toppings price: &#8369; {{number_format($toppingsPrice, 2)}}</li>
	<li>Total: &#8369; {{number_format($total, 2)}}</li>
</ul>

<div style="line-height: 10px;">
	<p>Kindly wait for one of our support will contact you. Thank you for choosing Pizzaza</p>
</div>
