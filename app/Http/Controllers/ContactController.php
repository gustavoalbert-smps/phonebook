<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index() 
    {
        $contacts = Contact::orderBy('name')->get();

        return inertia('Contacts/Index', [
            'contacts' => $contacts
        ]);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return inertia('Contacts/Show', [
            'contact' => $contact
        ]);
    }

    public function store(StoreContactRequest $request)
    {
        $fields = $request->validated();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file =  $request->file('image');
            $name = md5(uniqid($fields['telephone'],true)) . '.' . $file->getClientOriginalExtension();
            $path = "public/images/{$name}";
            $content = file_get_contents($file);

            $uploaded = Storage::disk('s3')->put($path, $content);

            if ($uploaded)
                $fields['image'] = Storage::disk('s3')->url($path);
            else
                $fields['image'] = null;
        }

        Contact::create($fields);

        return redirect()->route('contacts.index');
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $fields = $request->validated();
        $contact = Contact::findOrFail($id);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file =  $request->file('image');
            $name = md5(uniqid($fields['telephone'],true)) . '.' . $file->getClientOriginalExtension();
            $path = "public/images/{$name}";
            $content = file_get_contents($file);

            $uploaded = Storage::disk('s3')->put($path, $content);

            if ($uploaded) {
                $fields['image'] = Storage::disk('s3')->url($path);
                $this->validateImage($contact->image);
            } else {
                $fields['image'] = $contact->image;
            }
        } else {
            unset($fields['image']);
        }

        $contact->update($fields);

        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $contact = Contact::findOrFail($id);

        $this->validateImage($contact->image);

        $contact->delete();

        return redirect()->route('contacts.index');
    }

    public function validateImage($url) 
    {
        if (!empty($url) && strpos($url, 'public/images') !== false) {
            $parsedUrl = parse_url($url);
            $path = ltrim($parsedUrl['path'], '/');

            Storage::disk('s3')->delete($path);
        }
    }
}
