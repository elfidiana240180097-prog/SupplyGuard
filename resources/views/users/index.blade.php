@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between mb-4">

    <h2>User Management</h2>

    <a href="{{ route('users.create') }}"
       class="btn btn-success">

        <i class="bi bi-plus-circle"></i>
        Add User

    </a>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="card shadow-sm">

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="180">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($users as $user)

                <tr>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>

                        @if($user->role == 'admin')

                            <span class="badge bg-danger">

                                Admin

                            </span>

                        @else

                            <span class="badge bg-primary">

                                User

                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('users.edit',$user->id) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form
                            action="{{ route('users.destroy',$user->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete user?')">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection