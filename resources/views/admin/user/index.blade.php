@extends('layouts.app')

@section('content')
<div class="container" style="height: 85vh;">
    <div class="card text-white bg-dark h-100">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Users
        </div>
        <div class="card-body overflow-auto">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Name</th>
                        @can('edit roles')
                        <th scope="col">Current Role</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    @if($u->username !== 'adsense')
                    <tr>
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->name }}</td>
                        @can('edit roles')
                        <td>{{ $u->getRoleNames() }}</td>
                        @if(Auth::id() !== $u->id)
                        <form action="{{ route('user.update.role', ['user' => $u->id]) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <td>
                                @foreach($roles as $r)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $r->name }}" id="sadmin" name="roles[]">
                                    <label class="form-check-label" for="sadmin">
                                        {{ $r->name }}
                                    </label>
                                </div>
                                @endforeach
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Apply</button>
                            </td>
                        </form>
                        <td>
                            <form action="{{ route('user.destroy', ['user' => $u->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="fas fa-user-minus"></i></button>
                            </form>
                        </td>
                        @endif
                        @endcan
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer small text-muted">
            {{ $users->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>

@endsection
