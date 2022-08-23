<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
             Personal Destinos
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Personal Destino</li>
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
                   <i class="fas fa-search"></i>
                  Buscar Personal
                </h3>
              </div>
              <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                            <!-- select combo patr abuscar-->
                                <select class="form-control col-md-4" v-model="criterio">
                                    <!-- values como la base de datos -->
                                    <option value="p.per_nombre">Nombre</option>
                                    <option value="p.per_paterno">Ap. Paterno</option>
                                    <option value="p.per_materno">Ap. Materno</option>
                                    <option value="p.per_cm">Carnet Militar</option>
                                    <option value="p.per_ci">C. de Identidad</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup="BuscarPersona()" class="form-control" style="text-transform:uppercase" >
                                <!-- <button type="submit" @click="listarPersonal(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button> -->
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                          <button v-if="$auth.can('report-ordest')" type="button" class="btn btn-secondary btn-sm" @click="FirmasOGD()">
                            <i class="far fa-file-alt" aria-hidden="true">  Orden de Destinos</i>
                          </button> &nbsp;
                        </div>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-secondary btn-sm" @click="cuadroEfectivos()">
                            <i class="far fa-file-alt" aria-hidden="true">  Cuadro de Efectivos</i>
                          </button> &nbsp;
                        </div> -->
                        
                    </div>
                <div class="table-wrapper-scroll-y my-custom-scrollbar" id="myTable" style="font-size: 16px;">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>                                
                                <th class="text-center">Grado</th>
                                <th class="text-center">Ap. Paterno</th>
                                <th class="text-center">Ap. Materno</th>
                                <th class="text-center">Nombres</th>
                                <th class="text-center">C. Identidad</th>
                                <th class="text-center">C. Militar</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="p in listaPersonal"> 
                                <td>{{p.grado}} {{p.complemento}}</td>
                                <td> {{p.paterno}} </td>
                                <td> {{p.materno}}</td>
                                <td> {{p.nombre}} </td>
                                <td class="text-center">{{p.ci}}</td>
                                <td class="text-center">{{p.cm}}</td>
                                <td style="width:100px; text-align:center">
                                  <button type="button" class="btn btn-success btn-sm" @click="EnvioDatos(p.per_codigo)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                  </button> &nbsp;
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    
                </div>
                  <div class="form-group row">
                    <nav>
                        <!-- inicio para paginacion -->
                       <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                           
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                        <!-- fin paginacion -->
                    </nav>
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
      listaPersonal: [],
      criterio: "p.per_cm",
      buscar:"",
      setTiemoutBuscador: '',
     // page : 0,
      pagination : {
          'total' : 0,
          'current_page' : 0,
          'per_page' : 0,
          'last_page' : 0,
          'from' : 0,
          'to' : 0,
      },
      offset : 3,
    }
  },
  mounted() {
    this.ListarPersonal(1);
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
            }
        },
  methods: {
    ListarPersonal(page){
        let me = this;
        axios
        .post("/listadorPersonal", {
            page: page,
            buscar: me.buscar.toUpperCase(),
            criterio: me.criterio,
        })
        .then(function (response) {
            me.listaPersonal = response.data.personal.data;
            me.pagination =response.data.pagination
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
    },

    BuscarPersona(){
        clearTimeout(this.setTiemoutBuscador);
        this.setTiemoutBuscador = setTimeout(() => {
            this.ListarPersonal(1)
        }, 360)
    },

    cambiarPagina(page, buscar, criterio){
        let me = this;
        //Actualiza la pagina actual
        me.pagination.current_page= page;
        //Envia la peticion para visualizar la data de esa pagina
        me.ListarPersonal(page, buscar, criterio);
    },

    EnvioDatos(datos){
        this.$router.push({
            name: "DestinosPersonal",
            //ENVIO DE DATOS
            params:{
                d: datos
            }   
        });
    },
    
  },
};

</script>

<style>
</style>