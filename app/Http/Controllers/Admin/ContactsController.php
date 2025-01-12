<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\EcoleMail;
use App\Models\Contact;
use App\Models\Ecole;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    //

    public function showAllContact()
    {
        $contacts = Contact::where('lue',false)->get();
        $ecoles=Ecole::all();
        return view('Admin.contact.showAll',compact('contacts','ecoles'));
    }


    public function ecolecontactadmin()
    {
        $ecoles=Ecole::all();
        return view('Ecole.contactadmin',compact('ecoles'));
    }

    public function contactadmin(Request $request)
{
    try {
        $Contact = new Contact;
        $Contact->name = $request->input('name');
        $Contact->email = $request->input('email');
        $Contact->subject = $request->input('subject');
        $Contact->message = $request->input('message');
        $Contact->save();

        return response()->json(['message' => 'OK'], 200);
    } catch (\Exception $ex) {
        return response()->json(['error' => $ex->getMessage()], 500);
    }
}


  public function contactecole(Request $request)
  {
    try {
        $Contact = new Contact;
        $Contact->name = $request->input('name');
        $Contact->email = $request->input('email');
        $Contact->subject = $request->input('subject');
        $Contact->message = $request->input('message');
        $Contact->save();

        return response()->json(['message' => 'OK'], 200);
    } catch (\Exception $ex) {
        return response()->json(['error' => $ex->getMessage()], 500);
    }
  }


  public function markAsRead(Request $request, $id)
  {
      $contact = Contact::find($id);
      if ($contact) {
          $contact->lue = true;
          $contact->save();
          return response()->json(['success' => true]);
      }
      return response()->json(['success' => false], 404);
  }

  public function getMessages(Request $request)
  {
      $email = $request->query('email');
      $messages = Contact::where('email', $email)->get(['created_at', 'message']);
      return response()->json(['messages' => $messages]);
  }

  public $ecole;
  public function sendReply(Request $request)
  {
      $email = $request->input('email');
      $message = $request->input('message');
      // Logique pour envoyer le message (par exemple, via email)
      
      Mail::to($email)->send((new EcoleMail($ecole))->mailuserreply($message,$email));
      return response()->json(['success' => true]);
  }

}
