@extends('layouts.admin')

@section('content')

<div class="container flex flex-col items-end py-8">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Create New File</h1>
        <form class="w-full flex justify-center" action="{{ route('medias.store') }}" method="post" enctype="multipart/form-data">
            @include('admin.medias.partials.fields')
        </form>
    </div>
</div>

@endsection

@section('scripts')

@include('admin.medias.partials.scripts')

@endsection