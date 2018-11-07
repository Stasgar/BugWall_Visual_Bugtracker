@extends('layouts.project')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/project.css') }}" />
<link rel="stylesheet" href="{{ asset('css/bugtracker/team.css') }}" />
@endsection

@section('scripts')
<!-- Passing the policy to js -->
<script>
    (function() {
        window.auth_user = {};
        @can('delete', $project)
            window.auth_user.canRemoveMember = true;
        @else
            window.auth_user.canRemoveMember = false;
        @endcan
        @can('manage', $project)
            window.auth_user.canManage = true;
        @else
            window.auth_user.canManage = false;
        @endcan
    })();
</script>
@endsection

@section('project-content')
    {!! Breadcrumbs::render('team', $project) !!}
    <div id="search-team-component"></div><!-- see react TeamComponent.js -->
@endsection
