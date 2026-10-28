<?php

namespace App\Settings;

use Illuminate\Support\Facades\Storage;
use Spatie\LaravelSettings\Settings;

class SystemSettings extends Settings
{
    public ?string $app_logo;
    public ?string $document_logo;
    public ?string $pin_marker;
    public ?string $favicon;

    public static function group(): string
    {
        return 'system';
    }

    public function getAppLogoUrl(): ?string
    {
        return $this->app_logo ? Storage::disk('public')->url($this->app_logo) : asset('images/logo.png');
    }

    public function getDocumentLogoUrl(): ?string
    {
        return $this->document_logo ? Storage::disk('public')->url($this->document_logo) : asset('images/document_logo.png');
    }

    public function getPinMarkerUrl(): ?string
    {
        return $this->pin_marker ? Storage::disk('public')->url($this->pin_marker) : asset('images/pin-marker.png');
    }

    public function getFaviconUrl(): ?string
    {
        return $this->favicon ? Storage::disk('public')->url($this->favicon) : asset('images/favicon.ico');
    }

    /**
     * Return the absolute physical route in server
     * Useful for PhpSpreadsheet to insert images into Excel without require HTTP requests
     */
    public function getDocumentLogoRealPath(): ?string
    {
        return $this->document_logo && Storage::disk('public')->exists($this->document_logo)
            ? Storage::disk('public')->path($this->document_logo)
            : null;
    }
}