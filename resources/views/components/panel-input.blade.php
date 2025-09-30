<div class="row g-0 g-lg-3  align-items-center mb-3 mb-lg-4">
    <div class="col-12 {{ $isFull ? 'col-lg-2' : 'col-lg-3' }}">
        @if($label)
        <label for="{{ $name }}" class="col-form-label"><span id="{{ $name }}-label">{{ $label }}</span><span class="text-danger">{{$required ? '*' : ''}}</span></label>
        @endif
    </div>
    <div class="col-12 {{ $isFull ? 'col-lg-10' : 'col-lg-8' }}">
        @if($type == 'textarea')
        <textarea 
            class="form-control" 
            id="{{ $name }}" 
            name="{{ $name }}"  
            rows="5"
            {{ $disabled ? 'disabled' : ''}} 
            {{ $required ? 'required' : ''}}
        >{!! $value !!}</textarea>
        @else
        <input 
            type="{{ $type }}" 
            id="{{ $name }}" 
            value="{{ $value }}" 
            name="{{ $name }}" 
            class="form-control"
            placeholder="Masukkan {{ $label }}..."
            {{ $max ? "max= $max" : ''}}
            {{ $min ? "min= $min" : ''}}
            {{ $disabled ? 'disabled' : ''}} 
            {{ $required ? 'required' : ''}}
        >
        @endif
    </div>
</div>