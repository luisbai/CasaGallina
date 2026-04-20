<?php

namespace App\Modules\Publication\Presentation\Livewire\Admin;

use App\Modules\Publication\Application\Services\PublicationService;
use App\Modules\Publication\Infrastructure\Models\Publication;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use App\Modules\Shared\Application\Services\GeminiTranslationService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Flux\Flux;

class Form extends Component
{
    use WithFileUploads;

    public string $status = 'public';
    public string $type = 'impreso';
    public string $title = '';
    public string $title_en = '';
    public string $pages_count = '';
    public bool $preview = true;

    public string $publication_date = '';
    public string $publication_date_en = '';
    public string $editorial_coordination = '';
    public string $editorial_coordination_en = '';
    public string $design = '';
    public string $design_en = '';
    public string $texts = '';
    public string $texts_en = '';
    public string $synopsis = '';
    public string $synopsis_en = '';
    public string $additional_content = '';
    public string $additional_content_en = '';

    // Optional Fields
    public string $optional_field_1_title = '';
    public string $optional_field_1 = '';
    public string $optional_field_1_en_title = '';
    public string $optional_field_1_en = '';

    public string $optional_field_2_title = '';
    public string $optional_field_2 = '';
    public string $optional_field_2_en_title = '';
    public string $optional_field_2_en = '';

    public string $optional_field_3_title = '';
    public string $optional_field_3 = '';
    public string $optional_field_3_en_title = '';
    public string $optional_field_3_en = '';

    public string $optional_field_4_title = '';
    public string $optional_field_4 = '';
    public string $optional_field_4_en_title = '';
    public string $optional_field_4_en = '';

    public string $optional_field_5_title = '';
    public string $optional_field_5 = '';
    public string $optional_field_5_en_title = '';
    public string $optional_field_5_en = '';

    public string $optional_field_6_title = '';
    public string $optional_field_6 = '';
    public string $optional_field_6_en_title = '';
    public string $optional_field_6_en = '';

    public string $optional_field_7_title = '';
    public string $optional_field_7 = '';
    public string $optional_field_7_en_title = '';
    public string $optional_field_7_en = '';

    public ?int $exhibition_id = null;
    public string $exhibitionSearch = '';
    public array $exhibitionSearchResults = [];
    public bool $showExhibitionResults = false;

    public $publication_multimedia;
    public $publication_thumbnail;
    public ?int $publicationId = null;

    public $currentThumbnail = null;
    public $currentMultimedia = null;

    protected $publicationService;

