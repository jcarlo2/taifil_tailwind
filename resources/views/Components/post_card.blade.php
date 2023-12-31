
<div data-aos="fade-left" class="p-5 bg-white border-green-700 border-2 rounded shadow-md my-5 md:h-80 overflow-hidden">
    <div class="title flex justify-between">
        <h1 class="text-lg md:text-3xl font-bold uppercase">{{$title}}</h1>
        @admin
        <a href="/client/gallery/delete?id={{$id}}" class="delete_post text-red-600 font-bold">x</a>
        @endadmin
    </div>
    
    <div class="tab_details flex gap-5 text-xs md:text-sm text-gray-400 my-3">
        <div class="date cursor-default">{{$date}}</div>
        <div class="time cursor-default">
            {{$time}}
        </div>
        <div>
            <a href="{{'/client/gallery?cat='.$cat}}" class="hover:text-black">{{$cat}}</a>
        </div>
    </div>
    <hr class="bg-cyan-800">
    <div class="card_content md:grid grid-flow-col grid-cols-3 gap-5 mt-5">
        @if($image != '')
        <div class="content_img w-full h-40 rounded-md overflow-hidden col-span-1">
            {{-- <img src="{{url('storage/'.$image)}}" class="w-full h-auto" alt=""> --}}
            <img src="data:image/png;base64,{{$image}}" class="w-full h-auto" alt="">
        </div>
        @endif
        
        <div class="content_details w-auto col-span-2">
            <div class="details whitespace-pre-line text-ellipsis max-h-36 overflow-hidden text-gray-600 text-sm font-sans">
                    {!! html_entity_decode($content) !!}
            </div>
            <hr>
            <div class="mt-3">
                <a href="/client/gallery/post?id={{$id}}" class="text-black hover:text-green-700 focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-900 font-medium rounded-lg text-sm inline-flex justify-center w-auto text-center">Read more...</a>
            </div>
        </div>
    </div>
</div>