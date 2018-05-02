@foreach($features as $feature)
<div class="form-group">
    <label for="type" class="col-sm-2 control-label">{{$feature->name}}</label>
    <div class="col-sm-10">
        @if(count($feature->child) > 0)
            <select name="feature[]" class="select2" style="width:100%" multiple>
                @foreach($feature->child as $child)
                    <option @if(in_array($child->id,$variants)) selected @endif value="{{$child->id}}">{{$child->name}}</option>
                @endforeach
            </select>
        @endif
    </div>
</div>
@endforeach