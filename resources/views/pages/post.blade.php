

@section('title')
    Post
@endsection
@extends('layout.client')


@section('content')
<x-opening_spin/>
<nav class="py-2 px-1 md:px-10 md:py-5 bg-green-500 " aria-label="Breadcrumb">
  <div class="max-w-7xl text-center md:flex justify-between mx-auto px-10">
      <div class="text-sm md:text-2xl text-white">Gallery</div>
  <ol class="inline-flex items-center space-x-1 md:space-x-3">
    <li class="inline-flex items-center">
      <a href="/" class="text-white inline-flex items-center text-xs md:text-sm font-medium hover:text-blue-600">
        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
        Home
      </a>
    </li>
    <li aria-current="page">
      <div class="flex items-center">
        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        <span class="ml-1 text-xs md:text-sm font-medium text-gray-500 md:ml-2">Gallery</span>
      </div>
    </li>
    <li aria-current="page">
      <div class="flex items-center">
        <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        <span class="ml-1 text-sm font-medium text-gray-300 md:ml-2 dark:text-gray-400">{{$data[0]['title']}}</span>
      </div>
    </li>
  </ol>
  </div>
  
</nav>

<section class="mt-5 mb-5 ">
    <div class="min-h-screen max-w-7xl md:mx-auto mx-5  p-2 overflow-x-hidden md:grid grid-cols-5 grid-flow-col gap-5">
        <div class=" text-black p-4 rounded col-span-1 ">
            <div class="text-2xl font-bold mb-2">
                CATEGORIES
            </div>
            <div class="p-2">
                <a href="/client/gallery" class="hover:text-sky-800">All</a>
            </div>
            <hr>
            <div class="p-2">
                <a href="/client/gallery?cat=events" class="hover:text-sky-800">Event</a>
            </div>
            <hr>
            <div class="p-2">
                <a href="/client/gallery?cat=departure" class="hover:text-sky-800">Departure</a>
            </div>
            <hr>
        </div>
        <div class="w-full col-span-4">
            <div class="title">
                <h1 class="text-2xl">{{$data[0]['title']}}</h1>
            </div>
            <div class="tab_details flex gap-5 text-sm font-normal text-gray-400 my-3">
                <div class="date cursor-default">{{$data[0]['date']}}</div>
                <div class="time cursor-default">
                    {{$data[0]['time']}}
                </div>
                <div>
                    <a href="" class="hover:text-black">{{$data[0]['category']}}</a>
                </div>
            </div>
            <hr>

            @if(count($data[0]['images']) != 0)
                
            <div class="swiper w-auto h-96 mt-5">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                  <!-- Slides -->
                  @foreach($data[0]['images'] as $image)
                  <div class="swiper-slide flex justify-center items-center">
                    {{-- <img src="{{url('storage/'.$image['path'])}}" class="object-contain w-auto h-full" alt=""> --}}
                    <img src="data:image/png;base64,{{base64_encode($image['path'])}}" class="object-contain w-auto h-full" alt="">
                  </div>
                  @endforeach
                  ...
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
              
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              
                <!-- If we need scrollbar -->
                
            </div>
            @endif
            

            
            @if($data[0]['content'] !="<p><br></p>")
            <hr class="mt-5">
            <div class="content whitespace-pre-line text-ellipsis overflow-hidden font-sans snow">
              <div class="ql-editor">
                {!! html_entity_decode($data[0]['content']) !!}

              </div>
               {{-- {{$data[0]['content']}} --}}
            </div>
            @endif
            <hr class=" mt-10">
            <div class="flex justify-between py-5">
                
                @if(isset($next['id']))
                <a href="/client/gallery/post?id={{$next['id']}}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-auto text-center"><< Prev Post</a>
                @endif
                @if(isset($prev['id']))
                <a href="/client/gallery/post?id={{$prev['id']}}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-auto text-center">Next post >></a>
                @endif
                
                
            </div>
            <hr class="mb-10">
        </div>
    </div>
</section>
@endsection
@push('scripts')
   <script defer src="{{asset("js/client/gallery.js")}}"></script>
@endpush