<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Hello, world!</title>
        <meta name="_token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md">
                        <form id="form">
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <div class="table-responsive">
                        <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Date Submitted</th>
                                        <th scope="col">Total Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($products)
                                        @php $allTotal = 0 @endphp
                                        @foreach ($products as $product)
                                            @php $allTotal += $product->total @endphp
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->qty }}</td> 
                                                <td>{{ $product->price }}</td> 
                                                <td>{{ $product->date }}</td>
                                                <td>${{ $product->total }}</td>    
                                            <tr>
                                        @endforeach
                                            <tr><td></td><td></td><td></td><td></td><td>${{ $allTotal }}</td></tr>
                                    @endif
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $( "#form" ).submit(function( event ) {
                event.preventDefault();
                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
                });
                var data = $( this ).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{ route('process') }}",
                    data: data,
                    success: function(data){
                        $('#table > tbody:last').children().remove();
                        var allTotal = 0;
                        $.each(data,function( index, value ) {
                            allTotal += value.total;
                            var row = '<tr><td>'+value.name+'</td><td>'+value.qty+'</td><td>'+value.price+'</td><td>'+value.date+'</td><td>$'+value.total+'</td></tr>';
                            $('#table').find('tbody:last').append(row);
                        })
                        var row = '<tr><td></td><td></td><td></td><td></td><td>$'+allTotal+'</td></tr>';
                        $('#table').find('tbody:last').append(row);
                    },
                    error: function(){
                        alert("An error occured");
                    }
                });
            });
        </script>
    </body>
</html>