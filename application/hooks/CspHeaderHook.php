<?php
class CspHeaderHook {
    public function addCspHeader() {
        header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self';");
    }
}
