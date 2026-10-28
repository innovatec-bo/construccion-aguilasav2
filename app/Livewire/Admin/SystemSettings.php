<?php

namespace App\Livewire\Admin;

use App\Settings\SystemSettings as AppSystemSettings;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SystemSettings extends Component
{
    use WithFileUploads;

    private AppSystemSettings $settings;

    // Rutas guardadas
    public ?string $appLogo = null;
    public ?string $documentLogo = null;
    public ?string $pinMarker = null;
    public ?string $favicon = null;

    // Subidas temporales
    public $newAppLogo;
    public $newDocumentLogo;
    public $newPinMarker;
    public $newFavicon;

    public function mount()
    {
        $this->settings = app(AppSystemSettings::class);

        $this->appLogo = $this->settings->app_logo;
        $this->documentLogo = $this->settings->document_logo;
        $this->pinMarker = $this->settings->pin_marker;
        $this->favicon = $this->settings->favicon;
    }

    public function rules(): array
    {
        return [
            'newAppLogo'      => ['nullable', 'image', 'max:2048'],
            'newDocumentLogo' => ['nullable', 'image', 'max:3072'],
            'newPinMarker'    => ['nullable', 'image', 'max:1024'],
            'newFavicon'      => ['nullable', 'mimes:ico,png,jpg,svg', 'max:512'],
        ];
    }

    public function save()
    {
        $this->validate();
        $this->settings = app(AppSystemSettings::class);
        // 1. Logo del Sistema (Menú)
        if ($this->newAppLogo) {
            if ($this->settings->app_logo) {
                Storage::disk('public')->delete($this->settings->app_logo);
            }
            $this->settings->app_logo = $this->newAppLogo->store('system', 'public');
            $this->appLogo = $this->settings->app_logo;
            $this->newAppLogo = null;
        }

        // 2. Logo para Documentos / Reportes / Mails
        if ($this->newDocumentLogo) {
            if ($this->settings->document_logo) {
                Storage::disk('public')->delete($this->settings->document_logo);
            }
            $this->settings->document_logo = $this->newDocumentLogo->store('system', 'public');
            $this->documentLogo = $this->settings->document_logo;
            $this->newDocumentLogo = null;
        }

        // 3. Pin Marker
        if ($this->newPinMarker) {
            if ($this->settings->pin_marker) {
                Storage::disk('public')->delete($this->settings->pin_marker);
            }
            $this->settings->pin_marker = $this->newPinMarker->store('system', 'public');
            $this->pinMarker = $this->settings->pin_marker;
            $this->newPinMarker = null;
        }

        // 4. Favicon
        if ($this->newFavicon) {
            if ($this->settings->favicon) {
                Storage::disk('public')->delete($this->settings->favicon);
            }
            $this->settings->favicon = $this->newFavicon->store('system', 'public');
            $this->favicon = $this->settings->favicon;
            $this->newFavicon = null;
        }

        $this->settings->save();

        session()->flash('success', 'Configuraciones de identidad actualizadas con éxito.');
    }

    public function render()
    {
        return view('livewire.admin.system-settings');
    }
}