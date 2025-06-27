<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-center text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Bienvenue</h1>

            <div class="flex flex-wrap gap-6 justify-between">
                {{-- Formulaire --}}
                <div class="w-full md:w-[48%] bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Ajouter un hôtel</h2>
                    <form action="{{ route('createhotel') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <label for="nom" class="block mt-4 font-medium">Nom de l'hôtel:</label>
                        <input type="text" name="nom" id="nom" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm" />

                        <label for="categorie" class="block mt-4 font-medium">Catégorie:</label>
                        <select name="categorie" id="categorie" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm">
                            <option value="1 étoile">★☆☆☆☆</option>
                            <option value="2 étoiles">★★☆☆☆</option>
                            <option value="3 étoiles">★★★☆☆</option>
                            <option value="4 étoiles">★★★★☆</option>
                            <option value="5 étoiles">★★★★★</option>
                        </select>

                        <label for="adresse" class="block mt-4 font-medium">Adresse:</label>
                        <input type="text" name="adresse" id="adresse" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm" />

                        <label for="email" class="block mt-4 font-medium">Email:</label>
                        <input type="email" name="email" id="email" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm" />

                        <label for="photos" class="block mt-4 font-medium">Photo de l'hôtel :</label>
                        <input type="file" name="photos" id="photos" accept="image/*"
                               class="mt-1 block w-full text-gray-700 dark:text-gray-100" />

                        <button type="submit"
                                class="mt-6 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                            Ajouter l'hôtel
                        </button>
                    </form>
                </div>

                {{-- Liste des hôtels --}}
                <div class="w-full md:w-[48%] bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Liste des hôtels</h2>

                    @if(isset($hotels) && $hotels->count() > 0)
                        @foreach($hotels as $hotel)
                            <div class="flex gap-4 items-start p-4 border border-gray-200 dark:border-gray-700 rounded-lg mb-4 bg-white dark:bg-gray-900 shadow-sm">
                                @if($hotel->photos)
                                    <img src="{{ asset($hotel->photos) }}" alt="Photo de l'hôtel"
                                         class="w-24 h-24 rounded-lg object-cover bg-gray-100 dark:bg-gray-700" />
                                @else
                                    <div class="w-24 h-24 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-sm text-gray-500">
                                        Pas d'image
                                    </div>
                                @endif

                                <div class="flex-grow" id="hotel-info-{{ $hotel->id }}">
                                    <h3 class="text-lg font-bold">{{ $hotel->nom }}</h3>
                                    <p><strong>Catégorie :</strong> {{ $hotel->categorie }}</p>
                                    <p><strong>Adresse :</strong> {{ $hotel->adresse }}</p>
                                    <p><strong>Email :</strong> {{ $hotel->email }}</p>

                                    <div class="mt-3 flex gap-2">
                                        <button onclick="toggleEditForm({{ $hotel->id }})"
                                                class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm">
                                            Modifier
                                        </button>

                                        <form action="{{ route('supprimerhotel', $hotel->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div id="edit-form-{{ $hotel->id }}" class="w-full mt-4 hidden">
                                    <form action="{{ route('updatehotel', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid gap-2 mt-2">
                                            <input type="text" name="nom" value="{{ $hotel->nom }}" required
                                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                                            <input type="text" name="categorie" value="{{ $hotel->categorie }}" required
                                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                                            <input type="text" name="adresse" value="{{ $hotel->adresse }}" required
                                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                                            <input type="email" name="email" value="{{ $hotel->email }}" required
                                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                                            <input type="file" name="photos"
                                                   class="block w-full text-gray-700 dark:text-gray-100" />

                                            <div class="flex gap-2 mt-2">
                                                <button type="submit"
                                                        class="px-4 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md">
                                                    Enregistrer
                                                </button>
                                                <button type="button" onclick="toggleEditForm({{ $hotel->id }})"
                                                        class="px-4 py-1 bg-gray-500 hover:bg-gray-600 text-white rounded-md">
                                                    Annuler
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">Aucun hôtel enregistré.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEditForm(id) {
            const info = document.getElementById('hotel-info-' + id);
            const form = document.getElementById('edit-form-' + id);

            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                info.classList.add('hidden');
            } else {
                form.classList.add('hidden');
                info.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
