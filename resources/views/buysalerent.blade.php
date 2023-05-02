@include('header')

<!-- banner -->
<div class="inside-banner">
    <div class="container">
        <span class="pull-right"><a href="{{route('index')}}">Home</a> / Buy, Rent</span>
        <h2>Buy, Rent</h2>
    </div>
</div>
<!-- banner -->

<div class="container">
    <div class="properties-listing spacer">

        <div class="row">
            <div class="col-lg-3 col-sm-4 ">

                <div class="search-form"><h4><span class="glyphicon glyphicon-search"></span> Search for</h4>
                   <form action="{{route('search')}}" method="GET">
                       @csrf
                       <input name="state" type="text" class="form-control" placeholder="State Name">
                       <input name="city" type="text" class="form-control" placeholder="City Name">
                       <input name="name" type="text" class="form-control" placeholder="Property Name">
                       <div class="row">
                           <div class="col-lg-5">
                           <select id="for" name="for" class="form-control">
                                 <option>for what</option>
                                 <option value="sale" >Buy</option>
                                 <option value="rent">Rent</option>
                             </select>
                           </div>

                           <div class="col-lg-7">
                           <select id="price" name="price" class="form-control">
                                 <option>Price</option>
                                 <option value="100000"> less than $50,000</option>
                                 <option value="50000">less than $30,000</option>
                                 <option value="30000">less than $15,000</option>
                                 <option value="15000">less than $5000</option>
                             </select>
                           </div>

                       </div>

                       <div class="row">
                           <div class="col-lg-12">
                           <select id="type" name="type" class="form-control">
                                 <option>type</option>
                                 <option value="appartment">Apartment</option>
                                 <option value="sallon" >Office Space</option>
                                 <option value="home" >Home</option>
                             </select>
                           </div>
                       </div>
                       <button class="btn btn-primary">Find Now</button>
                   </form>
                </div>
                <div class="hot-properties hidden-xs">
                    <h4>Hot Properties</h4> {{-- the cheapest apartments --}}
                    @foreach($units as $unit )
                        <div class="row">
                            <div class="col-lg-4 col-sm-5">
                                <img src="{{isset($unit->images->first()->imag )? 'images/'. $unit->images->first()->imag: 'https://st4.depositphotos.com/14953852/22772/v/600/depositphotos_227725020-stock-illustration-image-available-icon-flat-vector.jpg'}}"   class="img-responsive img-circle" alt="properties"/>
                            </div>
                            <div class="col-lg-8 col-sm-7">
                                <h5><a href="{{route('propertydetail', $unit->id)}}">{{$unit->parent->state_name . " " . $unit->parent->city_name . " " . $unit->parent->street_name . " " . $unit->parent->parent_name . " "}}</a></h5>
                                <p class="price">${{$unit->price}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="col-lg-9 col-sm-8">
                <div class="sortby clearfix">
                    <div class="pull-left result">Showing: {{count($Result)}} </div>
                    <form method="GET" action="{{route('sortData')}}" class="pull-right">
                        <label>
                            <input type="radio" name="sort" value="asc"  {{ isset($by) && $by =='asc'  ? 'checked' : '' }}>
                            Price: Low to High
                        </label><br>
                        <label>
                            <input type="radio" name="sort" value="desc" {{  isset($by) && $by == 'desc' ? 'checked' : '' }}>
                            Price: High to Low
                        </label><br>
                        <button type="submit" class="btn btn-primary">Sort</button>
                    </form>

                </div>
                <div class="row">

                    <!-- properties -->

                    @php
                        $count = 0;
                    @endphp
                    @if(is_array($Result) || is_object($Result))
                        @foreach($Result as $unit)
                            @if ($count >= 15)
                                @break
                            @endif
                            <div class="col-lg-4 col-sm-6">
                                <div class="properties">
                                    <div class="image-holder"><img src="{{isset($unit->images->first()->imag) ?'images/'.$unit->images->first()->imag: 'https://st4.depositphotos.com/14953852/22772/v/600/depositphotos_227725020-stock-illustration-image-available-icon-flat-vector.jpg'}}" style="width: 274px; height: 205px;"  class="img-responsive" alt="properties"/>
                                        @if ($unit->is_available)
                                            <div class="status sold">Available</div>
                                        @else
                                            <div class="status new">Sold</div>
                                        @endif
                                    </div>
                                    <h4><a href="{{route('propertydetail')}}">{{$unit->type}}</a></h4>
                                    <p class="price">Price: ${{$unit->price}}</p>
                                    <div class="listing-detail"><span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room">{{ $unit->feature->bedrooms}}</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room">{{$unit->feature->living_rooms }}</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bathroom">{{ $unit->feature->bathroom }}</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Kitchen">{{$unit->feature->kitchen }}</span> </div>
                                    <a class="btn btn-primary"  href="{{route('propertydetail', $unit->id)}}" >View Details</a>
                                </div>
                            </div>
                            @php $count++; @endphp
                        @endforeach
                    @endif

                    <!-- properties -->

                    <div class="center">
                        @if ($Result)
                            {{ $Result->links() }}
                        @else
                            No results found.
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
