<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GetCountries;
use App\Http\Controllers\Traits\UploadImage;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use GetCountries;
    use UploadImage;
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('announcements.index', [
            'announcements' => $announcements
        ]);
    }

    public function create()
    {
        return view('announcements.create', [
            'countries' => $this->getCountries(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'ann_logo' => 'nullable|image',
            'ann_country' => 'required|string'
        ]);

        $announcement = new Announcement();
        $announcement->text = $request->content;
        $announcement->ann_country = $request->ann_country;
        $announcement->ann_logo = $request->hasFile('ann_logo') ? $this->uploadImage('ann_logo') : null;
        $announcement->save();

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully!');
    }

    public function edit(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcements.edit', [
            'announcement' => $announcement,
            'countries' => $this->getCountries(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'ann_logo' => 'nullable|image',
            'ann_country' => 'required|string'
        ]);

        $announcement = Announcement::find($id);

        if ($announcement->ann_logo and $request->hasFile('ann_logo')) {
            $this->deleteImage($announcement->ann_logo);
            $announcement->ann_logo = null;
        }

        $announcement->text = $request->content;
        $announcement->ann_country = $request->ann_country;
        $announcement->ann_logo = $request->hasFile('ann_logo') ? $this->uploadImage('ann_logo') : $announcement->ann_logo;
        $announcement->save();

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
    }

    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        if ($announcement->ann_logo) {
            $this->deleteImage($announcement->ann_logo);
        }
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully!');
    }
}
