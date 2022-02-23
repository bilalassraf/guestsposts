@extends('layouts.default')
@section('title')
Show Website
@endsection
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content-wrapper p-5">
    <div class="row">
        <a class="text-dark mb-3" href="{{ route('admin.show.guest.request')}}"><i class="fas fa-arrow-circle-left"> BACK</i></a>
        <div class="col-12">
            <table class="col-10 table table-hover text-nowrap" id="example">
                <thead>
                    <tr>
                        <th>Web Name</th>
                        <th>Email (Webmaster)</th>
                        <th>Coordinator</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                <tr>
                    <td rowspan="2">{{ $product->web_name }}</td>
                    <td rowspan="2">{{ $product->email_webmaster }}</td>
                    <td rowspan="2">{{ $product->Coordinator }}</td>
                    <td rowspan="2">{{ $product->status }}</td>
                </tr>
                </tbody>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>                        

<style type="text/css">
    label {
        margin: 10px;
    }

    a.paginate_button.current {
        background: #242939 !important;
        color: white !important;
    }

    div#example_info {
        padding-left: 10px;
    }

    .card.sroling {
        width: 239%;
    }

</style>

@endsection

