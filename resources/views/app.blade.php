<? 
use App\domain\User;
use App\domain\Menu;
?>

<?
$menu = Menu::getMenuByPerfil(User::getInstance()->getPerfilId());
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CFJ - Administraci&oacute;n</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
    <!--link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"-->

    <!-- MetisMenu CSS -->
    <link href="{{ asset('/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!--link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet"-->

    <!-- Timeline CSS -->
    <link href="{{ asset('/dist/css/timeline.css') }}" rel="stylesheet">
    <!--link href="../dist/css/timeline.css" rel="stylesheet"-->

    <!-- Custom CSS -->
    <link href="{{ asset('/dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!--link href="../dist/css/sb-admin-2.css" rel="stylesheet"-->

    <!-- Morris Charts CSS -->
    <link href="{{ asset('/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!--link href="../bower_components/morrisjs/morris.css" rel="stylesheet"-->

    <!-- Custom Fonts -->
    <!--link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"-->
    <link href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('/bower_components/datatables-responsive/css/dataTables.responsive.css') }}" rel="stylesheet">
    
    <!--link rel="stylesheet" href="{{ asset('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') }}"-->
    <link rel="stylesheet" href="{{ asset('/js/datepicker/css/bootstrap-datepicker3.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="{!! URL::asset('/bower_components/jquery/dist/jquery.min.js'); !!}"></script>
        <script src="{!! URL::asset('/bower_components/bootstrap/dist/js/bootstrap.min.js'); !!}"></script>
        <!--script src="{!! URL::asset('//code.jquery.com/ui/1.11.4/jquery-ui.js'); !!}"></script-->
        

        <script src="{!! URL::asset('/js/datepicker/js/bootstrap-datepicker.js'); !!}"></script>
        <script src="{!! URL::asset('/js/datepicker/locales/bootstrap-datepicker.es.min.js'); !!}"></script>
        <link href="{{ asset('//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css') }}" rel="stylesheet">

        <script src="{!! URL::asset('//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js'); !!}"></script>
        <script>
            $(document).ready(function() {
              $(".select2").select2();
          });
        </script>
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;background-color:#6796C8">
                <div class="navbar-header" style="margin-right: 0">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img class="navbar-brand" src="{{ asset('/img/logo.png') }}" ></img>
                    <a class="navbar-brand" href="" style="color:white">Centro de Fomaci&oacute;n Judicial</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
               
                    <li>
                      <span style="color:white">  {{ User::getInstance()->getUsername() }} <span>
                    </li>
                    <li class="dropdown">

                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{ URL::to('cambiarClave') }}"><i class="fa fa-user fa-fw"></i> Cambiar Clave</a>
                            </li>
                            <!--li><a href="#"><i class="fa fa-gear fa-fw"></i> Configurac</a>
                            </li-->
                            <li class="divider"></li>
                            <li><a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                    
                            <!-- Menu Dinamico-->
                            
                            @foreach($menu as $key=>$items)
                            <li> <!-- fa fa-dashboard fa-fw-->
                            <a href="#"><i class=""></i>{{$key}}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                @foreach($items as $key=>$item)
                                    <li>
                                        <a href="{!! URL::asset($item->url) !!}">{{$item->menu}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach


                            <!-- Menu Dinamico-->

                            <!-- Aca empieza el menu -->
                            <? $user = User::getInstance(); ?>

                            <? if( $user->hassAcess(1) ){ ?>
                            <!--li>
                            <a href="#"><i class=""></i>Control de Gesti&oacute;n<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{!! URL::asset('/categorias') !!}">Cursos x Programas</a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::asset('/mgrupo') !!}">Categor&iacute;as</a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::asset('/tablero') !!}">Cargos x Curso</a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::asset('/curso-fecha') !!}">Cursos Anual</a>
                                    </li>
                                </ul>
                            </li-->
                            <?}?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
        <br>
            @yield('content')   

              <!--div class="row">
              </div>
            
              <!-- /#page-wrapper -->
        </div>

    <script src="{!! URL::asset('/bower_components/metisMenu/dist/metisMenu.min.js'); !!}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{!! URL::asset('/dist/js/sb-admin-2.js'); !!}"></script>

    <script src="{!! URL::asset('/bower_components/datatables/media/js/jquery.dataTables.min.js'); !!}"></script>
    <script src="{!! URL::asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'); !!}"></script>


</body>

</html>
