<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')

    <title>Asset Management</title>
    <style>
        #dropdown-content { position: absolute;
            background-color: #f6f6f6; width: 230px;
            overflow: auto; z-index: 100;
        }

        #dropdown-content div {
            color: black;
            padding: 12px 16px;
            cursor: pointer;
        }

        .dropdown div:hover {
            background-color: #ddd;
        }
    </style>

    <script src ="{{ asset('bootstrap-5.0.2/js/typahead.js') }}" rel="stylesheet"></script>
    <script>
        // Um die Models abhängig vom typ zu ändern
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#ddType").addEventListener("change", function() {
                // Sende AJAX-Anfrage an Laravel-Anwendung
                fetch("/models?type=" + this.value)
                    .then(response => response.json())
                    .then(models => {
                        // Verarbeite empfangene Modelle und füge sie in das zweite Dropdown-Menü ein
                        let ddModel = document.querySelector("#ddModel");
                        ddModel.innerHTML = "";
                        for (let model of models) {
                            ddModel.innerHTML += `<option value="${model.id}">${model.model}</option>`;
                        }
                    });
            });
        });

    </script>
</head>
<body class="d-flex flex-column min-vh-100" id="add_body">
@include('layouts.Nav')
<div class="container border border-5 mx-auto" id="add-form">
<div class="container">
<h4 style="text-align: center">Create Device</h4>
</div>
<div class="container" id="add_form">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action=" {{ route('devices.store') }}" autocomplete="off">
        <div class="container" id="radios">
        @csrf
        <input type="radio" checked onclick="checkorder()" name="checkOrder" value="new" {{ old('checkOrder')=="new" ? 'checked='.'"'.'checked'.'"' : '' }} id="newOrder"> New Order
        <input type="radio" onclick="checkorder()" name="checkOrder" value="extend" id="oldOrder" {{ old('checkOrder')=="extend" ? 'checked='.'"'.'checked'.'"' : '' }} > Extend existing order
        </div>

        <div class="container">
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Amount</label>
            <div class="col-sm-8">
                <input type="number" id="device-count" name="deviceCount" value="{{ old('deviceCount') ?? 1 }}" min="1" class="form-control form-control-sm" placeholder="Amount">
            </div>
        </div>
        </div>

        <div class="container">
            <div class="row mb-3">
                <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">OrderID</label>
                <div class="col-sm-8">
                    <input type="hidden" id="oId" name="oId">
                    <input type="text" id="orderid" name="orderid" value="{{old('orderid')}}" class="form-control form-control-sm" placeholder="OrderID">
                    <div id="dropdown-content"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mb-3">
                <label for="colFormLabelSm"  class="col-sm-4 col-form-label col-form-label-sm">Order Date</label>
                <div class="col-sm-8">
                    <input type="date" id="orderdate" name="orderdate" value="{{old('orderdate')}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mb-3">
                <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Warranty until</label>
                <div class="col-sm-8">
                    <input type="date" id="warranty" name="warranty" value="{{old('warranty')}}" class="form-control form-control-sm">
                </div>
            </div>
        </div>

        <div class="container">
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Status</label>
            <div class="col-sm-8">
                <select class="form-select" name="ddStatus" id="ddStatus" arial-label="Default select example">
                    <option hidden value="default">Select a Status..</option>
                    @foreach($status as $state)
                        @if (old('ddStatus') == $state->id)
                            <option value="{{ $state->id }}" selected>{{ $state->status_name }}</option>
                        @else
                            <option value="{{ $state->id }}">{{ $state->status_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        </div>

        <div class="container">
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Type</label>
            <div class="col-sm-8">
                <select class="form-select" name="ddType" id="ddType" arial-label="Default select example">
                    <option hidden value="default">Select a Type..</option>
                    @foreach($type as $typ)
                    @if (old('ddType') == $typ->id)
                        <option value="{{ $typ->id}}" selected>{{ $typ->type_name }} {{ $typ->isStationary ? '[Stationary]': '' }}</option>
                    @else
                        <option value="{{ $typ->id }}">{{ $typ->type_name }} {{ $typ->isStationary ? '[Stationary]': '' }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        </div>

        <div class="container">
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Model</label>
            <div class="col-sm-8">
                <select class="form-select" name="ddModel" id="ddModel" arial-label="Default select example">
                    <option hidden value="default">Select a Model..</option>
                    @foreach($models as $model)
                        @if (old('ddModel') == $model->id)
                            <option value="{{ $model->id }}" selected>{{ $model->model }}</option>
                        @else
                            <option value="{{ $model->id }}">{{ $model->model }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        </div>

        <div class="container">
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Location</label>
            <div class="col-sm-8">
                <select class="form-select" name="ddLocation" id="ddLocation" arial-label="Default select example">
                    @foreach($locations as $loc)
                        @if ($loc->location_initials == 'IT')
                            <option value="{{ $loc->id }}" selected>{{ $loc->location_initials }}</option>
                        @else
                            <option value="{{ $loc->id }}">{{ $loc->location_initials }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        </div>

        <div class="container" id="buttons">
            <button class="btn btn-danger" type="submit">Add Device</button>
            <button class="btn btn-danger" type="reset" onclick="window.location.reload()">Reset Input</button>
            <a href="{{ Route('devices.index') }}"> <button class="btn btn-danger" type="button">Cancel</button></a>
        </div>
    </form>

</div>


</div>
@include('layouts.Footer')
</body>
<script>

    const orderDateInput = document.querySelector("#orderdate");
    const warrantyDateInput = document.querySelector("#warranty");

    // Set order date to today
    const today = new Date();
    orderDateInput.valueAsDate = today;

    // Set warranty date to 2 years from order date
    const updateWarrantyDate = () => {
        const orderDate = orderDateInput.valueAsDate;
        if (orderDate) {
            const warrantyDate = new Date(orderDate);
            warrantyDate.setFullYear(warrantyDate.getFullYear() + 2);
            warrantyDateInput.valueAsDate = warrantyDate;
        }
    };
    updateWarrantyDate();
    orderDateInput.addEventListener("change", updateWarrantyDate);


    const orderDateElement = document.getElementById('orderdate');

    function checkorder() {
        const newOrderRadio = document.getElementById('newOrder');
        const orderdate = document.getElementById("orderdate");
        const orderIdInput = document.getElementById("orderid");

        if (newOrderRadio.checked) {
            orderdate.readOnly = false;
            orderIdInput.removeEventListener("keyup", searchOrder);

        } else {
            orderdate.readOnly = true;
            orderIdInput.addEventListener("keyup", searchOrder);
            document.getElementById("dropdown-content").innerHTML = "";
        }
    }
    window.onload = function() { checkorder() };



    async function searchOrder(e) {

        const src = e.target; // Searchbar (#myInput)
        const idElement = document.getElementById("oId"); // (Hidden) field to save the id for the next request.
        const dateElement = document.getElementById("orderdate"); //
        const searchInput = (src.value || "").toLowerCase();
        const listContent = document.getElementById("dropdown-content"); // Empty div, filled by the response.

        let orders = []; // Server response (JSON Array)
        let fetched = false;


        if (searchInput.length < 1) {
            fetched = false;
            listContent.innerHTML = "";
        }
        //A search is made for 3 or more characters.
        // No or invalid data from server: we have to fetch data from the server.
        if (searchInput.length >= 1 && !fetched) { // Important: Set the state first. If not, you will generate many search queries when a user types and the data is not yet loaded.
            fetched = true;

            try { // Customize the url.
                const response = await fetch(`/devices/OrdersForAdd?orderid=${searchInput}`);

                orders = await response.json();
            } catch (e) {
                alert("Error fetching orders from server");
            }
        }
        // We have data: filter locally
        if (searchInput.length >= 1 && fetched) {
            listContent.innerHTML = "";
            const filteredOrders = orders.filter(n => {
                return n.order_id.toLowerCase().includes(searchInput);
            });
            for (const order of filteredOrders) {
                const item = document.createElement("div");
                item.innerText = `${order.order_id}`;
                // Add an event handler for the generated list item to set the form fields on click.
                item.addEventListener("click", (e) => {
                    document.getElementById('orderid').value = order.order_id;
                    idElement.value = order.id;
                    listContent.innerHTML = "";
                    dateElement.valueAsDate = new Date(order.order_date);
                    updateWarrantyDate();
                });
                listContent.append(item);
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const newOrderRadio = document.getElementById('newOrder');
        const orderIdInput = document.getElementById("orderid");

        newOrderRadio.addEventListener("change", function() {
            checkorder();
        });

        // Weitere Initialisierungslogik hier...

        checkorder(); // Initialer Aufruf der Funktion zum Überprüfen des Anfangszustands
    });



</script>
</html>
