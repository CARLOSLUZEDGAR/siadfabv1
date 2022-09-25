<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIADFAB</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <!-- CSS only -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <script>
        function solonumeros(e){
            key=e.keyCode || e.which;
            teclado=String.fromCharCode(key);
            numeros="0123456789/";
            max="4";
            especiales="8-37-38-46";
            teclado_especial=false;

            for(var i in especiales){
                if(key==especiales[i]){
                    teclado_especial=true;
                }
            }
            if(numeros.indexOf(teclado)==-1 && !teclado_especial){
                alert("Ingresar solo números");
                return false;
            }
        }

        function solonum(e){
            key=e.keyCode || e.which;
            teclado=String.fromCharCode(key);
            numeros="0123456789";
            max="4";
            especiales="8-37-38-46";
            teclado_especial=false;

            for(var i in especiales){
                if(key==especiales[i]){
                    teclado_especial=true;
                }
            }
            if(numeros.indexOf(teclado)==-1 && !teclado_especial){
                alert("Ingresar solo números");
                return false;
            }
        }

        function sololetras(e){
            key=e.keyCode || e.which;
            teclado=String.fromCharCode(key).toString();//toLocaleUpperCase();
            letras=" ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
            especiales= [8,13];
            teclado_especial=false;

            for(var i in especiales){
                if(key==especiales[i]){
                    teclado_especial=true;
                    break;
                }
            }
            if(letras.indexOf(teclado)==-1 && !teclado_especial){
                alert("Ingresar solo letras MAYÚSCULAS");
                return false;
            }
        }

        function letynum(e){
            key=e.keyCode || e.which;
            teclado=String.fromCharCode(key);
            letras=" ABCDEFGHIJKLMNÑOPQRSTUVWXYZ-1234567890.";
            max="25";
            especiales="8-37-38-46-164";
            teclado_especial=false;

            for(var i in especiales){
                if(key==especiales[i]){
                    teclado_especial=true;
                    break;
                }
            }
            if(letras.indexOf(teclado)==-1 && !teclado_especial){
                alert("Ingresar solo letras MAYÚSCULA, números y/o caracter especial -.");
                return false;
            }
        }
    </script>
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper" id="app">
@if (Auth::check())
    @include('sections.navbar')
    @include('sections.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        <App ruta="{{route('basepath')}}"></App>
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2022 "Dirección General de Tecnologías de la Información y Comunicaciones"</strong> 
        <br> 
        Todos los derechos reservados. 
        <div class="float-right d-none d-sm-inline-block">
            Diseñado por la Sección Desarrollo - <a href="http://www.fab.bo/" target="_blank">DIGETIC-FAB.</a>&nbsp;&nbsp;&nbsp;&nbsp;<b>Version</b> 1.0
        </div>
    </footer>
@else
    <Auth ruta="{{route('basepath')}}"></Auth>
@endif


  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
@if (Auth::check())
<script>
  window.user =  @json(
  [
      'user'=> auth()->user(),
      'roles'=>auth()->user()->roles,
      'permissions'=> auth()->user()->getAllPermissions()
  ]
  );

</script>
@endif
<!-- jQuery -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- SweetAlert2 -->
<!-- JavaScript Bundle with Popper -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script> --}}
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>
@if (Auth::check())
<script>


  $(document).ready(() => {
      $.ajax({
          url: '/datosP',
          type: 'GET',
          dataType: 'json',
          // headers: {
          //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          // },
          success: function(data){
              var nombre = data.grado+data.estudio+' '+data.paterno;
              $('#nombre').text(nombre);
          },
          error: function(data){
              console.log(data);
          }
      
      });
  });


</script>
@endif

<script type='text/javascript'>
	document.oncontextmenu = function(){return false}
</script>
<script>
 $(document).keydown(function(e){
    if(e.which === 123){
       return false;
    }
});
</script>

<script>
  $(document).keydown(function(e){
     if(e.ctrlKey){
       if (e.shiftKey) {
         return false;
       }
        
     }
 });
 </script>
 <script>
    $(document).keydown(function(e){
       if(e.ctrlKey){
         if (e.which === 67 || e.which === 73) {
           return false;
         }
          
       }
   });
</script>



</body>
</html>
