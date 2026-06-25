<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\ContactMessage;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request, $slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['sometimes', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $contact = ContactMessage::create([
            'portfolio_id' => $portfolio->id,
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject ?? 'New message from portfolio',
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Send notification email to portfolio owner
        $about = $portfolio->about;
        if ($about && $about->email) {
            Mail::to($about->email)->send(new ContactFormMail($contact));
        }

        return response()->json([
            'message' => 'Message sent successfully',
            'id' => $contact->id,
        ], 201);
    }

    public function getMessages(Request $request)
    {
        $portfolio = auth()->user()->portfolio;
        $messages = $portfolio->contactMessages()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($messages);
    }

    public function markAsRead($id)
    {
        $message = auth()->user()->portfolio->contactMessages()->findOrFail($id);
        $message->update(['is_read' => true]);

        return response()->json($message);
    }

    public function deleteMessage($id)
    {
        auth()->user()->portfolio->contactMessages()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
