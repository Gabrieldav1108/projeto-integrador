<div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <div class="justify-content-space-between d-flex">
                <a href={{route('homeTeacher')}} class="navbar-brand ml-lg-3">
                    <h1 class="m-0 text-uppercase text-primary ml-5"><i class="fa fa-book-reader me-3"></i>Aprende+</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href={{route('homeTeacher')}} class="nav-item nav-link active">Minhas turmas</a>
                        <a href={{route('schedules')}} class="nav-item nav-link">Horários</a>
                        <a href={{route('profile')}} class="nav-item nav-link">Perfil</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>