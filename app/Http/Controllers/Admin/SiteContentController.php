<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiteContentController extends Controller
{
    private array $sections = [
        'hero' => 'Hero / Beranda',
        'about' => 'Tentang',
        'service' => 'Layanan',
        'document' => 'Dokumen',
        'contact' => 'Kontak',
    ];

    public function index()
    {
        $contents = SiteContent::orderBy('section')->orderBy('sort_order')->latest()->get();

        return view('admin.site-content.index', [
            'contents' => $contents,
            'sections' => $this->sections,
        ]);
    }

    public function create()
    {
        return view('admin.site-content.create', [
            'sections' => $this->sections,
            'content' => new SiteContent([
                'section' => 'service',
                'sort_order' => 0,
                'is_active' => true,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('web-content', 'public');
        }

        $content = SiteContent::create($data);

        ActivityLog::record('create', 'edit-web', $content, [], $content->toArray());

        return redirect()->route('admin.site-content.index')->with('success', 'Konten frontend berhasil ditambahkan.');
    }

    public function edit(SiteContent $siteContent)
    {
        return view('admin.site-content.edit', [
            'sections' => $this->sections,
            'content' => $siteContent,
        ]);
    }

    public function update(Request $request, SiteContent $siteContent)
    {
        $before = $siteContent->toArray();
        $data = $this->validatedData($request, $siteContent);

        if ($request->boolean('remove_image')) {
            $this->deleteImage($siteContent->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image_path')) {
            $this->deleteImage($siteContent->image_path);
            $data['image_path'] = $request->file('image_path')->store('web-content', 'public');
        }

        $siteContent->update($data);

        ActivityLog::record('update', 'edit-web', $siteContent, $before, $siteContent->fresh()->toArray());

        return redirect()->route('admin.site-content.index')->with('success', 'Konten frontend berhasil diperbarui.');
    }

    public function destroy(SiteContent $siteContent)
    {
        ActivityLog::record('delete', 'edit-web', $siteContent, $siteContent->toArray());

        $this->deleteImage($siteContent->image_path);
        $siteContent->delete();

        return redirect()->route('admin.site-content.index')->with('success', 'Konten frontend berhasil dihapus.');
    }

    private function validatedData(Request $request, ?SiteContent $siteContent = null): array
    {
        $data = $request->validate([
            'section' => ['required', Rule::in(array_keys($this->sections))],
            'key' => ['required', 'string', 'max:120', Rule::unique('site_contents', 'key')->ignore($siteContent)],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'button_label' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
