@extends('layout')
@section('content')
    <nav class="navbar navbar-dark bg-dark mb-3">
        <div class="container-fluid">
            <div class="navbar-brand">
                <img src="{{ asset('img/laravel-logo.svg') }}" alt="" width="30" height="30">
                <p class="navbar-text text-white m-0">Welcome, {{ Auth::user()->name }}
                </p>
            </div>

            <ul class="navbar-nav me-auto mb-2">
            </ul>
            <a href="{{ route('logout') }}" class="btn btn-outline-danger">Log out</a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h4>Please enter the stock symbol you want to check</h4>
            </div>
        </div>
        <div class="row justify-content-center mb-2">
            <div class="form-inline">
                <div class="form-group">
                    <label for="input-stock-symbol" class="sr-only">Stock symbol</label>
                    <input id="input-stock-symbol" style="text-transform: uppercase" class="form-control mr-1" type="text" placeholder="AMZN, GOOG, AAPL...">
                </div>
                <button class="btn btn-primary" onclick="getStockQuote()">Get price</button>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <p class="error" id="error"></p>
            </div>
        </div>
        <table class="table" id="stock-table" style="display: none;">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Symbol</th>
                <th scope="col">High</th>
                <th scope="col">Low</th>
                <th scope="col">Price</th>
                <th scope="col">Checked at</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        function getStockQuote() {
            let symbol = $("#input-stock-symbol").val();
            if (symbol === "" || symbol === null) {
                $("#error").show();
                $("#error").text("Symbol field can't be null");

                return;
            }
            $.ajax({url: "{{ route('get_stock_quotes') }}",
                data: {
                    'symbol': symbol
                },
                success: function(result){
                    if (result.length === 0) {
                        $("#error").show();
                        $("#error").text("There were no results for your search");

                        return;
                    }
                    $("#error").hide();
                    let stockTable = $("#stock-table");
                    stockTable.prepend(
                        '<tr>' +
                        '<th>' + result.symbol + '</th>' +
                        '<td>' + result.high + '</td>' +
                        '<td>' + result.low + '</td>' +
                        '<td>' + result.price + '</td>' +
                        '<td>' + result.created_at + '</td>' +
                        '</tr>')
                    ;
                    if (stockTable.is(":hidden")) {
                        stockTable.show("slow");
                    }
                    // Max number of rows = 10
                    if ($("#stock-table tbody tr").length > 10) {
                        $("#stock-table tbody tr:last").remove();
                    }
                },
                error: function(response) {
                    const error = eval("(" + response.responseText + ")");
                    $("#error").show();
                    $("#error").text(error.message);
                }
            });
        };
    </script>
@endsection
