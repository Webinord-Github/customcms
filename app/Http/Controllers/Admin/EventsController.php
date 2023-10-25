<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function events()
    {
        return view('admin.events.index', ['events' => Event::all()]);
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'nb_places' => ['required', 'integer'],
            'start_at' => ['required'],
            'end_at' => ['required'],
        ]);

        $event = new Event();

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->nb_places = $request->nb_places;
        $event->start_at = $request->start_at;
        $event->end_at = $request->end_at;

        $image_ext =  $request->image->extension();
        $image_name = strtolower(preg_replace("/\s+/", "", $request->title));
        $image_fullname = $image_name . '.' . $image_ext;
        Storage::putFileAs('public/img/events', $request->image, $image_name . '.' . $image_ext);
        $event->image = $image_fullname;

        $event->save();

        return redirect('/admin/events')->with('status', "$event->title was created.");
    }

    public function update($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.index', ['events' => $event]);
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],
            'nb_places' => ['required', 'integer'],
            'start_at' => ['required'],
            'end_at' => ['required'],
        ]);

        $event = Event::find($request->id);

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->nb_places = $request->nb_places;
        $event->start_at = $request->start_at;
        $event->end_at = $request->end_at;

        $image_name = strtolower(preg_replace("/\s+/", "", $request->title));
        if ($request->image != null) {
            Storage::delete('public/img/events/' . $event->image);
            $image_ext =  $request->image->extension();
            $image_fullname = $image_name . '.' . $image_ext;
            Storage::putFileAs('public/img/events', $request->image, $image_fullname);
        } else {
            $image_ext = pathinfo(storage_path('public/img/events/' . $event->image), PATHINFO_EXTENSION);
            $image_fullname = $image_name . '.' . $image_ext;
            Storage::move('public/img/posts/' . $event->image, 'public/img/events/' . $image_name . '.' . $image_ext);
        }
        $event->image = $image_fullname;

        $event->save();

        return redirect('/admin/events')->with('status', "$event->title was edited.");
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        Event::destroy($id);

        return redirect('/admin/events')->with('status', "$event->title was deleted.");
    }
}
