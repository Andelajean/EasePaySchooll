@component('mail::message')
# Bonjour {{ $candidate->nom }} {{ $candidate->prenom }},

Votre salle d'examen a été attribuée :

**Salle:** {{ $candidate->exam_room }}  
**Place:** {{ $candidate->exam_seat }}

@component('mail::button', ['url' => '#'])
Voir les détails
@endcomponent

Cordialement,  
L'équipe du concours
@endcomponent