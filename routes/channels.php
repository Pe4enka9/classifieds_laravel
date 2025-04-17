<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('ads', function () {
    return true;
});
