<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="fas fa-user-tag"></i> &nbsp;
              ROLES
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
                        <div class="col-md-4">
                            <input type="text" class="form-control" @keyup="BuscarRole()" v-model="buscar">
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
                  
                  <router-link to='/nuevoRol'>
                      <button type="button" class="btn btn-success btn-sm">
                      <i class="fas fa-plus"></i> NUEVO
                      </button>
                  </router-link>
                      
                  
                </h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                          <th style="width: 5%" class="text-center">#</th>
                          <th style="width: 20%" class="text-center">OPCIONES</th>
                          <th style="width: 25%" class="text-center">NOMBRE</th>
                          <th style="width: 40%" class="text-center">DETALLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in Aroles">
                          <td class="text-center">{{index + 1}}</td>
                            <td class="text-center" style="vertical-align: middle">
                                <button  type="button" class="btn btn-primary btn-sm" @click="EditarRole(a.id)">
                                    <i class="fas fa-edit"></i> EDITAR
                                </button>
                                <!-- <button type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-eye"></i> VER
                                </button>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> ELIMINAR
                                </button> -->
                            </td>                            
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
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
    data() {
        return {
          /**
           * Variables de recepcion 
           */

          Aroles: [],

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
          setTiemoutBuscador: '',
        }
    },
    mounted() {
      this.ListarRoles(1)
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
          me.ListarRoles(page);
      },
        ListarRoles(page){
          let me = this;
          axios
          .post("/listarol", {
              buscar: me.buscar.toUpperCase(),
              page: page
          })
          .then(function (response) {
              
              me.Aroles = response.data.roles.data;
              me.pagination = response.data.pagination;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          
      },
      BuscarRole(){
          clearTimeout(this.setTiemoutBuscador);
          this.setTiemoutBuscador = setTimeout(() => {
              this.ListarRoles(1)
          }, 360)
      },
      
      EditarRole(id){
        this.$router.push({
            name: "EditarRol",
            params:{
                id: id
            }
        });

      }
    },
};
</script>

<style>
</style>