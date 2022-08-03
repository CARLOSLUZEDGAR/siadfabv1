<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
              Sub - Repartición
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Destinos</li>
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
            <!-- card 1 Busqueda Personal -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-search"></i>
                    Buscar Sub Repartición
                  </h3>
              </div>
              <div class="card-body">
                <div class="row  d-flex justify-content-center"> <!-- Para centrear se pone estos codigos -->
                  <div class="col-md-8 ">
                    <div class="input-group">
                      <select class="form-control col-md-3" v-model="criterio">
                          <option value="nivel1_destinos.descripcion">Organismo</option>
                          <option value="nivel2_destinos.descripcion">Gran Unidad</option>
                          <option value="nivel3_destinos.descripcion">Repartición</option>
                          <option value="nivel4_destinos.descripcion">Descripcion</option>
                      </select>
                      <input type="text" class="form-control col-md-4" placeholder="Ingrese dato..." style="text-transform:uppercase;" v-model="buscar" @keyup.enter="listarDestinos4(1,buscar,criterio)">
                      <button class="btn btn-primary btn-flat" type="subnmit" @click="listarDestinos4(1,buscar,criterio)">
                          <i class="fas fa-search"></i>&nbsp; Buscar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- fin card 1 Busqueda Personal -->

            <!-- card 2 Muestra listado Destinos 1 -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"> 
                  <i class="fas fa-list"></i>
                  Listado&nbsp;
                </h3>
                <button v-if="$auth.can('insert-destniv4')" type="button" @click="NuevoDestinos4()" class="btn btn-secondary btn-sm" style="vertical-align: top; padding: 5px 50px;">
                    <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
                </button>
                <!-- <button v-if="$auth.can('report-destniv4')" type="button"  @click.prevent="GenerarPdfDestinos4()" class="btn btn-info btn-flat btn-sm" style="vertical-align: top">
                    <i class="fas fa-file-pdf"></i>&nbsp;&nbsp;Ver PDF
                </button> -->
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                      <tr style="width:100px; text-align:center">
                        <th>Opciones</th>
                        <th>Organismo</th>
                        <th>Gran Unidad</th>
                        <th>Repartición</th>
                        <th>Descripción</th>
                        <th>Orden</th>
                        <th>Puntaje</th>
                        <th>Observaciones</th>
                        <th>Ogd</th>
                        <th>Estado</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr v-for="destinos4 in arrayDestinos4" :key="destinos4.id">
                      <td style="width:100px; text-align:center">
                        <template v-if="destinos4.estado">
                          <button v-if="$auth.can('edit-destniv4')" type="button" @click="abrirEditar(destinos4)" class="btn btn-warning btn-sm" >
                            <i class="fas fa-edit"></i>
                          </button> &nbsp;
                          <button v-if="$auth.can('delete-destniv4')" type="button" class="btn btn-danger btn-sm" @click="DesactivarDestinos4(destinos4.id4)">
                            <i class="fas fa-trash"></i>
                          </button>
                        </template>
                        <template v-else>
                            <button v-if="$auth.can('delete-destniv4')" type="button" class="btn btn-secondary btn-sm" @click="ActivarDestinos4(destinos4.id4)">
                                <i class="far fa-times-circle"></i>
                            </button>
                        </template>
                      </td>
                      <td v-text="destinos4.descripcion1"></td>
                      <td v-text="destinos4.descripcion2"></td>
                      <td v-text="destinos4.descripcion3"></td>
                      <td v-text="destinos4.descripcion4"></td>
                      <td v-text="destinos4.orden"></td>
                      <td v-text="destinos4.puntaje"></td>
                      <td v-text="destinos4.observacion"></td>
                      <td v-text="destinos4.ogd"></td>
                      <td style="width:100px; text-align:center">
                          <div v-if="destinos4.estado">
                              <span class="badge badge-success">Activo</span>
                          </div>
                          <div v-else>
                              <span class="badge badge-danger">Desactivo</span>
                          </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!-- /.card -->
              
              <div class="card-footer clearfix">
                <ul class="pagination  m-0">
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
              </div>

            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div>
      <!-- /.container-fluid -->

      <div class="modal fade" id="NuevoDestinos4"> <!-- Modal para registro nuevo CERO -->
        <div class="modal-dialog  modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">REGISTRAR NUEVA SUB REPARTICIÓN</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
              <div class="form-group row"><!-- destino nivel 1 -->
                <div class="col-md-6">
                <label class="col-md-3 form-control-label" for="text-input">Organismo</label>
                  <select class="form-control" v-model="iddestino1" v-on:change="changeItem1(rowId, $event)" :class="{ 'is-invalid' : $v.iddestino1.$error, 'is-valid':!$v.iddestino1.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino1 in arrayDestinos1" :key="destino1.id" :value="destino1.id" v-text="destino1.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino1.required">Seleccione un valor porfavor</span>
                  </div>
                </div>

                <div class="col-md-6">
                <label class="col-md-6 form-control-label" for="text-input">Gran Unidad</label>
                  <select class="form-control" v-model="iddestino2" v-on:change="changeItem2(rowId, $event)" :class="{ 'is-invalid' : $v.iddestino2.$error, 'is-valid':!$v.iddestino2.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino2 in arrayDestinos2" :key="destino2.id" :value="destino2.id" v-text="destino2.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino2.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
              </div>

              <div class="form-group row"><!-- destino nivel 3 -->
                <div class="col-md-6">
                <label class="col-md-6 form-control-label" for="text-input">Repartición</label>
                  <select class="form-control" v-model="iddestino3" :class="{ 'is-invalid' : $v.iddestino3.$error, 'is-valid':!$v.iddestino3.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino3 in arrayDestinos3" :key="destino3.id" :value="destino3.id" v-text="destino3.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino3.required">Seleccione un valor porfavor</span>
                  </div>
                </div>

                <div class="col-md-6">
                <label class="col-md-6 form-control-label" for="text-input">Descripción de la Sub Reparticion</label>
                  <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcion.$error, 'is-valid':!$v.descripcion.$invalid }" style="text-transform:uppercase" maxlength="300">
                  <div class="invalid-feedback">
                    <span v-if="!$v.descripcion.required">Este campo es Requerido</span>
                  </div>
                </div>
              </div>

              <div class="form-group row"><!-- orden -->
                <div class="col-md-4">
                  <label class="col-md-3 form-control-label" for="text-input">Orden</label>
                  <select class="form-control" v-model="orden" :class="{ 'is-invalid' : $v.orden.$error, 'is-valid':!$v.orden.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>      
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.orden.required">Este campo es Requerido</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="col-md-3 form-control-label" for="text-input">Puntaje</label>
                  <select class="form-control" v-model="puntaje" :class="{ 'is-invalid' : $v.puntaje.$error, 'is-valid':!$v.puntaje.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>      
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.puntaje.required">Este campo es Requerido</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="col-md-3 form-control-label" for="text-input">Ogd</label>
                  <select class="form-control" v-model="ogd" :class="{ 'is-invalid' : $v.ogd.$error, 'is-valid':!$v.ogd.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.ogd.required">Este campo es Requerido</span>
                  </div>
                </div>
              </div>

              <div class="form-group row"><!-- observaciones -->
                <label class="col-md-3 form-control-label" for="text-input">Observaciones</label>
                <div class="col-md-12">
                  <input class="form-control" v-model="observaciones" placeholder="Ingrese observaciones" style="text-transform:uppercase;" maxlength="300">
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="RegistrarDestino4()">Registrar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
            </div>
          </div>
            <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>
        <!-- /.modal -->

      <div class="modal fade" id="EditarDestinos4"> <!-- Modal para actualizar CERO-->
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">EDITAR SUB - REPARTICIÓN</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form-group row"><!-- destino nivel 1 -->
                <div class="col-md-6">
                <label class="col-md-3 form-control-label" for="text-input">Organismo</label>
                  <select class="form-control" v-model="iddestino1A" v-on:change="changeItem1(rowId, $event)" :class="{ 'is-invalid' : $v.iddestino1A.$error, 'is-valid':!$v.iddestino1A.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino1 in arrayDestinos1" :key="destino1.id" :value="destino1.id" v-text="destino1.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino1A.required">Seleccione un valor porfavor</span>
                  </div>
                </div>

                <div class="col-md-6">
                <label class="col-md-6 form-control-label" for="text-input">Gran Unidad</label>
                  <select class="form-control" v-model="iddestino2A" v-on:change="changeItem2(rowId, $event)" :class="{ 'is-invalid' : $v.iddestino2A.$error, 'is-valid':!$v.iddestino2A.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino2 in arrayDestinos2" :key="destino2.id" :value="destino2.id" v-text="destino2.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino2A.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
              </div>

              <div class="form-group row"><!-- destino nivel 3 -->
                <div class="col-md-6">
                <label class="col-md-6 form-control-label" for="text-input">Repartición</label>
                  <select class="form-control" v-model="iddestino3A" :class="{ 'is-invalid' : $v.iddestino3A.$error, 'is-valid':!$v.iddestino3A.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino3 in arrayDestinos3" :key="destino3.id" :value="destino3.id" v-text="destino3.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino3A.required">Seleccione un valor porfavor</span>
                  </div>
                </div>

                <div class="col-md-6">
                <label class="col-md-6 form-control-label" for="text-input">Descripción de la Sub Reparticion</label>
                  <input type="text" v-model="descripcionA" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcionA.$error, 'is-valid':!$v.descripcionA.$invalid }" style="text-transform:uppercase" maxlength="300">
                  <div class="invalid-feedback">
                    <span v-if="!$v.descripcionA.required">Este campo es Requerido</span>
                  </div>
                </div>
              </div>

              <div class="form-group row"><!-- orden -->
                <div class="col-md-4">
                  <label class="col-md-3 form-control-label" for="text-input">Orden</label>
                  <select class="form-control" v-model="ordenA" :class="{ 'is-invalid' : $v.ordenA.$error, 'is-valid':!$v.ordenA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>      
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.ordenA.required">Este campo es Requerido</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="col-md-3 form-control-label" for="text-input">Puntaje</label>
                  <select class="form-control" v-model="puntajeA" :class="{ 'is-invalid' : $v.puntajeA.$error, 'is-valid':!$v.puntajeA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>      
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.puntajeA.required">Este campo es Requerido</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="col-md-3 form-control-label" for="text-input">Ogd</label>
                  <input type="number" v-model="ogdA" class="form-control" placeholder="INGRESE OGD" :class="{ 'is-invalid' : $v.ogdA.$error, 'is-valid':!$v.ogdA.$invalid }" maxlength="10">
                  <!-- <select class="form-control" v-model="ogdA" :class="{ 'is-invalid' : $v.ogdA.$error, 'is-valid':!$v.ogdA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select> -->
                  <div class="invalid-feedback">
                    <span v-if="!$v.ogdA.required">Este campo es Requerido</span>
                  </div>
                </div>

              </div>

              <div class="form-group row"><!-- observaciones -->
                <label class="col-md-3 form-control-label" for="text-input">Observaciones</label>
                <div class="col-md-12">
                  <input class="form-control" v-model="observacionesA" placeholder="Ingrese observaciones" style="text-transform:uppercase;" maxlength="300">
                </div>
              </div>

              <input type="text" hidden v-model="id" name="" id=""> <!-- con esto recuperamos el percodigo para poder actualizar los datos -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="EditarDestino()">Actualizar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
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
  import { required, between, minLength, maxLength, alpha, numeric, email} from "vuelidate/lib/validators";
    export default {
        data() {
          return {
            arrayDestinos4 : [],

            arrayDestinos3 : [],
            iddestino3 : 0, //para el vue select

            iddestino2 : 0, //para el vue select
            arrayDestinos2 : [],
            
            iddestino1 : 0, //para el vue select
            arrayDestinos1 : [], //arreglo en vacio para almacenar el listado de los destinos1

            // Valores para guardar
            descripcion : "",
            orden : "",
            puntaje : "",
            ogd : "",
            observaciones : "",

            // valores para ACTUALZIZAR
            iddestino1A : 0,
            iddestino2A : 0,
            iddestino3A : 0,
            descripcionA : "",
            ordenA : "",
            puntajeA : "",
            ogdA : "",
            observacionesA : "",
            id : "",

            //valores de selectbuscar
            rowId : 0,

            

            pagination : {
                'total' : 0,   //total de registros       
                'current_page' : 0, //pagina actual
                'per_page' : 0, //numero de registro por paginas
                'last_page' : 0, //la ultima pagina
                'from' : 0, //desde la pagina 
                'to' : 0, //hasta la pagina
            },
            offset : 3, //pagination
            buscar: "",
            criterio: 'nivel4_destinos.descripcion',

          }
        },

        validations:{
          iddestino1 : { required},
          iddestino2 : {required},
          iddestino3 : {required},
          descripcion: {required},
          orden: {required},
          puntaje: {required},
          ogd: {required},


          iddestino1A : { required},
          iddestino2A : {required},
          iddestino3A : {required},
          descripcionA: {required},
          ordenA: {required},
          puntajeA: {required},
          ogdA: {required},
          validationGroupReg: ['iddestino1', 'iddestino2','iddestino3','descripcion','orden','puntaje','ogd'],
          validationGroupEdit: ['iddestino1A', 'iddestino2A','iddestino3A','descripcionA','ordenA','puntajeA','ogdA']
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

          listarDestinos4(page,buscar, criterio){
              let me = this;
              var url = '/listarDestino4?page=' + page + '&buscar=' + buscar.toUpperCase() + '&criterio=' + criterio;
              axios
              .get(url)
              .then(function (response) {
                  //Respuesta de la peticion
                  // //Para hacer prueba
                  var respuesta= response.data;
                  me.arrayDestinos4 = respuesta.destino4.data;
                  me.pagination = respuesta.pagination;
              })
              .catch(function (error) {
              // handle error
              console.log(error);
              });
          },

          selectDestinos1(){
            let me =this;
            var url='/selectNivel1Destino';
            axios.get(url).then(function (response) {
                // //para mostrar por consola el select
                var respuesta = response.data;
                me.arrayDestinos1 = respuesta.destino1; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
          },

          selectDestinos2(){
            let me =this;
            var url='/selectDestinos_nivel2';
            axios.get(url).then(function (response) {
                // //para mostrar por consola el select
                var respuesta = response.data;
                me.arrayDestinos2 = respuesta.destinos2; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
          },

          selectDestinos3(){
            let me =this;
            var url='/selectDestinos_nivel3';
            axios.get(url).then(function (response) {
                // //para mostrar por consola el select
                var respuesta = response.data;
                me.arrayDestinos3 = respuesta.destino3; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
          },

          changeItem1: function changeItem1(rowId, event) { //Esto sirve para el combo anidaddo, seleccionamos el id y mostramos
                this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
                this.selectbuscarDestinos2(event.target.value);
          },

          changeItem2: function changeItem2(rowId, event) { //Esto sirve para el combo anidaddo, seleccionamos el id y mostramos
                this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
                this.selectbuscarDestinos3(event.target.value);
          },

          selectbuscarDestinos2(dest)
          {
              let me =this;
              me.buscarD= dest;
              me.arrayDestinos2=[];
            //  me.prov_codigo=0;
              var url='/selectbuscarDestinosNivel2?buscar=' + dest;
              me.selected = url;
              axios.get(url).then(function (response) {

                var respuesta = response.data;
                  me.arrayDestinos2 = respuesta.destinos2; 
                //console.log(respuesta);
                  
              })
              .catch(function (error) {
              // handle error 
              me.selected =error;
              console.log(error);
              })
              .then(function () {
                
              // always executed
              }); 
          },

          selectbuscarDestinos3(dest)
          {
              let me =this;
              me.buscarD= dest;
              me.arrayDestinos3=[];
            //  me.prov_codigo=0;
              var url='/selectbuscarDestinosNivel3?buscar=' + dest;
              me.selected = url;
              axios.get(url).then(function (response) {

                var respuesta = response.data;
                  me.arrayDestinos3 = respuesta.destino3; 
                //console.log(respuesta);
                  
              })
              .catch(function (error) {
              // handle error 
              me.selected =error;
              console.log(error);
              })
              .then(function () {
                
              // always executed
              }); 
          },

          cambiarPagina(page,buscar,criterio){
            let me = this;
            me.pagination.current_page = page;
            me.listarDestinos4(page,buscar,criterio);
          },

          Cerrar(){
            this.$v.$reset()
          },

          NuevoDestinos4(){ //UNO
            this.selectDestinos1();
            this.selectDestinos2();
            this.selectDestinos3();
            this.iddestino1 = "";
            this.iddestino2 = "";
            this.iddestino3 = "";
            this.descripcion = "";
            this.orden = "";
            this.puntaje = "";
            this.observaciones = "";
            this.ogd = "",
            this.selectbuscarDestinos2(this.iddestino1);
            this.selectbuscarDestinos3(this.iddestino2);

            $('#NuevoDestinos4').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
          },

          RegistrarDestino4(){ //DOS
            this.$v.$reset();
              if(!this.$v.validationGroupReg.$invalid){
                swal.fire({
                  title: 'Se registrarán los siguientes datos', 
                  icon: 'question', 
                  showCancelButton: true, 
                  confirmButtonColor: 'info', 
                  cancelButtonColor: '#868077', 
                  confirmButtonText: 'Confirmar', 
                  cancelButtonText: 'Cancelar', 
                  buttonsStyling: true,
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    let me = this;
                    if(me.observaciones!==null){
                      me.observaciones=me.observaciones.toUpperCase();
                    }
                    axios
                    .post("/registrarDestino4", {
                      destn1: me.iddestino1,
                      destn2: me.iddestino2,
                      destn3: me.iddestino3,
                      des: me.descripcion.toUpperCase(),
                      ord : me.orden,
                      pun: me.puntaje,
                      obs: me.observaciones,
                      ogd : me.ogd
                    })
                    .then(function (response) {
                        // //Para hacer la prueba que valores llegan
                        me.datos = response.data;
                        $('#NuevoDestinos4').modal('hide'); //nos permite cerrar
                        swal.fire(
                          "Aceptado", //TITULO
                          "Se añadio correctamente la Sub Repartición", //TEXTO DE MENSAJE
                          "success" // TIPO DE MODAL (success, warnning, error, info)
                        );
                        me.listarDestinos4(1, '', 'descripcion4'); //Al momento de cerrar esto actualiza la lista
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                  }
                })
              }
              else{
                this.$v.$touch();
                Swal.fire({
                  icon: 'warning',
                  title: 'Ingrese todos los datos requeridos',
                  showConfirmButton: false,
                  timer: 2000
                })
              }
          },

          abrirEditar(destinos4){ //UNO_1
            console.log(destinos4);
            this.id = destinos4.id4,
            this.iddestino1A = destinos4.d1_cod,
            this.iddestino2A = destinos4.d2_cod,
            this.iddestino3A = destinos4.d3_cod,
            this.descripcionA = destinos4.descripcion4,
            this.ordenA = destinos4.orden,
            this.puntajeA = destinos4.puntaje,
            this.observacionesA = destinos4.observacion,
            this.ogdA = destinos4.ogd,
            this.selectDestinos1();
            this.selectDestinos2();
            this.selectbuscarDestinos2(this.iddestino1A);
            this.selectbuscarDestinos3(this.iddestino2A);
            $('#EditarDestinos4').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
          },

          EditarDestino(){ //DOS_2
            this.$v.$reset();
            if(!this.$v.validationGroupEdit.$invalid){
              swal.fire({
                title: 'Se actualizarán los siguientes campos', // TITULO 
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

                  let me = this;
                  if(me.observacionesA!==null){
                    me.observacionesA=me.observacionesA.toUpperCase();
                  }
                  axios
                  .put("/editarDestino4", { //Se pone put para el envio de datos
                      id: me.id,
                      destn1: me.iddestino1A,
                      destn2: me.iddestino2A,
                      destn3: me.iddestino3A,
                      des: me.descripcionA.toUpperCase(),
                      ord : me.ordenA,
                      pun: me.puntajeA,
                      obs: me.observacionesA,
                      ogd: me.ogdA,
                  })
                  .then(function (response) {
                      //
                      me.datos = response.data;
                      $('#EditarDestinos4').modal('hide'); //nos permite cerrar
                      swal.fire(
                        "Aceptado", //TITULO
                        "Se modificó correctamente el Destino", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                      )
                      me.listarDestinos4(1, '', 'descripcion4'); //Al momento de cerrar esto actualiza la lista
                  })
                  .catch(function (error) {
                      // handle error
                      console.log(error);
                  })
                }
              })
            }else{
              this.$v.$touch();
              Swal.fire({
                icon: 'warning',
                title: 'Ingrese todos los datos requeridos',
                showConfirmButton: false,
                timer: 2000
              })
            }
          },

          DesactivarDestinos4(id4){ //DOS_2
            swal.fire({
              title: '¿Está seguro de Desactivar destino ?', // TITULO 
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
                //SI SE DA CLIC A ACEPTAR

                let me = this;
                axios
                .put("/desactivarDestino4", { //Se pone put para el envio de datos
                    'id':id4
                })
                .then(function (response) {
                    //
                    me.datos = response.data;
                    me.listarDestinos4(1, '', 'descripcion4'); //Al momento de cerrar esto actualiza la lista

                    swal.fire(
                        "Aceptado", //TITULO
                        "Se ha desactivado el destino.", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                    );

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

          ActivarDestinos4(id4){ //DOS_2
            swal.fire({
              title: '¿Está seguro de Activar destino ?', // TITULO 
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
                //SI SE DA CLIC A ACEPTAR
                let me = this;
                axios
                .put("/activarDestino4", { //Se pone put para el envio de datos
                    'id':id4
                })
                .then(function (response) {
                    // 
                    me.datos = response.data;
                    me.listarDestinos4(1, '', 'descripcion4'); //Al momento de cerrar esto actualiza la lista
                    swal.fire(
                        "Aceptado", //TITULO
                        "Se ha Activado el destino.", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                    );
                
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

          GenerarPdfDestinos4(){
            window.open('http://sipefab.fab.bo/generarPdfDestinos4','_blank');
          }

        },

        mounted() {
            this.listarDestinos4(1, this.buscar, this.criterio); //Esto nos sirve para listar al principio la lista destinos
        },
    }
</script>

<style lang="scss" scoped>
  table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
</style>