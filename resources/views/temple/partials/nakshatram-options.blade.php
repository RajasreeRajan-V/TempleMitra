{{-- 
    resources/views/temple/partials/nakshatram-options.blade.php

    Reusable Nakshatram option list
--}}

@php
    $nakshatrams = [
        'Ashwathi',
        'Bharani',
        'Karthika',
        'Rohini',
        'Makayiram',
        'Thiruvathira',
        'Punartham',
        'Pooyam',
        'Ayilyam',
        'Makam',
        'Pooram',
        'Uthram',
        'Atham',
        'Chithira',
        'Chothi',
        'Vishakham',
        'Anizham',
        'Thrikketta',
        'Moolam',
        'Pooradam',
        'Uthradam',
        'Thiruvonam',
        'Avittam',
        'Chathayam',
        'Poororuttathi',
        'Uthrattathi',
        'Revathi',
    ];

    $selected = $selected ?? null;
@endphp

@foreach ($nakshatrams as $star)
    <option value="{{ $star }}" {{ $selected === $star ? 'selected' : '' }}>
        {{ $star }}
    </option>
@endforeach