@props([
    'student',
    'size' => 'md', // sm, md, lg, xl
    'showEmail' => true,
    'showName' => true,
    'vertical' => false // nova opção para layout vertical
])

@php
    // Define os tamanhos
    $sizes = [
        'sm' => ['container' => '40px', 'icon' => ''],
        'md' => ['container' => '50px', 'icon' => ''],
        'lg' => ['container' => '80px', 'icon' => 'fa-lg'],
        'xl' => ['container' => '120px', 'icon' => 'fa-2x']
    ];
    
    $sizeConfig = $sizes[$size] ?? $sizes['md'];
    
    // Define o layout
    $layoutClass = $vertical ? 'flex-column text-center' : 'align-items-center';
    $textClass = $vertical ? 'mt-2 text-center' : 'flex-grow-1';
    $spacingClass = $vertical ? 'mb-2' : 'me-3';
@endphp

<div class="d-flex {{ $layoutClass }}" {{ $attributes }}>
    <div class="{{ $spacingClass }}">
        @if($student->foto)
            <img src="{{ asset('images/profiles/' . $student->foto) }}" 
                alt="Foto de {{ $student->name }}"
                class="rounded-circle"
                style="width: {{ $sizeConfig['container'] }}; height: {{ $sizeConfig['container'] }}; object-fit: cover;"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        @else
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                style="width: {{ $sizeConfig['container'] }}; height: {{ $sizeConfig['container'] }};">
                <i class="fas fa-user text-white {{ $sizeConfig['icon'] }}"></i>
            </div>
        @endif
    </div>
    
    @if($showName || $showEmail)
    <div class="{{ $textClass }}">
        @if($showName)
            <strong class="d-block">{{ $student->name }}</strong>
        @endif
        @if($showEmail)
            <small class="text-muted">{{ $student->email }}</small>
        @endif
    </div>
    @endif
</div>