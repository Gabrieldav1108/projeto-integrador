<x-app-layout>
    @slot('title', 'Adicionar informações')

    <x-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações sobre a turma: ???</h2>
        
        <div class="row d-flex gap-4 p-4">
            <!-- Formulário -->
            <div class="col-12 col-md-5">
                <div class="border rounded p-3 bg-white h-100">
                    <form class="w-100 d-flex flex-column">
                        <h5 class="text-center"><strong>Adicionar</strong></h5>
                        <p class="text-center">Escreva abaixo as informações ou avisos para a turma ???</p>
                        
                        <label class="form-label" for="content">Digite o aviso</label>
                        <input type="text" class="form-control" name="content" id="content" placeholder="Digite aqui!">

                        <label class="form-label mt-2" for="date">Digite uma data (se tiver)</label>
                        <input type="date" class="form-control" name="date" id="date">

                        <label class="form-label mt-2" for="time">Digite um horário (se tiver)</label>
                        <input type="time" class="form-control" name="time" id="time">
                        
                        <input type="submit" value="Adicionar" class="btn btn-primary btn-sm align-self-center mt-3">
                    </form>
                </div>
            </div>

            <!-- Informações atuais -->
            <div class="col-12 col-md-6">
                <div class="border rounded p-3 bg-light h-100 d-flex flex-column">
                    <h5 class="text-center mb-3">Informações atuais</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Prova de matemática - 10/07</li>
                        <li class="list-group-item">Entrega do trabalho de história - 15/07</li>
                        <li class="list-group-item">Apresentação de ciências - 20/07</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
