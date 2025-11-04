<?php
@if ($verified ?? false)
    <img src="{{ asset('images/verified-badge.png') }}" alt="Verificado"
         class="inline-block h-4 w-4 align-middle" title="Usuario verificado">
@endif
