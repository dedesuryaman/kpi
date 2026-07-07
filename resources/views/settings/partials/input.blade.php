@php
$name = "settings[{$setting->id}]";
@endphp

@if($setting->setting_type === 'boolean')
<select name="{{ $name }}" class="form-select">
    <option value="1" {{ $setting->setting_value == 1 ? 'selected' : '' }}>Aktif</option>
    <option value="0" {{ $setting->setting_value == 0 ? 'selected' : '' }}>Nonaktif</option>
</select>

@elseif($setting->setting_type === 'json')
<textarea name="{{ $name }}" class="form-control" rows="4">
{{ json_encode(json_decode($setting->setting_value), JSON_PRETTY_PRINT) }}
    </textarea>

@elseif($setting->setting_type === 'number')
<input type="number" name="{{ $name }}" class="form-control" value="{{ $setting->setting_value }}">

@else
<input type="text" name="{{ $name }}" class="form-control" value="{{ $setting->setting_value }}">
@endif

@if($setting->description)
<small class="text-muted">{{ $setting->description }}</small>
@endif