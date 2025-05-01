<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CandidateMessage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
class CandidateMessagingController extends Controller
{
    public function showMessagingForm($candidateId)
    {
        $candidate = DB::table('management_finances')->find($candidateId);
        return view('Concours.Admin.message', compact('candidate'));
    }

   /* public function sendMessage(Request $request, $candidateId)
    {
        $request->validate([
            'message' => 'required|string',
            'send_email' => 'boolean',
            'send_whatsapp' => 'boolean'
        ]);

        $candidate = DB::table('management_finances')->find($candidateId);

        // Envoi par email
        if ($request->send_email) {
            Mail::to($candidate->email)
                ->send(new CandidateMessage($request->message));
        }

        // Envoi par WhatsApp
        if ($request->send_whatsapp && $candidate->telephone) {
            $this->sendWhatsAppMessage($candidate->telephone, $request->message);
        }

        return back()->with('success', 'Message envoyé avec succès!');
    }*/

    private function sendWhatsAppMessage($phone, $message)
    {
        $client = new Client();
        
        // Utilisation de l'API WhatsApp (exemple avec Twilio)
        $response = $client->post('https://api.twilio.com/2010-04-01/Accounts/'.env('TWILIO_SID').'/Messages.json', [
            'form_params' => [
                'From' => 'whatsapp:'.env('TWILIO_WHATSAPP_NUMBER'),
                'To' => 'whatsapp:'.$phone,
                'Body' => $message
            ],
            'auth' => [env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN')]
        ]);

        return $response->getStatusCode() === 201;
    }

    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string'
        ]);
    
        try {
            Mail::to($validated['email'])->send(new CandidateMessage($validated['subject'], $validated['body']));
            
            return back()->with('success', 'Email envoyé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi: '.$e->getMessage());
        }
    }
}
