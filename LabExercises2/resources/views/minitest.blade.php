@extends('layouts.app')

@section('title', 'MiniTest - Supermarket Bill')

@section('content')
<div class="container mt-4">
    <h2>Supermarket Bill</h2>

    <form id="billForm">
        <div class="mb-3">
            <input type="text" id="item" class="form-control" placeholder="Item Name" required>
        </div>
        <div class="mb-3">
            <input type="number" id="quantity" class="form-control" placeholder="Quantity" required>
        </div>
        <div class="mb-3">
            <input type="number" id="price" class="form-control" placeholder="Price" required>
        </div>
        <button type="button" onclick="addBillItem()" class="btn btn-success">Add Item</button>
    </form>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="billTable"></tbody>
    </table>
</div>

<script>
function addBillItem() {
    let item = document.getElementById("item").value;
    let quantity = document.getElementById("quantity").value;
    let price = document.getElementById("price").value;
    let total = quantity * price;

    let row = `<tr>
                <td>${item}</td>
                <td>${quantity}</td>
                <td>${price}</td>
                <td>${total}</td>
            </tr>`;

    document.getElementById("billTable").innerHTML += row;
    document.getElementById("billForm").reset();
}
</script>
@endsection















































