<?php

if (! function_exists('abort_page')) {
    function abort_page($code) {
        return view('error.error', ['code' => $code]);
    }
}