    public function boot(PublicationService $publicationService)
    {
        $this->publicationService = $publicationService;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'title_en' => 'required|string|min:3|max:255',
            'status' => 'required|in:public,private',
            'type' => 'required|in:impreso,digital',
            'pages_count' => 'required|integer|min:1|max:9999',
            'exhibition_id' => 'nullable|exists:exposiciones,id',
            'publication_multimedia' => $this->publicationId ? 'nullable|file|mimes:pdf,doc,docx,epub|max:10240' : 'required|file|mimes:pdf,doc,docx,epub|max:10240',
            'publication_thumbnail' => $this->publicationId
                ? 'nullable|image|max:2048|dimensions:min_width=300,min_height=300,max_width=2000,max_height=2000'
                : 'required|image|max:2048|dimensions:min_width=300,min_height=300,max_width=2000,max_height=2000',
            'publication_date' => 'required|date',
            'publication_date_en' => 'nullable|date',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->publicationId = $id;
            $this->loadPublication($id);
        }
    }

    public function loadPublication($id)
    {
        $publication = $this->publicationService->find($id);

        $this->status = $publication->status;
        $this->type = $publication->tipo;
        $this->title = $publication->titulo;
        $this->title_en = $publication->titulo_en;

        $this->pages_count = $publication->numero_paginas ?? '';
        $this->preview = $publication->previsualizacion;

        // Format dates for date picker (handle "YYYY" format from legacy data)
        $this->publication_date = $this->formatDateForPicker($publication->fecha_publicacion);
        $this->publication_date_en = $this->formatDateForPicker($publication->fecha_publicacion_en);
        $this->editorial_coordination = $publication->coordinacion_editorial ?? '';
        $this->editorial_coordination_en = $publication->coordinacion_editorial_en ?? '';
        $this->design = $publication->diseno ?? '';
        $this->design_en = $publication->diseno_en ?? '';
        $this->texts = $publication->textos ?? '';
        $this->texts_en = $publication->textos_en ?? '';
        $this->synopsis = $publication->sinopsis ?? '';
        $this->synopsis_en = $publication->sinopsis_en ?? '';
        $this->additional_content = $publication->additional_content ?? '';
        $this->additional_content_en = $publication->additional_content_en ?? '';

        $this->optional_field_1_title = $publication->campo_opcional_1_titulo ?? '';
        $this->optional_field_1 = $publication->campo_opcional_1 ?? '';
        $this->optional_field_1_en_title = $publication->campo_opcional_1_en_titulo ?? '';
        $this->optional_field_1_en = $publication->campo_opcional_1_en ?? '';

        $this->currentThumbnail = $publication->thumbnail;
        $this->currentMultimedia = $publication->multimedia;

        $this->optional_field_2_title = $publication->campo_opcional_2_titulo ?? '';
        $this->optional_field_2 = $publication->campo_opcional_2 ?? '';
        $this->optional_field_2_en_title = $publication->campo_opcional_2_en_titulo ?? '';
        $this->optional_field_2_en = $publication->campo_opcional_2_en ?? '';

        $this->optional_field_3_title = $publication->campo_opcional_3_titulo ?? '';
        $this->optional_field_3 = $publication->campo_opcional_3 ?? '';
        $this->optional_field_3_en_title = $publication->campo_opcional_3_en_titulo ?? '';
        $this->optional_field_3_en = $publication->campo_opcional_3_en ?? '';

        $this->optional_field_4_title = $publication->campo_opcional_4_titulo ?? '';
        $this->optional_field_4 = $publication->campo_opcional_4 ?? '';
        $this->optional_field_4_en_title = $publication->campo_opcional_4_en_titulo ?? '';
        $this->optional_field_4_en = $publication->campo_opcional_4_en ?? '';

        $this->optional_field_5_title = $publication->campo_opcional_5_titulo ?? '';
        $this->optional_field_5 = $publication->campo_opcional_5 ?? '';
        $this->optional_field_5_en_title = $publication->campo_opcional_5_en_titulo ?? '';
        $this->optional_field_5_en = $publication->campo_opcional_5_en ?? '';

        $this->optional_field_6_title = $publication->campo_opcional_6_titulo ?? '';
        $this->optional_field_6 = $publication->campo_opcional_6 ?? '';
        $this->optional_field_6_en_title = $publication->campo_opcional_6_en_titulo ?? '';
        $this->optional_field_6_en = $publication->campo_opcional_6_en ?? '';

        $this->optional_field_7_title = $publication->campo_opcional_7_titulo ?? '';
        $this->optional_field_7 = $publication->campo_opcional_7 ?? '';
        $this->optional_field_7_en_title = $publication->campo_opcional_7_en_titulo ?? '';
        $this->optional_field_7_en = $publication->campo_opcional_7_en ?? '';

        $this->exhibition_id = $publication->exposicion_id;
        if ($publication->exhibition) {
            $this->exhibitionSearch = strip_tags($publication->exhibition->titulo);
        } else if ($publication->exposicion_id) {
            // Fallback try active record find just in case of newly created separation, though relation name 'exhibition' is used in repo.
            $ex = Exhibition::find($publication->exposicion_id);
            if ($ex) {
                $this->exhibitionSearch = strip_tags($ex->titulo);
            }
        }
    }

    public function searchExhibitions()
    {
        if (strlen($this->exhibitionSearch) < 2) {
            $this->exhibitionSearchResults = [];
            $this->showExhibitionResults = false;
            return;
        }

        // Keep exhibition search as is or move to exhibition service?
        // For simple lookup keeping it here is fine or use Exhibition model directly.
        $this->exhibitionSearchResults = Exhibition::where('titulo', 'like', '%' . $this->exhibitionSearch . '%')
            ->limit(10)
            ->get()
            ->map(function ($exhibition) {
                return [
                    'id' => $exhibition->id,
                    'title' => strip_tags($exhibition->titulo),
                    'type' => $exhibition->type ?? '',
                    'date' => $exhibition->fecha ?? ''
                ];
            })
            ->toArray();

        $this->showExhibitionResults = true;
    }

    public function selectExhibition($exhibitionId, $title)
    {
        $this->exhibition_id = $exhibitionId;
        $this->exhibitionSearch = $title;
        $this->showExhibitionResults = false;
    }

    public function clearExhibition()
    {
        $this->exhibition_id = null;
        $this->exhibitionSearch = '';
        $this->showExhibitionResults = false;
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Flux::toast('Error de validación: Por favor revisa los campos obligatorios.', variant: 'danger');

            // Re-throw to ensure Livewire highlights the fields, but we already toasted.
            throw $e;
        }

        $data = [
            'status' => $this->status,
            'tipo' => $this->type,
            'titulo' => $this->cleanHtmlContent($this->title),
            'titulo_en' => $this->title_en ? $this->cleanHtmlContent($this->title_en) : '',
            'numero_paginas' => $this->pages_count,
            'previsualizacion' => $this->preview,

            'fecha_publicacion' => $this->publication_date,
            'fecha_publicacion_en' => $this->publication_date_en,
            'coordinacion_editorial' => $this->editorial_coordination,
            'coordinacion_editorial_en' => $this->editorial_coordination_en,
            'diseno' => $this->design,
            'diseno_en' => $this->design_en,
            'textos' => $this->texts,
            'textos_en' => $this->texts_en,
            'sinopsis' => $this->cleanHtmlContent($this->synopsis),
            'sinopsis_en' => $this->synopsis_en ? $this->cleanHtmlContent($this->synopsis_en) : '',
            'additional_content' => $this->additional_content ? $this->cleanHtmlContent($this->additional_content) : '',
            'additional_content_en' => $this->additional_content_en ? $this->cleanHtmlContent($this->additional_content_en) : '',

            'campo_opcional_1_titulo' => $this->optional_field_1_title,
            'campo_opcional_1' => $this->optional_field_1,
            'campo_opcional_1_en_titulo' => $this->optional_field_1_en_title,
            'campo_opcional_1_en' => $this->optional_field_1_en,

            'campo_opcional_2_titulo' => $this->optional_field_2_title,
            'campo_opcional_2' => $this->optional_field_2,
            'campo_opcional_2_en_titulo' => $this->optional_field_2_en_title,
            'campo_opcional_2_en' => $this->optional_field_2_en,

            'campo_opcional_3_titulo' => $this->optional_field_3_title,
            'campo_opcional_3' => $this->optional_field_3,
            'campo_opcional_3_en_titulo' => $this->optional_field_3_en_title,
            'campo_opcional_3_en' => $this->optional_field_3_en,

            'campo_opcional_4_titulo' => $this->optional_field_4_title,
            'campo_opcional_4' => $this->optional_field_4,
            'campo_opcional_4_en_titulo' => $this->optional_field_4_en_title,
            'campo_opcional_4_en' => $this->optional_field_4_en,

            'campo_opcional_5_titulo' => $this->optional_field_5_title,
            'campo_opcional_5' => $this->optional_field_5,
            'campo_opcional_5_en_titulo' => $this->optional_field_5_en_title,
            'campo_opcional_5_en' => $this->optional_field_5_en,

            'campo_opcional_6_titulo' => $this->optional_field_6_title,
            'campo_opcional_6' => $this->optional_field_6,
            'campo_opcional_6_en_titulo' => $this->optional_field_6_en_title,
            'campo_opcional_6_en' => $this->optional_field_6_en,

            'campo_opcional_7_titulo' => $this->optional_field_7_title,
            'campo_opcional_7' => $this->optional_field_7,
            'campo_opcional_7_en_titulo' => $this->optional_field_7_en_title,
            'campo_opcional_7_en' => $this->optional_field_7_en,

            'exposicion_id' => $this->exhibition_id,
        ];

        if ($this->publicationId) {

            // Handle file uploads
            if ($this->publication_multimedia) {
                $data['publicacion_multimedia_id'] = $this->publicationService->processFile($this->publication_multimedia, $this->title);
            }

            if ($this->publication_thumbnail) {
                $data['publicacion_thumbnail_id'] = $this->publicationService->processFile($this->publication_thumbnail, $this->title, true);
            }

            try {
                $updated = $this->publicationService->update($this->publicationId, $data);

                if ($updated) {
                    Flux::toast('La publicación ha sido actualizada con éxito', variant: 'success');
                } else {
                    Flux::toast('Error: No se pudo actualizar la publicación en la base de datos', variant: 'danger');
                    return;
                }
            } catch (\Exception $e) {
                Flux::toast('Error al actualizar: ' . $e->getMessage(), variant: 'danger');
                return;
            }
        } else {
            // New publication
            $data['publicacion_multimedia_id'] = $this->publicationService->processFile($this->publication_multimedia, $this->title);
            $data['publicacion_thumbnail_id'] = $this->publicationService->processFile($this->publication_thumbnail, $this->title, true);
            $data['orden'] = Publication::count() + 1;

            try {
                $this->publicationService->create($data);
                Flux::toast('Publication created successfully');
            } catch (\Exception $e) {
                Flux::toast('Error al crear: ' . $e->getMessage(), variant: 'danger');
                return;
            }
        }

        return $this->redirect('/admin/publicaciones', navigate: true);
    }

    /**
     * Remove the current thumbnail
     */
    public function removeThumbnail(): void
    {
        if ($this->publicationId) {
            $publication = $this->publicationService->find($this->publicationId);
            if ($publication && $publication->publicacion_thumbnail_id) {
                // The relationship is defined as hasOne(Multimedia::class, 'id', 'publicacion_thumbnail_id')
                // But usually we just null out the foreign key in the publication.
                // If we want to delete the file too, we should do it in the service.

                $publication->update(['publicacion_thumbnail_id' => null]);
                $this->currentThumbnail = null;
                Flux::toast('Thumbnail eliminado');
            }
        }
    }

    /**
     * Remove the current multimedia file
     */
    public function removeMultimedia(): void
    {
        if ($this->publicationId) {
            $publication = $this->publicationService->find($this->publicationId);
            if ($publication && $publication->publicacion_multimedia_id) {
                $publication->update(['publicacion_multimedia_id' => null]);
                $this->currentMultimedia = null;
                Flux::toast('Archivo eliminado');
            }
        }
    }

    /**
     * Delete the entire publication
     */
    public function deletePublication(): void
    {
        if ($this->publicationId) {
            $publication = $this->publicationService->find($this->publicationId);
            if ($publication) {
                $name = strip_tags($publication->titulo);
                $this->publicationService->delete($this->publicationId);
                Flux::toast("Publicación '$name' eliminada");
                $this->redirect('/admin/publicaciones', navigate: true);
            }
        }
    }

    /**
     * Translate all publication fields at once
     */


    /**
     * Translate all publication fields at once
     */
    public ?string $translationError = null; // Add this property

    // ... (keep existing properties)

    /**
     * Translate all publication fields at once
     */
    public function translateAllFields(): void
    {
        $this->translationError = null; // Reset error

        $fieldsToTranslate = [
            'title' => $this->title,
            'publication_date' => $this->publication_date,
            'editorial_coordination' => $this->editorial_coordination,
            'design' => $this->design,
            'texts' => $this->texts,
            'synopsis' => $this->synopsis,
            'additional_content' => $this->additional_content,
        ];

        // Filter out empty values
        $fieldsToTranslate = array_filter($fieldsToTranslate, fn($value) => !empty($value));

        if (empty($fieldsToTranslate)) {
            Flux::toast('No hay campos en español para traducir', variant: 'warning');
            return;
        }

        try {
            $translator = new GeminiTranslationService();
            $translatedFields = $translator->translateBatch($fieldsToTranslate);

            foreach ($translatedFields as $field => $translatedContent) {
                if ($translatedContent !== null) {
                    $this->{$field . '_en'} = $translatedContent;
                }
            }

            $count = count($fieldsToTranslate);
            Flux::toast(
                heading: 'Traducción completada',
                text: "Se tradujeron {$count} campos correctamente",
                variant: 'success'
            );
        } catch (\Exception $e) {
            \Log::error('Translation error', ['message' => $e->getMessage()]);
            $this->translationError = 'Error de traducción: ' . $e->getMessage(); // Set error property
            Flux::toast(
                heading: 'Error de traducción',
                text: $e->getMessage(),
                variant: 'danger'
            );
        }
    }

    /**
     * Clean HTML content that may have been escaped by the editor
     * Detects and fixes double-escaped HTML entities
     */
    private function cleanHtmlContent(string $content): string
    {
        // Check if content has escaped HTML entities
        if (strpos($content, '&lt;') !== false || strpos($content, '&gt;') !== false) {
            // Decode HTML entities
            $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            // If it's a full HTML document, extract only the body content
            if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $content, $matches)) {
                $content = $matches[1];
            }

            // Remove unnecessary wrapper paragraphs that the editor might add
            $content = preg_replace('/<p>\s*<\/p>/i', '', $content);

            // Clean up any remaining DOCTYPE, html, head tags
            $content = preg_replace('/<!DOCTYPE[^>]*>/i', '', $content);
            $content = preg_replace('/<\/?html[^>]*>/i', '', $content);
            $content = preg_replace('/<head[^>]*>.*?<\/head>/is', '', $content);

            // Trim whitespace
            $content = trim($content);
        }

        return $content;
    }

    /**
     * Format date string for the date picker component
     * Handles legacy "YYYY" format by converting to "YYYY-01-01"
     */
    private function formatDateForPicker(?string $date): string
    {
        if (empty($date)) {
            return '';
        }

        // Check if it's just a year (4 digits)
        if (preg_match('/^\d{4}$/', $date)) {
            return "{$date}-01-01";
        }

        return $date;
    }

    public function render(): View
    {
        return view('livewire.admin.publication.form');
    }
}
