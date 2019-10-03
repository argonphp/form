{{-- 

Propriedades:
  url - Seta a url do link
  icon - Seta o tipo de icone, utilize o padrão fontawesome (fa-cog, por exemplo)
  badge - O texto ou numero que será mostrado no badge

--}}
<?php if(substr($url ?? '', 0, 1) == '/') $baseUrl = substr($url, 1); ?>
<li class="nav-item">
    <a href="{{ $url ?? "#" }}" class="nav-link <?php 
      if ( (isset($url)) and Request::is([$baseUrl, "$baseUrl/*"])) { echo "active";} 
    ?>">
      <i class="nav-icon fa {{ $icon ?? '' }}"></i>
      <p>
        {{$name ?? ''}}
        @isset( $badge )
          <span class="right badge badge-warning">{{ $badge }}</span>
        @endisset
      </p>
    </a>
</li>