<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="fas fa-universal-access"></i> &nbsp;
              PERMISOS
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Modals & Alerts</li>
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
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-list-ol"></i> &nbsp;
                  BUSCAR ROL
                </h3>
              </div>
              <div class="card-body">                  
                    <div class="row d-flex justify-content-center"> 
                        <div class="col-md-8">
                            <div class="input-group">
                                <select class="form-control col-md-4" v-model="criterio">
                                    <option value="m.nombre">MODULO</option>
                                    <option value="p.name">NOMBRE</option>
                                </select>
                                <input type="text" class="form-control" @keyup="BuscarPermiso()" v-model="buscar">
                            </div>
                            
                        </div>
                    </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->




        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-list-ol"></i> &nbsp;
                  LISTA DE ROLES &nbsp;&nbsp;                  
                      <button type="button" class="btn btn-success btn-sm" @click="NuevoPermiso()">
                      <i class="fas fa-plus"></i> NUEVO
                      </button>                      
                  
                </h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                          <th style="width: 5%" class="text-center">#</th>
                          <th style="width: 30%" class="text-center">OPCIONES</th>
                          <th style="width: 15%" class="text-center">MODULO</th>
                          <th style="width: 15%" class="text-center">NOMBRE</th>
                          <th style="width: 35%" class="text-center">DETALLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in Apermisos">
                          <td class="text-center" style="vertical-align: middle">{{index + 1}}</td>
                            <td class="text-center" style="vertical-align: middle">
                                <button  type="button" class="btn btn-primary btn-sm" @click="EditarPermiso(a.id)">
                                    <i class="fas fa-edit"></i> EDITAR
                                </button>
                                <!-- <button type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-eye"></i> VER
                                </button>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> ELIMINAR
                                </button> -->
                            </td>
                            <td class="text-center" style="vertical-align: middle">{{a.modnom}}</td>                            
                            <td class="text-center" style="vertical-align: middle">{{a.name}}</td>
                            <td class="text-center" style="vertical-align: middle">{{a.detalle}}</td>
                            <!-- <td class="text-center" style="vertical-align: middle;">
                                <div v-if="u.estado === 1">
                                <span class="badge badge-success">Habilitado</span>
                                </div>
                                <div v-else>
                                <span class="badge badge-danger">Desabilitado</span>                                            
                                </div>                            
                            </td>  -->
                        </tr>
                    </tbody>
                    
                </table> 
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                        </li>
                        
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                        </li>
                    </ul>
                </nav>





              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div>
      <!-- /.container-fluid -->


      <div class="modal fade"  data-backdrop="static" id="ModalPermiso">
        <div class="modal-dialog modal-sm ">
          <div class="modal-content">
            <div class="modal-header">
                <template v-if="modal == 0">
                    <h4 class="modal-title">NUEVO PERMISO</h4>
                </template>
                <template v-else>
                    <h4 class="modal-title">EDITAR PERMISO</h4>
                </template>
              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="">NOMBRE:</label>
                        <input type="text" class="form-control" v-model="nombre">
                    </div>
                    <div class="col-sm-12">
                        <label for="">DETALLE:</label>
                        <textarea name="" class="form-control" v-model="detalle" cols="30" rows="2"></textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="">MODULO:</label>
                        <v-select
                            label="nombre"
                            :options="Amodulos"
                            v-model="modulo"
                        >
                            //EN CASO QUE NO SE ENCENTRE EL VALOR EN LA LISTA
                            <template v-slot:no-options="{ search, searching }">
                            <template v-if="searching">
                                Lo sentimos, no hay opciones de coincidencia.<em>{{
                                search
                                }}</em
                                >.
                            </template>
                            <em v-else
                                >Lo sentimos, no hay opciones de coincidencia.</em
                            >
                            </template>
                        </v-select>

                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
              <button v-if="modal == 0" type="button" class="btn btn-primary" @click="Guardar()">GUARDAR</button>
              <button v-else type="button" class="btn btn-primary" @click="Editar()">EDITAR</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
    data() {
        return {
            /**
             * Variable de manipulacion
             */

            modulo: '',
            nombre: '',
            detalle: '',
            /**
             * Variables de recepcion 
             */

            Apermisos: [],
            Amodulos: [],

            /**
             * Variables paginacion
             */
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            code: "",
            /**
             * BUSCADOR
             */

            buscar: '',
            criterio: 'm.nombre',
            setTiemoutBuscador: '',
            /**
             * Datos modal
             */
            modal: 0,
            idmod: '',
            idper: '',
        }
    },
    mounted() {
      this.ListarPermisos(1)
    },
    computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        //Calcuar los elementos de la paginacion
        pagesNumber: function() {
        if(!this.pagination.to){
            return [];
        }
        var from = this.pagination.current_page - this.offset;
        if(from < 1){
            from = 1;
        }
        var to = from + (this.offset *2);
        if( to >= this.pagination.last_page){
            to = this.pagination.last_page;
        }
        var pagesArray = [];
        while( from <= to){
            pagesArray.push(from);
            from ++;
        }
        return pagesArray;
        },
    },
    methods: {
      cambiarPagina(page){
          let me = this;
          me.pagination.current_page = page;
          me.ListarPermisos(page);
      },
        ListarPermisos(page){
          let me = this;
          axios
          .post("/listapermisos", {
              buscar: me.buscar.toUpperCase(),
              criterio: me.criterio,
              page: page
          })
          .then(function (response) {
              
              me.Apermisos = response.data.permisos.data;
              me.pagination = response.data.pagination;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          
      },
      BuscarPermiso(){
          clearTimeout(this.setTiemoutBuscador);
          this.setTiemoutBuscador = setTimeout(() => {
              this.ListarPermisos(1)
          }, 360)
      },
      NuevoPermiso(){
          this.modal = 0;
          this.ListarModulos();
          $('#ModalPermiso').modal('show');
      },
      Limpiar(){
        this.nombre = '',
        this.detalle = '',
        this.modulo = []
      },
      Guardar(){
          let me = this;
          axios
          .post("/guadarPermiso", {
              nombre: me.nombre.toLowerCase(),
              detalle: me.detalle.toUpperCase(),
              modulo: me.modulo.id
          })
          .then(function (response) {
              
              me.ListarPermisos(1);
              me.Limpiar();
              $('#ModalPermiso').modal('hide');
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
      }, 
      EditarPermiso(id){
        let me = this;
        me.modal = 1;
        me.ListarModulos();
        axios
          .post("/datosPermiso", {
              id: id
          })
          .then(function (response) {
              
              me.nombre = response.data.name,
              me.detalle = response.data.detalle,
              me.modulo = response.data.modnom,
              me.idmod = response.data.idmod,
              me.idper = response.data.id
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
        $('#ModalPermiso').modal('show');

      },
      Editar(){
        let me = this;
        if (me.modulo.id) {
            var mod = me.modulo.id;
        } else {
            var mod = me.idmod;
        }
        swal.fire({
            title: '¿Desea editar este permiso?', // TITULO 
            icon: 'question', //ICONO (success, warnning, error, info, question)
            showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
            confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
            cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
            confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
            cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
            buttonsStyling: true,
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                axios
                .post("/editarPermiso", {
                    id: me.idper,
                    nombre: me.nombre.toLowerCase(),
                    detalle: me.detalle.toUpperCase(),
                    modulo: mod
                })
                .then(function (response) {
                    
                    me.ListarPermisos(1);
                    swal.fire(
                        "Editado", //TITULO
                        "Se edito correctamente el permiso.", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                    );
                    $('#ModalPermiso').modal('hide');
                    me.Limpiar();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                

            }else{
            console.log('no empezamos');
            }
        })

      },
      ListarModulos(){
          let me = this;
          axios
            .get('/listarModulos')
            .then(function (response) {
                me.Amodulos = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });
      }

    },
};
</script>

<style>
</style>