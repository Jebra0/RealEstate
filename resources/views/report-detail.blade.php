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
