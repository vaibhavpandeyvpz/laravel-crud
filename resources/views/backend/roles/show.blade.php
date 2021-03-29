@extends('layouts.backend')

@section('meta')
    <title>{{ __('Roles') }} - {{ $role->name }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <main class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.roles.index') }}">{{ __('Roles') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-3">
            @can('viewAny', Spatie\Permission\Models\Role::class)
                <a class="btn btn-outline-dark" href="{{ route('backend.roles.index') }}">
                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Roles') }}
                </a>
            @endcan
            @can('update', $role)
                <a class="btn btn-info ml-auto" href="{{ route('backend.roles.edit', $role) }}">
                    <i class="fas fa-feather mr-1"></i> {{ __('Edit') }}
                </a>
            @endcan
            @can('delete', $role)
                <button class="btn btn-danger ml-1" data-toggle="popover" data-title="{{ __('Delete') }}" data-target="#delete-confirmation">
                    <i class="fas fa-trash mr-1"></i> {{ __('Delete') }}
                </button>
            @endcan
        </div>
        <div id="delete-confirmation" style="display: none;">
            <p>{{ __('This action cannot be undone. Are you sure?') }}</p>
            <form action="{{ route('backend.roles.destroy', $role) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="btn-toolbar">
                    <button class="btn btn-danger btn-sm ml-auto"><i class="fas fa-trash mr-1"></i> {{ __('Delete') }}</button>
                    <button class="btn btn-outline-dark btn-sm ml-1 mr-auto" data-dismiss="popover" type="button">{{ __('Cancel') }}</button>
                </div>
            </form>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ __('Details') }}</h5>
                <p class="card-text">{{ __('See information about existing role here.') }}</p>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <tbody>
                    <tr>
                        <th class="bg-light">{{ __('Name') }}</th>
                        <td class="w-100">{{ $role->name }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">{{ __('Permissions') }}</th>
                        <td class="w-100">
                            @forelse ($role->permissions()->get() as $permission)
                                <span class="badge badge-dark mr-1">{{ $permission->name }}</span>
                            @empty
                                <span class="text-muted">{{ __('None') }}</span>
                            @endforelse
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">{{ __('Users') }}</th>
                        <td class="w-100">
                            @php
                                $count = App\User::query()
                                    ->whereHas('roles', function ($query) use ($role) {
                                        $query->whereKey($role->id);
                                    })
                                    ->count();
                            @endphp
                            {{ __(':count Users', compact('count')) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <span class="text-muted">{{ __('Created at') }}</span> {{ Timezone::convertToLocal($role->created_at) }}
                <span class="d-none d-md-inline">
                    &bull;
                    <span class="text-muted">{{ __('Updated at') }}</span> {{ Timezone::convertToLocal($role->updated_at) }}
                </span>
            </div>
        </div>
    </main>
@endsection
