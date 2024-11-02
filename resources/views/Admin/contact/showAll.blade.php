@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <center><h1>ECOLES NOUS AYANT CONTACTEES</h1></center>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <div class="card-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @isset($contacts)
              @foreach ($contacts as $contact)
              <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->subject }}</td>
                <td>{{ Str::limit($contact->message, 50) }}</td>
                <td>{{ $contact->created_at->diffForHumans() }}</td>
                <td>
                  <ul class="list-inline m-0">
                    <li class="list-inline-item">
                      <button class="btn-reply btn btn-success btn-sm rounded-2" type="button" data-email="{{ $contact->email }}" data-toggle="tooltip" data-placement="top" title="Répondre">Répondre</button>
                    </li>
                    <li class="list-inline-item">
                      <button class="btn-dynamic btn btn-warning btn-sm rounded-2" type="button" data-id="{{ $contact->id }}" data-toggle="tooltip" data-placement="top" title="Marquer comme vue">Marquer comme vue</button>
                    </li>
                  </ul>
                </td>
              </tr>
              @endforeach
              @endisset
            </tbody>
          </table>
      </div>
     <!-- Modale HTML -->
     <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Messages</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="messagesContainer"></div>
                    <textarea id="replyMessage" class="form-control" placeholder="Votre message..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="sendReply">Envoyer</button>
                    <button type="button" class="btn btn-secondary" id="closeModal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

      <!-- Script JavaScript -->
      <script>
        document.getElementById('closeModal').addEventListener('click', function() {
          $('#messageModal').modal('hide');
        });
      </script>

              <!-- /.card-body -->
              <script>
                //methode pour marquer un message comme lue
                   document.querySelectorAll('.btn-dynamic').forEach(button => {
                    button.addEventListener('click', function(event) {
                      event.preventDefault();
                      const contactId = this.getAttribute('data-id');
                      fetch(`/contacts/${contactId}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                      })
                      .then(response => response.json())
                      .then(data => {
                        if (data.success) {
                          this.disabled = true;
                        } else {
                          alert('Erreur lors de la mise à jour du statut.');
                        }
                      });
                    });
                  });
              
                  //methode pour afficher tous les messages envoyer par l'email selectionner
                  document.querySelectorAll('.btn-reply').forEach(button => {
                  button.addEventListener('click', function() {
                    globalThis.email = this.getAttribute('data-email');
                    fetch(`/contacts/messages?email=${email}`, {
                        method: 'GET',
                        headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                      })
                      .then(response => response.json())
                      .then(data => {
                        const messagesContainer = document.getElementById('messagesContainer');
                        messagesContainer.innerHTML = '';
                        data.messages.forEach(message => {
                          messagesContainer.innerHTML += `<p><strong>${message.created_at}:</strong> ${message.message}</p>`;
                        });
                        $('#messageModal').modal('show');
                      });
                  });
                });
                
                function sendEmail() {
                    const email1 =email;
                    var message = document.getElementById('replyMessage').value;

                    fetch('/send-email', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: email1, message: message })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        $('#messageModal').modal('hide');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }

                //permet d'appeler la fonction qui envoit le message des son click
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sendReply').addEventListener('click', sendEmail);
            document.getElementById('closeModal').addEventListener('click', function() {
                $('#messageModal').modal('hide');
            });
        });
    
              
                </script>




@endsection               
