@if(Auth::user() == null)
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">{{$business_name}} </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('auth/login')}}">Login</a></li>
                <!--<li><a href="{{url('auth/register')}}">Sign Up</a></li>-->
          </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

@elseif(Auth::user()->role_id == config('constants.admin'))
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">{{$business_name}} </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('admin/user/new')}}">Nuevo</a></li>
                        <li class="divider"></li>
                       <!-- <li><a href="{{url('admin/promoter')}}">Promotores de ventas</a></li>-->
                        <li><a href="{{url('admin/admin')}}">Administradores</a></li>
                        <li><a href="{{url('admin/portmanager')}}">Gestores de Portafolio</a></li>
                        <li><a href="{{url('admin/riskmanager')}}">Gestores de Riesgos</a></li>
                        <li><a href="{{url('admin/projectManager')}}">Gestor de Proyecto</a></li>
                        <li><a href="{{url('admin/analist')}}">Analistas</a></li>
                    </ul>
                </li>
               <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">EDT Riesgos<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('admin/rbs')}}">Listar</a></li>
                        <li><a href="{{url('admin/rbs/new')}}">Nuevo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Distribuciones<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('admin/distribution')}}">Listar</a></li>
                        <li><a href="{{url('admin/distribution/new')}}">Nuevo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Variables<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('admin/variable')}}">Listar</a></li>
                        <li><a href="{{url('admin/variable/new')}}">Nuevo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Iteraciones<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('admin/iteration')}}">Listar</a></li>
                        <li><a href="{{url('admin/iteration/new')}}">Nuevo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Checklist<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('admin/checklistItems')}}">Listar</a></li>
                        <li><a href="{{url('admin/checklistItems/new')}}">Nuevo</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuración  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('admin/config/system')}}">Sistema</a></li>
                    </ul>
                </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('admin/')}}">{{ Auth::user()->name }}</a></li>
                <li><a href="{{url('auth/logout')}}">Salir</a></li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
@elseif(Auth::user()->role_id == config('constants.analist'))
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">{{$business_name}} </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Mis Proyectos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('analist/activity/subactivities')}}">Historico</a></li>
                    </ul>
                </li>           
             </ul>
             <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Riesgos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('analist/taskrisk/subrisks')}}">Listar</a></li>
                    </ul>
                </li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('analist/')}}">{{ Auth::user()->name }}</a></li>
                <li><a href="{{url('auth/logout')}}">Salir</a></li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
@elseif(Auth::user()->role_id == config('constants.riskmanager'))
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">{{$business_name}} </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogo de Riesgos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('riskmanager/risktask')}}">Listar</a></li>
                        <li><a href="{{url('riskmanager/risktask/new')}}">Nuevo</a></li>
                    </ul>
                    
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Impacto <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('riskmanager/impact')}}">Listar</a></li>
                        <li><a href="{{url('riskmanager/impact/new')}}">Nuevo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Probabilidad <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('riskmanager/probability')}}">Listar</a></li>
                        <li><a href="{{url('riskmanager/probability/new')}}">Nuevo</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Niveles de Riesgo <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('riskmanager/risklevel')}}">Listar</a></li>
                        <li><a href="{{url('riskmanager/risklevel/new')}}">Nuevo</a></li>
                    </ul>
                </li>
            </ul>
          
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('riskmanager/')}}">{{ Auth::user()->name }}</a></li>
                <li><a href="{{url('auth/logout')}}">Salir</a></li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
@elseif(Auth::user()->role_id == config('constants.projectManager'))
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">{{$business_name}} </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Mis Proyectos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('projectManager/projects')}}">Historico</a></li>
                        <li><a href="{{url('projectManager/projects/new')}}">Nuevo Proyecto</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogo de Riesgos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('projectManager/task')}}">Listar</a></li>
                        <li><a href="{{url('projectManager/task/new')}}">Nuevo</a></li>
                        <li><a href="{{url('projectManager/issuelog')}}">Issue Log</a></li>
                    </ul>
                    
                </li>           
             </ul>
            
           
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('projectManager/')}}">{{ Auth::user()->name }}</a></li>
                <li><a href="{{url('auth/logout')}}">Salir</a></li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
@elseif(Auth::user()->role_id == config('constants.portmanager'))
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">


            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">{{$business_name}} </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Mis Proyectos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('portmanager/project')}}">Historico</a></li>
                        <li><a href="{{url('portmanager/project/new')}}">Nuevo Proyecto</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogo de Riesgos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('portmanager/itemrisk')}}">Listar</a></li>
                        <li><a href="{{url('portmanager/itemrisk/new')}}">Nuevo</a></li>
                    </ul>
                    
                </li>           
             </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('portmanager/')}}">{{ Auth::user()->name }}</a></li>
                <li><a href="{{url('auth/logout')}}">Salir</a></li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
@endif
