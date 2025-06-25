@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Dashboard - Aseo Familiar</h1>
        <p class="lead">Sistema de gestión de actividades familiares</p>
    </div>
</div>

@auth
<div class="row">
    @can('users.view')
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-people-fill fs-1 text-primary"></i>
                <h5 class="card-title mt-2">Usuarios</h5>
                <p class="card-text">Gestionar usuarios del sistema</p>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Ver Usuarios</a>
            </div>
        </div>
    </div>
    @endcan

    @can('activities.view')
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-list-check fs-1 text-success"></i>
                <h5 class="card-title mt-2">Actividades</h5>
                <p class="card-text">Gestionar actividades de aseo</p>
                <a href="{{ route('activities.index') }}" class="btn btn-success">Ver Actividades</a>
            </div>
        </div>
    </div>
    @endcan

    @can('assignments.view')
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-calendar-week fs-1 text-warning"></i>
                <h5 class="card-title mt-2">Asignaciones</h5>
                <p class="card-text">Asignar actividades por día</p>
                <a href="{{ route('user-activities.index') }}" class="btn btn-warning">Ver Asignaciones</a>
            </div>
        </div>
    </div>
    @endcan
</div>

@if(auth()->user()->hasRole('user'))
<div class="row mt-4">
    <div class="col-12">
        <h3>Mis Actividades de Hoy</h3>
        @php
            $todayActivities = auth()->user()->getTodayActivities();
        @endphp
        
        @if($todayActivities->count() > 0)
            <div class="row">
                @foreach($todayActivities as $assignment)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $assignment->activity->name }}</h5>
                            <p class="card-text">{{ $assignment->activity->description }}</p>
                            <span class="badge bg-info">{{ $assignment->weekday->name }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                No tienes actividades asignadas para hoy.
            </div>
        @endif
    </div>
</div>
@endif
@endauth
@endsection
