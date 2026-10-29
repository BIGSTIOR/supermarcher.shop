<x-layouts.app>
    <x-slot:title>Assistant client | Supermarché</x-slot:title>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <h1 class="fw-bold mb-3">Assistant client</h1>
                        <p class="text-body-secondary">Posez une question sur les commandes, les livraisons, les paiements ou le stock.</p>

                        <div id="chatBox" class="border rounded-3 p-3 mb-3 bg-light-subtle" style="min-height: 220px; max-height: 330px; overflow-y: auto;">
                            <div class="mb-2">
                                <div class="d-inline-block bg-success text-white px-3 py-2 rounded-3">Bonjour ! Je peux vous aider sur les commandes, les paiements et les livraisons.</div>
                            </div>
                        </div>

                        <form id="chatForm">
                            @csrf
                            <div class="input-group">
                                <input id="chatInput" type="text" class="form-control" placeholder="Tapez votre question..." aria-label="Question" required>
                                <button class="btn btn-success" type="submit">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const chatForm = document.getElementById('chatForm');
        const chatBox = document.getElementById('chatBox');
        const chatInput = document.getElementById('chatInput');

        chatForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            chatBox.insertAdjacentHTML('beforeend', `
                <div class="mb-2 text-end">
                    <div class="d-inline-block bg-dark text-white px-3 py-2 rounded-3">${message}</div>
                </div>
            `);
            chatInput.value = '';

            const response = await fetch('{{ route('assistant.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            chatBox.insertAdjacentHTML('beforeend', `
                <div class="mb-2">
                    <div class="d-inline-block bg-success-subtle text-success-emphasis px-3 py-2 rounded-3">${data.answer}</div>
                </div>
            `);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
</x-layouts.app>
