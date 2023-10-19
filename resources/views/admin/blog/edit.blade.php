@extends('layouts.admin')

@section('content')

<div class="container flex flex-col items-end justify-start mt-10 py-8">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Edit a post</h1>
        <form class="w-full flex justify-center" action="/admin/posts/update/" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $post->id }}">
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                @if (!$errors->isEmpty())
                <div role="alert" class="w-full pb-8">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Empty Fields
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        @foreach ($errors->all() as $message)
                            <ul class="px-4">
                                <li class="list-disc">{{$message}}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="title" :value="__('Title')"></x-label>
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $post->title }}" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="slug" :value="__('Slug')"></x-label>
                        <x-input id="slug" class="block mt-1 w-full" type="text" name="slug" value="{{ $post->slug }}" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="body" :value="__('Content')"></x-label>
                        <textarea style="resize: none; border-radius: 5px;height:100px" name="body">{{ $post->body }}"</textarea>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="status" :value="__('Status')"></x-label>
                        <select style="border-radius:5px;" name="status" id="status">
                            <option value="draft" @if ('draft' == $post->status) selected @endif>Draft</option>
                            <option value="published" @if ('published' == $post->status) selected @endif>Published</option>
                            <option value="archived" @if ('archived' == $post->status) selected @endif>Archived</option>
                        </select>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="published_at" :value="__('Published at')"></x-label>
                        <x-input id="published_at" class="block mt-1 w-full form-control" type="datetime-local" name="published_at" value="{{ $post->published_at }}" required autofocus />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="/admin/posts">Back</a>
                    <x-button class="ml-4">
                        {{ __('Edit') }}
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
@section('scripts')
    @include('admin.blog.partials.scripts')
@endsection
