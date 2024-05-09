<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Appointment form</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/checkout/form-validation.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Appointment form</h2>
        </div>
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <form class="needs-validation" name="appointment.store" method="POST" action="{{ route('appointment.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="body">Body</label>
                            <input type="text" class="form-control" id="body" name="body" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_at">Date</label>
                            <input type="date" class="form-control" id="date_at" name="date_at" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_at">Time</label>
                            <input type="time" class="form-control" id="time_at" name="time_at" required>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                </form>
            </div>
        </div>


        <table class="table table-striped mt-5">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                <tr class="text-center">
                    <td>{{ $appointment->app_id }}</td>
                    <td>{{ $appointment->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
</body>

</html>