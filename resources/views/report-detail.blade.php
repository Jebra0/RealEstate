@include('header')
<!-- banner -->
<div class="inside-banner">
    <div class="container">
{{--        <span class="pull-right"><a href="{{route('index')}}">Home</a> / Buy</span>--}}
        <h2>Reported Unit</h2>
    </div>
</div>
<!-- banner -->

<div class="container">
    <div class="properties-listing spacer">

        <div class="row">

            <div class="col-lg-9 col-sm-8 ">
                @php
                    $currentUnit = GetUnit($id);
                    $active = "active";
                @endphp

                <div class="dropdown pull-right">
                    <button class=" btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                        </svg>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                            @auth()
                                @if($currentUnit->user->id == \Illuminate\Support\Facades\Auth::id() && $currentUnit->is_available == 1)
                                    <a href="{{route('Units.edit', $currentUnit->id)}}">
                                        Edit the post
                                    </a>
                                @endif
                            @endauth
                        </li>
                        <li>
                            @auth()
                                @if($currentUnit->user->id == \Illuminate\Support\Facades\Auth::id() && $currentUnit->is_available == 1)
                                    <a href="{{ route('mark.sold', $currentUnit->id) }}"   >
                                        Mark as Sold
                                    </a>
                                @endif
                            @endauth
                        </li>

                        <li role="separator" class="divider"></li>

                        <li style="margin-left: 42px; margin-top: 8px; width: 50%;">
                            @auth()
                                @if($currentUnit->user->id != \Illuminate\Support\Facades\Auth::id())
                                    <button {{ IsReported($currentUnit->id) ? 'disabled' : ''}} type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmReportModal">
                                        Report
                                    </button>
                                @endif
                            @endauth
                        </li>
                        <li style="margin-left: 42px; margin-top: 8px; width: 50%;">
                            @auth()
                                @if($currentUnit->user->id == \Illuminate\Support\Facades\Auth::id())
                                    <a href="{{ route('Units.destroy', $currentUnit->id) }}" type="button" class="btn btn-danger" >
                                        Delete
                                    </a>
                                @endif
                            @endauth
                        </li>

                    </ul>
                </div>

                <h2>@if($currentUnit->is_available) Available @else Not Available @endif</h2>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="property-images">
                            <!-- Slider Starts -->
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators hidden-xs">
                                    @for($i=0; $i<count($currentUnit->images); $i++)
                                         <li data-target="#myCarousel" data-slide-to="{{$i}}" class="@if($i == 1 ) {{$active}} @endif "></li>
                                    @endfor
                                </ol>
                                <div class="carousel-inner">
                                    <!-- Item 1 -->
                                    @for($i = 0; $i < count($currentUnit->images); $i++)
                                        <div class="item @if($i == 0) {{$active}} @endif">
                                            <img src="images/{{$currentUnit->images[$i]->imag}}" class="properties" alt="properties">
                                        </div>
                                    @endfor
                                    <!-- #Item 1 -->
                                </div>
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                            </div>
                            <!-- #Slider Ends -->

                        </div>

                        <div class="spacer"><h4><span class="glyphicon glyphicon-th-list"></span> Properties Detail</h4>
                            <p>{{$currentUnit->description}}</p>
                            <p>{{$currentUnit->type . " ". $currentUnit->feature->bedrooms . " Bedroom " . $currentUnit->feature->living_rooms . " living Room ". $currentUnit->feature->kitchen . " kitchen " ." for " .$currentUnit->for_what . " posted in : " . $currentUnit->date_of_posting}}</p>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="col-lg-12  col-sm-6">
                            <div class="property-info">
                                <p class="price">$ {{$currentUnit->price}}</p>
                                <p class="area"><span class="glyphicon glyphicon-map-marker"></span> {{$currentUnit->parent->state_name . " _ " . $currentUnit->parent->city_name . " _ " . $currentUnit->parent->street_name . " _ " . $currentUnit->parent->parent_name . " "}}</p>
                                <div class="profile">
                                    <span class="glyphicon glyphicon-user"></span> Posted By
                                    <p>{{$currentUnit->user->name}}<br>{{$currentUnit->user->number}}</p>
                                </div>
                            </div>

                            <h6><span class="glyphicon glyphicon-home"></span> Availabilty</h6>
                            <div class="listing-detail"><span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room">{{ $currentUnit->feature->bedrooms}}</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room">{{$currentUnit->feature->living_rooms }}</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bathroom">{{ $currentUnit->feature->bathroom }}</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Kitchen">{{$currentUnit->feature->kitchen }}</span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
