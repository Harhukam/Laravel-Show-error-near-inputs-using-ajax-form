@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                <a href="{{ route('contact.create') }}"  class="btn btn-info"> Add New Contact</a>
<hr>
                    <ul class="list-group">
                        @foreach($contacts as $contact)
                            <li class="list-group-item"> {{ $contact->name . ': '. $contact->number }} </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>







@endsection
