<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bienvenue sur Laravel</title>

    <style>
        body {
            background-color: #f3f4f6;
            color: #1f2937;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 2rem;
            padding-top: 6rem; /* espace pour la navbar */
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #1f2937;
            padding: 1rem 1rem;
            color: white;

            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;

            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            z-index: 1000;
        }

        nav > div:first-child {
            justify-self: start;
            font-size: 1.25rem;
            font-weight: bold;
        }

        nav > div:last-child {
            display: flex;
            justify-content: center; /* centre horizontalement les liens */
            gap: 1rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 0;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .form-section, .list-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 48%;
            box-sizing: border-box;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            width: 100%;
        }

        label {
            display: block;
            margin-top: 1rem;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.3rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 1.5rem;
            padding: 0.6rem 1.2rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2563eb;
        }

        .hotel-card {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .hotel-image {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 14px;
        }

        .hotel-info {
            flex-grow: 1;
            text-align: left;
        }

        .hotel-info h3 {
            margin: 0 0 8px 0;
        }

        .hotel-info p {
            margin: 4px 0;
        }

        footer {
            text-align: center;
            margin-top: 3rem;
            font-size: 0.875rem;
            color: #9ca3af;
            width: 100%;
        }

        @media(max-width: 768px) {
            .form-section, .list-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav>
        <div>
             Stage_app
        </div>
        <div>
            <a href="#">yyyyyyyyy</a>
            <a href="#">yyyyyyyyy</a>
            <a href="#">yyyyyyyyy</a>
            <a href="#">yyyyyyyyy</a>
        </div>
    </nav>

    <h1>Bienvenue</h1>

    <div class="container">
        {{-- Formulaire --}}
        <div class="form-section">
            <h2>Ajouter un hôtel</h2>
            <form action="{{ route('createhotel') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label for="nom">Nom de l'hôtel:</label>
                <input type="text" name="nom" id="nom" required />

                <label for="categorie">Catégorie:</label>
                    <select name="categorie" id="categorie" required>
                        <<option value="1 étoile">★☆☆☆☆</option>
                        <option value="2 étoiles">★★☆☆☆</option>
                        <option value="3 étoiles">★★★☆☆</option>
                        <option value="4 étoiles">★★★★☆</option>
                        <option value="5 étoiles">★★★★★</option>
                    </select>
                <label for="adresse">Adresse:</label>
                <input type="text" name="adresse" id="adresse" required />

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required />

                <label for="photos">Photo de l'hôtel :</label>
                <input type="file" name="photos" id="photos" accept="image/*" />

                <button type="submit">Ajouter l'hôtel</button>
            </form>
        </div>

        {{-- Liste hôtels --}}
        <div class="list-section">
            <h2>Liste des hôtels</h2>

            @if(isset($hotels) && $hotels->count() > 0)
                @foreach($hotels as $hotel)
                    <div class="hotel-card" id="hotel-card-{{ $hotel->id }}">
                        @if($hotel->photos)
                            <img src="{{ asset($hotel->photos) }}" alt="Photo de l'hôtel" class="hotel-image" />
                        @else
                            <div class="hotel-image">Pas d'image</div>
                        @endif

                        <div class="hotel-info" id="hotel-info-{{ $hotel->id }}">
                            <h3>{{ $hotel->nom }}</h3>
                            <p><strong>Catégorie :</strong> {{ $hotel->categorie }}</p>
                            <p><strong>Adresse :</strong> {{ $hotel->adresse }}</p>
                            <p><strong>Email :</strong> {{ $hotel->email }}</p>

                            <div style="margin-top: 10px;">
                                <button onclick="toggleEditForm({{ $hotel->id }})"
                                    style="margin-right: 8px; padding: 6px 12px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                    Modifier
                                </button>

                                <form action="{{ route('supprimerhotel', $hotel->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Confirmer la suppression ?')"
                                        style="padding: 6px 12px; background-color: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Formulaire caché pour modification --}}
                        <div class="hotel-edit-form" id="edit-form-{{ $hotel->id }}" style="display: none;">
                            <form action="{{ route('updatehotel', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="text" name="nom" value="{{ $hotel->nom }}" required><br>
                                <input type="text" name="categorie" value="{{ $hotel->categorie }}" required><br>
                                <input type="text" name="adresse" value="{{ $hotel->adresse }}" required><br>
                                <input type="email" name="email" value="{{ $hotel->email }}" required><br>
                                <input type="file" name="photos"><br>

                                <button type="submit"
                                    style="margin-top: 8px; background-color: #10b981; color: white; padding: 6px 12px; border: none; border-radius: 4px;">
                                    Enregistrer
                                </button>

                                <button type="button" onclick="toggleEditForm({{ $hotel->id }})"
                                    style="margin-left: 8px; background-color: #6b7280; color: white; padding: 6px 12px; border: none; border-radius: 4px;">
                                    Annuler
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Aucun hôtel enregistré.</p>
            @endif
        </div>
    </div>

    <footer>
        Achraf
    </footer>

    <script>
        function toggleEditForm(id) {
            const info = document.getElementById('hotel-info-' + id);
            const form = document.getElementById('edit-form-' + id);

            if (form.style.display === 'none') {
                form.style.display = 'block';
                info.style.display = 'none';
            } else {
                form.style.display = 'none';
                info.style.display = 'block';
            }
        }
    </script>

</body>
</html>
