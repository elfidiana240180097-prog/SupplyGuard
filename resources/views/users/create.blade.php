@extends('layouts.master')

@section('content')

<h2 class="mb-4">
    Add New User
</h2>

<div class="card shadow-sm">

    <div class="card-body">

        <form action="{{ route('users.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Role</label>

                <select
                    name="role"
                    class="form-select">

                    <option value="user">
                        User
                    </option>

                    <option value="admin">
                        Admin
                    </option>

                </select>

            </div>

            <button class="btn btn-success">

                Save User

            </button>

        </form>

    </div>

</div>

@endsection