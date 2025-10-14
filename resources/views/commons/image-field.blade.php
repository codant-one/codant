<div class="{{ $classImage ?? 'rounded border p-10' }}">
   @if($default !== null)
   @php
      $default.='?'.rand(10000,99999);
   @endphp
   <div class="image-input image-input-{{ $type ?? 'outline'}}" data-kt-image-input="true"
   style="background-image: url( '{{ $background ?? asset('img/placeholders/user.png') }}' )">

      <div id="bg_{{$name}}" class="image-input-wrapper w-125px h-125px remove-image-event" style="background-image: url('{{ $default }}'); @isset($style) {{ $style }} @endisset"></div>
   @else
   <div class="image-input image-input-empty" data-kt-image-input="true"
      style="background-image: url( '{{ $background ?? asset('img/placeholders/user.png') }}' )">

      <div id="bg_{{$name}}" class="image-input-wrapper w-125px h-125px"></div>
   @endif
   
      <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow btn-change svg-only-icon"
         data-kt-image-input-action="change"
         data-bs-toggle="tooltip"
         data-bs-dismiss="click"
         title="Actualizar imagen">
   
         <svg width="20" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.7599 3.59924L5.54985 12.2892C5.23985 12.6192 4.93985 13.2692 4.87985 13.7192L4.50985 16.9592C4.37985 18.1292 5.21985 18.9292 6.37985 18.7292L9.59985 18.1792C10.0499 18.0992 10.6799 17.7692 10.9899 17.4292L19.1999 8.73924C20.6199 7.23924 21.2599 5.52924 19.0499 3.43924C16.8499 1.36924 15.1799 2.09924 13.7599 3.59924Z" stroke="#949494" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12.3901 5.05078C12.8201 7.81078 15.0601 9.92078 17.8401 10.2008" stroke="#949494" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
         </svg>
   
         <input type="file" name="{{ $name }}" accept=".png, .jpg, .jpeg" {{ $required ?? '' }}/>
         <input type="hidden" name="{{ $name }}_remove" />
   
      </label>
   
      <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow btn-cancel svg-only-icon"
         data-kt-image-input-action="cancel"
         data-bs-toggle="tooltip"
         data-bs-dismiss="click"
         title="Remover imagen">
         <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.50327 14.8299L15.1633 9.16992" stroke="#949494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15.1633 14.8299L9.50327 9.16992" stroke="#949494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
         </svg>

      </span>
   
      <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow btn-remove svg-only-icon"
         data-kt-image-input-action="remove"
         data-bs-toggle="tooltip"
         data-bs-dismiss="click"
         title="Remover imagen"
         id="{{ $name }}_remove">
         <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.50327 14.8299L15.1633 9.16992" stroke="#949494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15.1633 14.8299L9.50327 9.16992" stroke="#949494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
         </svg>
      </span>
   
   </div>
</div>