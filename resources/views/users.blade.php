@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Name</th>
                <th scope="col">Current Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $u->username }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->getRoleNames() }}</td>
                <td>
                    @if(Auth::id() !== $u->id)
                    <form action="{{ route('user.role', ['user' => $u->id]) }}" method="POST">
                        @csrf
                        <select name="role">
                            <option value="super admin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="moderator">Moderator</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </form>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $users->links('vendor.pagination.bootstrap-4') }}
</div>

@endsection
