@include('header')

<!-- banner -->
<div class="inside-banner">
  <div class="container">
    <span class="pull-right"><a href="{{route('index')}}">Home</a> / Add Unit</span>
    <h2>Add Unit</h2>
</div>
</div>
<!-- banner -->
<div class="container " >
    <div class="spacer " >
        <div class="row" style="margin: 10px;">
            <form method="POST" action="{{route('ubload')}}" enctype="multipart/form-data">
                @csrf
                {{--<div class="form-group input-group-lg">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="form-group input-group-lg">
                    <label for="description">Furniture:</label>
                    <input type="text" class="form-control" id="description" name="furniture" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="">-- Select --</option>
                        <option value="apartment">Apartment</option>
                        <option value="salon">Salon</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="for_whate">For:</label>
                    <select class="form-control" id="for_whate" name="for" required>
                        <option value="">-- Select --</option>
                        <option value="sale">Sale</option>
                        <option value="rent">Rent</option>
                    </select>
                </div>
--}}
                <label>Unit Images: </label>
                <div class="col-md-4 input-group">
                    <input type="file" id="image" name="image[]" multiple>
                    @if ($errors->has('image'))
                           <div class="alert alert-danger">{{ $errors->first('image') }}</div>
                    @endif
                </div>
{{--
                <div class="form-group ">
                    <label for="components">Components:</label>
                    <div class="components">
                        <label><input type="number" style=" width: 30px; " name="components1" > Bedroom</label>
                    </div>
                    <div class="components">
                        <label><input type="number" style=" width: 30px; " name="components2" > Living Room</label>
                    </div>
                    <div class="components">
                        <label><input type="number" style=" width: 30px; " name="components3" > Bath Room</label>
                    </div>
                    <div class="components">
                        <label><input type="number" style=" width: 30px; " name="components4"> Kitchen</label>
                    </div>
                </div>
                <div class="checkbox-inline" style="margin-right: 80px;">
                    <div class="form-check ">
                        <input name="air" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">Air Condition</label>
                    </div>
                    <div class="form-check ">
                        <input name="heat" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">Central Heating</label>
                    </div>
                </div>
                <div class="checkbox-inline" style="margin-right: 20px;">
                    <div class="form-check ">
                        <input name="air" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">test</label>
                    </div>
                    <div class="form-check ">
                        <input name="heat" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">test</label>
                    </div>
                </div>

 --}}
                    <div style="margin: 30px;">
                       <button class=" btn btn-success" >Ubload</button>
                   </div>

            </form>
        </div>
    </div>
</div>
@include('footer')
