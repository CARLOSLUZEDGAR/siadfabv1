<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
            Listas
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Listas</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body">

                <div class="card collapsed-card">
                  <div class="card-header">
                    <h3 class="card-title">ORDEN GENERAL DE DESTINOS</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                      <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                      </button> -->
                    </div>
                  </div>
                  <div class="card-body">
                    Reporte donde muestra el destino de todo el personal de la FAB.
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-secondary btn-sm" @click="ordenDestinos()">
                        <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                      </button> &nbsp;
                    </div>
                  </div>
                  <!-- /.card-footer-->
                </div>
                
                <div class="card collapsed-card">
                  <div class="card-header">
                    <h3 class="card-title">COMANDANTES/DIRECTORES</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                      <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                      </button> -->
                    </div>
                  </div>
                  <div class="card-body">
                    Reporte donde muestra todos los comandantes, subcomandantes, directores y subdirectores de la FAB.
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-secondary btn-sm" @click="cuadroEfectivoDetallado()">
                        <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                      </button> &nbsp;
                    </div>
                  </div>
                  <!-- /.card-footer-->
                </div>
                                  
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      efectivo : ''
    }
  },
  mounted() {
    
  },
  computed:{
            
        },
  methods: {
        ordenDestinos(){
          window.open('http://127.0.0.1:8000/ordenDestinos');
        },

        cuadroEfectivoDetallado(){
          window.open('http://127.0.0.1:8000/cuadroEfectivoTotal');
          // window.open('https://sipefab.fab.bo/cuadroEfectivoTotal');

        },

        cuadroEgresadoNoEgresado(escalafon){
          window.open('http://127.0.0.1:8000/cuadroEgresadoNoEgresado?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroEgresadoNoEgresado?esc='+escalafon);

        },

        cuadroFamiliaresPersonal(escalafon){
          window.open('http://127.0.0.1:8000/cuadroFamiliaresPersonal?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroFamiliaresPersonal?esc='+escalafon);

        },

        cuadroPromocionCant(escalafon){
          window.open('http://127.0.0.1:8000/cuadroPromocionCant?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroPromocionCant?esc='+escalafon);

        },

        cuadroSituacionPersonal(escalafon){
          window.open('http://127.0.0.1:8000/cuadroSituacionPersonal?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroSituacionPersonal?esc='+escalafon);

        },

        cuadroFechaIncorporacion(escalafon){
          window.open('http://127.0.0.1:8000/cuadroFechaIncorporacion?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroFechaIncorporacion?esc='+escalafon);

        },        
  },
};

</script>

<style>
</style>