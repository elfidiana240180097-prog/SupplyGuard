@extends('layouts.master')

@section('content')

<h2 class="mb-4">
    Edit User
</h2>

<div class="card shadow-sm">

    <div class="card-body">

        <form
            action="{{ route('users.update', $user->id) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ $user->name }}"
                    required>

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ $user->email }}"
                    required>

            </div>

            <div class="mb-3">

                <label>Role</label>

                <select
                    name="role"
                    class="form-select">

                    <option
                        value="admin"
                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option
                        value="user"
                        {{ $user->role == 'user' ? 'selected' : '' }}>
                        User
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Update User

            </button>

            <a
                href="{{ route('users.index') }}"
                class="btn btn-secondary">

                Back

            </a>

        </form>

    </div>

</div>

@endsection