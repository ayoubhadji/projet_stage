<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Bienvenue!') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Messages succès --}}
        @if(session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Messages erreurs --}}
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-xl font-semibold mb-4 text-white">Liste des hôtels</h2>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            @if(isset($hotels) && $hotels->count() > 0)
                @foreach($hotels as $hotel)
                    <div class="max-w-5xl mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden mb-8 flex flex-col md:flex-row items-center">
                        {{-- Image large à gauche --}}
                        @if($hotel->photos)
                            <img src="{{ asset($hotel->photos) }}" alt="Photo de l'hôtel"
                                class="w-full md:w-96 h-56 md:h-auto object-cover md:ml-6" />
                        @else
                            <div class="w-full md:w-96 h-56 md:h-auto bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 text-sm">
                                Pas d'image
                            </div>
                        @endif

                        {{-- Informations à droite, texte centré --}}
                        <div class="p-6 flex flex-col justify-between flex-grow text-center">
                            <div>
                                <h3 class="text-3xl font-semibold mb-3 text-gray-900 dark:text-white">{{ $hotel->nom }}</h3>
                                <p class="mb-2 text-gray-700 dark:text-gray-300"><strong>Catégorie :</strong> {{ $hotel->categorie }}</p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300"><strong>Adresse :</strong> {{ $hotel->adresse }}</p>
                                <p class="mb-2 text-gray-700 dark:text-gray-300"><strong>Email :</strong> {{ $hotel->email }}</p>
                            </div>

                            <div class="mt-4">
                                <a href="#"
                                   class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-md shadow transition reserver-btn"
                                   data-hotel-id="{{ $hotel->id }}">
                                    Réserver
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-sm text-gray-400">Aucun hôtel enregistré.</p>
            @endif
        </div>
    </div>

    <!-- Modal Réservation -->
    <div id="reservationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Réserver cet hôtel</h2>
            <form id="reservationForm" method="POST" action="{{ route('createReservation') }}">
                @csrf
                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                <input type="hidden" name="id_hotel" id="modal_hotel_id" value="">

                <label for="date_arrivee" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Date d'arrivée</label>
                <input type="date" name="date_arrivee" id="date_arrivee" required class="w-full mb-4 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white">

                <label for="date_depart" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Date de départ</label>
                <input type="date" name="date_depart" id="date_depart" required class="w-full mb-4 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white">

                <label for="nombre_de_personne" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nombre de personnes</label>
                <input type="number" name="nombre_de_personne" id="nombre_de_personne" min="1" required class="w-full mb-6 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white">

                <div class="flex justify-end space-x-4">
                    <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Confirmer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-hide success message after 3 seconds
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.remove();
                }, 500); // Wait for fade out animation to complete
            }, 3000); // 3 seconds
        }

        const modal = document.getElementById('reservationModal');
        const modalHotelIdInput = document.getElementById('modal_hotel_id');
        const cancelBtn = document.getElementById('cancelBtn');

        // Tous les boutons "Réserver"
        const reserverBtns = document.querySelectorAll('.reserver-btn');

        reserverBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const hotelId = this.getAttribute('data-hotel-id');

                // Remplir le champ caché id_hotel dans le modal
                modalHotelIdInput.value = hotelId;

                // Afficher le modal
                modal.classList.remove('hidden');
            });
        });

        // Bouton annuler ferme le modal
        cancelBtn.addEventListener('click', function () {
            modal.classList.add('hidden');
            // reset form
            document.getElementById('reservationForm').reset();
        });

        // Fermer modal si clic hors contenu
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.getElementById('reservationForm').reset();
            }
        });
    });
    </script>
</x-app-layout>
