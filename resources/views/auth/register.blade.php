<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Créer un nouveau compte</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Autres champs d'inscription ici -->

        <label for="students">Ajouter un étudiant</label>
        <input type="text" id="student-search" class="form-control" placeholder="Rechercher un étudiant...">
        <ul id="student-results" class="list-group mt-2"></ul>

        <input type="hidden" name="students" id="students" />

        <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
    </form>
</div>

<script>
    const studentResults = document.getElementById('student-results');
    const studentSearch = document.getElementById('student-search');
    const selectedStudents = [];

    studentSearch.addEventListener('input', function() {
        const query = this.value;
        if (query.length > 0) {
            fetch(`/search-students?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    studentResults.innerHTML = '';
                    data.forEach(student => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item student-item';
                        li.textContent = student.nom_complet;
                        li.addEventListener('click', () => {
                            selectedStudents.push(student.nom_complet);
                            updateSelectedStudents();
                            studentResults.innerHTML = ''; // Clear results
                        });
                        studentResults.appendChild(li);
                    });
                });
        } else {
            studentResults.innerHTML = '';
        }
    });

    function updateSelectedStudents() {
        const studentsInput = document.getElementById('students');
        studentsInput.value = JSON.stringify(selectedStudents); // Store selected students in hidden input
    }
</script>
@endsection