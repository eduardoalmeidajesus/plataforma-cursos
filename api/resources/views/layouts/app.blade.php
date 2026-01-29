<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Plataforma de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #fd7e14;
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding-top: 56px;
        }
        
        .navbar-custom {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - 56px);
            position: fixed;
            left: 0;
            top: 56px;
            background-color: white;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-collapsed {
            left: calc(-1 * var(--sidebar-width));
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
            transition: all 0.2s;
        }
        
        .sidebar-menu li a {
            color: #333;
            text-decoration: none;
            display: block;
        }
        
        .sidebar-menu li:hover {
            background-color: rgba(253, 126, 20, 0.05);
        }
        
        .sidebar-menu li.active {
            background-color: rgba(253, 126, 20, 0.1);
            border-left: 3px solid var(--primary-color);
        }
        
        .sidebar-menu li.active a {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
        }
        
        .content-expanded {
            margin-left: 0;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 1rem;
            border-top: 3px solid var(--primary-color);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-body i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .welcome-section {
            background: linear-gradient(135deg, rgba(253,126,20,0.1) 0%, rgba(255,255,255,1) 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button class="btn btn-link text-white d-lg-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Plataforma de Cursos</a>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                                @auth
                                    {{ Auth::user()->name }} 
                                @else
                                    Visitante
                                @endauth
                            </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li class="{{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-door me-2"></i> Página Inicial</a>
            </li>
            <li class="{{ request()->is('vendas*') ? 'active' : '' }}">
                <a href="{{ route('vendas.index') }}"><i class="bi bi-cart me-2"></i> Vendas</a>
            </li>
            <li class="{{ request()->is('clientes*') ? 'active' : '' }}">
                <a href="{{ route('clientes.index') }}"><i class="bi bi-people me-2"></i> Clientes</a>
            </li>
            <li class="{{ request()->is('cursos*') ? 'active' : '' }}">
                <a href="{{ route('cursos.index') }}"><i class="bi bi-journal-code me-2"></i> Cursos</a>
            </li>
            <li class="{{ request()->is('categorias*') ? 'active' : '' }}">
                <a href="{{ route('categorias.index') }}"><i class="bi bi-tags me-2"></i> Categorias</a>
            </li>
            <li class="{{ request()->is('professores*') ? 'active' : '' }}">
                <a href="{{ route('professores.index') }}"><i class="bi bi-person-badge me-2"></i> Professores</a>
            </li>
            <li class="{{ request()->is('relatorios*') ? 'active' : '' }}">
                <a href="{{ route('relatorios.index') }}"><i class="bi bi-bar-chart me-2"></i> Relatórios</a>
            </li>
        </ul>
    </aside>
    
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        // Quando o botão for clicado, alterna a classe selecionada no menu lateral
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        
        // Para cada item do menu lateral, adiciona um evento de clique
        document.querySelectorAll('.sidebar-menu li a').forEach(item => {
            item.addEventListener('click', function() {
            });
        });
    </script>
</body>
</html>