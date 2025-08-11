<x-app-layout>
    @slot('title', 'Editar nota')
    <x-header/>

    <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 600px; width: 100%;">
        <h2 class="bold">Editar nota: ???</h2>
        <div class="rounded p-4">
            <div>
                <div class="border rounded p-3 bg-white">
                    <form class="form-control d-flex justify-content-center align-items-center flex-column p-4">
                        <h5 class="text-center fs-2"><strong>Editar</strong></h5>
                        <strong class="p-2 fs-4">Valor atual da nota: ???</strong>
                        <label class="form-control mt-3">Insira o novo valor da nota</label>
                        <input type="text" class="form-control mt-2" placeholder="Novo valor"/>
                        <input type="submit" value="Editar" class="btn btn-primary btn-lg mt-4">
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>