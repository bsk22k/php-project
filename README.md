Aplicația "Gestionarea unui centru de meditații" este o platformă web proiectată pentru a automatiza și centraliza procesele administrative și educaționale ale unui centru de meditații. Scopul principal al aplicației este să faciliteze gestionarea utilizatorilor, cursurilor, profesorilor și materiilor, oferind o interfață intuitivă și funcționalități personalizate atât pentru administratori, cât și pentru utilizatori.

Funcționalitățile principale implementate:
-Sistem de autentificare diferențiat:
-Autentificare separată pentru administratori și utilizatori.
-Verificarea sesiunilor pentru a permite accesul doar utilizatorilor autentificați.
-Gestionarea utilizatorilor:
-Administratorii pot adăuga, edita, șterge și vizualiza informații despre studenți și profesori.
-Gestionarea cursurilor:
-Adăugarea de cursuri cu detalii precum materie, profesor, zilele de desfășurare, orele și perioada.
-Selectarea elevilor care participă la curs.
-Gestionarea materiilor:
-Funcții complete pentru adăugarea, editarea, ștergerea și listarea materiilor.
-Gestionarea profesorilor:
-Administrarea informațiilor despre profesori, inclusiv atribuirea lor la materii specifice.
-Vizualizarea orarului:
-Utilizatorii autentificați pot vizualiza orarul cursurilor disponibile, cu detalii despre profesori și materii.
-Funcționalități AJAX:
-Încărcarea dinamică a profesorilor disponibili în funcție de materia selectată.
-Posibilitatea deconectării pentru a încheia sesiunea utilizatorului în siguranță.
Bază de date relațională:
Stocarea datelor într-o bază de date MySQL bine structurată, cu tabele interconectate pentru cursuri, profesori, materii și elevi.

1. Instalare
Descărcare proiect:
Descarcă fișierele aplicației și baza de date asociată (baza_de_date.sql).
Setare server local:
Instalează un server web local (ex.: XAMPP, WAMP sau Laragon).
Plasează toate fișierele proiectului în directorul rădăcină al serverului (ex.: htdocs pentru XAMPP).
2. Configurare
Importare bază de date:
Accesează phpMyAdmin (sau altă interfață pentru gestionarea MySQL).
Creează o bază de date nouă (ex.: centru_meditatii).
Importă fișierul baza_de_date.sql în baza de date creată.
Configurare conexiune la baza de date:
Deschide fișierul config/db.php.
Actualizează următorii parametri în funcție de setările serverului local:
php
Copiază codul
$servername = "localhost";
$username = "root"; // sau alt utilizator al serverului
$password = ""; // parola utilizatorului
$dbname = "centru_meditatii"; // numele bazei de date
3. Utilizare
Accesarea aplicației:
În browser, accesează http://localhost/index.html.
CONT ADMIN( USERNAME: ADMIN ; PASSWORD: PAROLA123)
CONT USER ( USERNAME: USER; PASSWORD: USER123)

În cadrul proiectului, există o funcționalitate asemănătoare unui API utilizată pentru încărcarea dinamică a profesorilor în funcție de materia selectată. Aceasta este implementată în fișierul add_course.php și utilizează o cerere AJAX pentru a comunica cu serverul.

Tehnologii utilizate
Front-end:
HTML: Structura paginilor web.
CSS: Design și stilizare pentru o interfață modernă.
JavaScript:
Funcționalități interactive.
AJAX pentru încărcarea dinamică a datelor fără reîncărcarea paginii.

Back-end:
PHP: Logică de server, gestionarea operațiunilor și comunicarea cu baza de date.
Sesiuni PHP: Securizarea accesului utilizatorilor autentificați.
Bază de date:

MySQL:
Gestionarea datelor prin tabele relaționale.
Relații între entități precum cursuri, profesori, materii și elevi.
Integrare AJAX:

Folosită pentru a crea interacțiuni dinamice și a evita reîncărcările complete ale paginii (ex. încărcarea profesorilor în funcție de materie).
Server local:
Dezvoltare și testare pe un mediu precum XAMPP sau WAMP, pentru rularea aplicației PHP și gestionarea bazei de date MySQL.

Elemente cheie ale complexității
Modularitatea proiectului (fișiere separate pentru fiecare funcționalitate).
Integrarea unei baze de date relaționale bine structurate.
Funcționalități dinamice și interactive prin AJAX.
Securizarea accesului prin sesiuni.

Deși proiectul nu are un API formal implementat, există o funcționalitate specifică în fișierul add_course.php care poate fi considerată o formă simplă de API, utilizată pentru încărcarea dinamică a profesorilor pe baza materiei selectate. Mai jos este o documentație structurată pentru această funcționalitate:

Endpoint: add_course.php
1. Descriere
Acest endpoint returnează o listă de profesori disponibili pentru o materie selectată, identificată prin subject_id. Rezultatul este trimis sub formă de opțiuni HTML.

2. Metodă HTTP
GET
3. Parametri
Nume	Tip	Obligatoriu	Descriere
subject_id	int	Da	ID-ul materiei pentru care se caută profesorii.
4. Răspuns
Tip răspuns: HTML (listă de <option> pentru dropdown).
Exemplu răspuns cu date valide:
html
Copiază codul
<option value="1">Profesor 1</option>
<option value="2">Profesor 2</option>
Exemplu răspuns fără date disponibile:
html
Copiază codul
<option value="">Nu există profesori disponibili</option>
5. Exemplu cerere
URL:

arduino
Copiază codul
http://localhost/add_course.php?subject_id=3
Descriere: Returnează profesorii asociați materiei cu ID-ul 3.

6. Exemplu utilizare AJAX (Client-Side)
javascript
Copiază codul
function loadTeachers() {
    const subjectId = document.getElementById("subject_id").value;
    const teacherDropdown = document.getElementById("teacher_id");

    if (subjectId) {
        fetch(`add_course.php?subject_id=${subjectId}`)
            .then(response => response.text())
            .then(data => {
                teacherDropdown.innerHTML = data;
            })
            .catch(error => console.error("Eroare la încărcarea profesorilor:", error));
    } else {
        teacherDropdown.innerHTML = '<option value="">Selectează Profesorul</option>';
    }
}
7. Limitări și posibile îmbunătățiri
Tipul de răspuns: În prezent, răspunsul este în format HTML. Pentru a face funcționalitatea mai versatilă, se poate implementa un răspuns în format JSON.
Securitate: Endpoint-ul nu implementează validarea avansată pentru subject_id. Ar fi recomandat să se utilizeze metode pregătite (prepared statements) pentru a preveni SQL Injection.
