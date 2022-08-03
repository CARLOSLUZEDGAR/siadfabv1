<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="fas fa-user-tag"></i>
              EDITAR ROL
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
          <!-- Datos del Rol -->
          <div class="col-md-4">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  DATOS ROL
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <label for="">NOMBRE ROL:</label>
                  <input type="text" class="form-control" v-model="nombre">
                </div> 
                <div class="row">
                  <label for="">DETALLE:</label>
                  <textarea name="" id="" class="form-control" cols="30" rows="3" v-model="descripcion"></textarea>
                </div>  

                <div class="row">
                  <div class="col-md-12 d-flex">
                            <div class="p-2">
                                <button class="btn btn-sm btn-danger btn-block" @click="Cancelar()">
                                    <i class="fas fa-undo-alt"></i> &nbsp;
                                    CANCELAR
                                </button>
                            </div>
                            <div class="ml-auto p-2">
                                <button class="btn btn-sm btn-primary btn-block" @click="EditarRol()">
                                    <i class="fas fa-check-circle"></i> &nbsp;
                                    REGISTRAR
                                </button>
                            </div>
                        </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- Lista Permisos -->
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  LISTA PERMISOS
                </h3>
              </div>
              <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">

                <table class="table table-hover table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                          <th style="width: 5%" class="text-center">OPCION</th>
                          <th style="width: 30%" class="text-center">MODULO</th>
                          <th style="width: 30%" class="text-center">NOMBRE</th>
                          <th style="width: 35%" class="text-center">DETALLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(p, index) in listarpermisos" @click.prevent="marcarFila(index)">
                            <td class="text-center" style="vertical-align: middle">
                                <el-checkbox v-model="p.checked"></el-checkbox>
                            </td>               
                            <td class="text-center" style="vertical-align: middle">{{p.modulo}}</td>             
                            <td class="text-center" style="vertical-align: middle">{{p.name}}</td>
                            <td class="text-center" style="vertical-align: middle">{{p.detalle}}</td>
                            
                        </tr>
                    </tbody>
                    
                </table> 
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
        /**
         * Variables pasado por parametros
         */
        idr :  this.$route.params.id,      
        /**
         * variables para el rol
         */
        nombre: '',
        descripcion: '',
        /**
         * variables para los permisos 
         */
        rolper: [],
        listarpermisos: [],
        nrole: [],
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
    }
  },
  mounted() {
    this.ListarPermisos();
    console.log(this.idr);
  },
  methods: {
    ListarPermisos(page){
      let me = this;
        axios
        .post("/listaRolPermiso", {
            id: me.idr
        })
        .then(function (response) {
            
            me.rolper = response.data.permisos;
            me.nrole = response.data.rol
            me.nombre = me.nrole.name
            me.descripcion = me.nrole.detalle
            me.FiltroPermisos();
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })          
    },
    marcarFila(index){
      this.listarpermisos[index].checked = !this.listarpermisos[index].checked;
    },
    FiltroPermisos(){
      let me = this;
      me.rolper.map(function(x,y){
        me.listarpermisos.push({
          'id': x.id,
          'modulo': x.modulo,
          'name': x.name,
          'detalle': x.detalle,
          'checked': (x.checked == 1) ? true : false
        })
      })
    },
    EditarRol(){
      swal.fire({
          title: '¿DESEA EDITAR ESTE ROL?', // TITULO 
          icon: 'question', //ICONO (success, warnning, error, info, question)
          showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
          confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
          cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
          confirmButtonText: 'CONFIRMAR', //TITULO DEL BOTON CONFIRMAR
          cancelButtonText: 'CANCELAR', //TIUTLO DEL BOTON CANCELAR
          buttonsStyling: true,
          reverseButtons: true
          }).then((result) => {
          if (result.value) {
            let me = this;
            axios
            .post("/editarRol", {
                id: me.idr,
                nombre: me.nombre.toUpperCase(),
                descripcion: me.descripcion.toUpperCase(),
                listarpermisos: me.listarpermisos
            })
            .then(function (response) {
              
              swal.fire(
                  "ACEPTADO", //TITULO
                  "SE EDITO CORRECTAMENTE EL NUEVO ROL.", //TEXTO DE MENSAJE
                  "success" // TIPO DE MODAL (success, warnning, error, info)
              );

              me.Cancelar();
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
          }
      })

      
    },
    Cancelar(){
      this.$router.push({
          name: "Roles"
      });
    }
  },
};
</script>

<style>
.my-custom-scrollbar {
position: relative;
height: 100%;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>