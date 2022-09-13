<template>
    <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
                <i class="far fa-bookmark"></i>
                Personal Destino
            </h1>&nbsp;
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <img v-bind:src="'../img/personal/'+arrayDatosPersonal.per_foto" class="rounded float-left img-fluid" width="150" height="150"><br/>
                                <!-- <dl>
                                    <dt class="st">CARNET DE IDENTIDAD</dt>
                                    <dd class="st">{{arrayDatosPersonal.per_ci}} {{arrayDatosPersonal.per_expedido}}</dd>
                                </dl>       -->
                            </div>
                            <div class="col-md-10 d-flex align-items-center">
                                <div style="" class="col-md-12 d-flex flex-column bd-highlight mb-3">
                                    <!-- FILA 1 -->
                                    <div class="row p-2 bd-highlight">
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">GRADOS Y NOMBRES</dt>
                                                <dd class="st">{{arrayDatosPersonal.gra_abreviatura}}{{arrayDatosPersonal.estu_abreviatura}} {{arrayDatosPersonal.per_nombre}} {{arrayDatosPersonal.per_paterno}} {{arrayDatosPersonal.per_materno}}</dd>

                                                <!-- <dd class="st">{{ datos.grado }} {{ datos.complemento }} {{ datos.nombre }} {{ datos.paterno }} {{ datos.materno }}</dd> -->
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">CARNET MILITAR</dt>
                                                <dd class="st">{{arrayDatosPersonal.per_cm}}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <!-- FILA 2 -->
                                    <div class="row p-2 bd-highlight">
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">CARNET DE IDENTIDAD</dt>
                                                <dd class="st">{{arrayDatosPersonal.per_ci}} {{arrayDatosPersonal.per_expedido}}</dd>
                                            </dl>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <dl>
                                                <dt class="st">DESTINO ACTUAL</dt>
                                                <dd class="st">{{arrayDatosPersonal.nomd3}} - {{arrayDatosPersonal.nomd4}}</dd>
                                            </dl>
                                        </div> -->
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">ESPECIALIDAD - SUBESPECIALIDAD</dt>
                                                <dd class="st">{{arrayDatosPersonal.nomespe}} - {{arrayDatosPersonal.nomsubespe}}</dd>
                                            </dl>
                                        </div>

                                    </div>
                                    <!-- FILA 3 -->
                                    <div class="row p-2 bd-highlight">
                                        <!-- <div class="col-md-6">
                                            <dl>
                                                <dt class="st">ESPECIALIDAD-SUBESPECIALIDAD</dt>
                                                <dd class="st">{{arrayDatosPersonal.nomespe}} - {{arrayDatosPersonal.nomsubespe}}</dd>
                                            </dl>
                                        </div> -->
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">SITUACIÓN ACTUAL</dt>
                                                <dd class="st">{{arrayDatosPersonal.sitnombre}} - {{arrayDatosPersonal.subsitnombre}} - {{arrayDatosPersonal.detsitnombre}}</dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <dl>
                                                <dt class="st">PROFESIÓN LIBRE</dt>
                                                <template v-for="item in arrayDatosPersonalProfesion" >
                                                    <dd class="st">- {{item.prof}}</dd>
                                                </template>
                                            </dl>
                                        </div>
                                    </div>

                                    <!-- <div class="row p-2 bd-highlight">
                                        
                                    </div> -->

                                    <div class="row p-2 bd-highlight justify-content-center">
                                        <div class="col-md-4">                                            
                                            <button v-if="$auth.can('report-ordest')" type="button" class="btn btn-secondary btn-sm btn-block" @click="reporteOGD()">
                                                <i class="far fa-file-alt" aria-hidden="true">  Orden de Destinos</i>
                                            </button> &nbsp; 
                                        </div>
                                        
                                        <div class="col-md-4">  
                                            <button type="button" class="btn btn-danger btn-sm btn-block" @click="Atras()">
                                                <i class="fas fa-reply" aria-hidden="true"> Volver Atrás</i>
                                            </button> &nbsp;
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>                                                           
                    </div>
                <!-- /.card -->
                </div>

            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="table-wrapper-scroll-y my-custom-scrollbar" id="myTable" style="font-size: 16px;">
                <template v-if="arrayPersonalDestinos.length">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr style="text-align:center; vertical-align:middle;">
                                <!-- <th><center>Opciones</center></th> -->
                                <th>#</th>
                                <th>GRAN UNIDAD</th>
                                <th>REPARTICIÓN</th>
                                <th>SUBREPARTICIÓN</th>
                                <th>1ER. CARGO</th>
                                <th>2DO. CARGO</th>
                                <th>FECHA DESTINO</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="(personalDestinos, index) in arrayPersonalDestinos" :key="personalDestinos.id">
                                <td style="text-align:center; font-weight:bold;">{{ index + 1 }}</td>
                                <td v-text="personalDestinos.desc_dn2" ></td>
                                <td v-text="personalDestinos.desc_dn3" ></td>
                                <td v-text="personalDestinos.desc_dn4"></td> 
                                <td v-text="personalDestinos.cargo"></td> 
                                <td style="text-align:center">{{ arrayPersonalDestinos2.find(function(el) { return el.idpersonal_destinos == personalDestinos.idpersonal_destinos; } ).cargo2 }}</td>                
                                <td style="text-align:center;">{{personalDestinos.fechadestino | moment("D/MM/YYYY")}}</td>
                                <td style="width:100px; text-align:center">
                                    <button v-if="$auth.can('edit-perdest')" type="button" class="btn btn-warning btn-sm" @click="abrirEditar(personalDestinos,arrayDatosPersonal)">
                                        <i class="fas fa-edit"></i>
                                    </button> &nbsp;
                                </td>                         
                            </tr>
                        </tbody>
                    </table>
                </template>
                <template v-else>
                    <div class="callout callout-info">
                        <h5><i class="fas fa-exclamation-triangle x-lg-2"></i> No se encontraron resultados...</h5>
                    </div>
                </template>
                </div>
                    <nav>
                        <!-- inicio para paginacion -->
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
                        <!-- fin paginacion -->
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


        <!--MODAL CLASES
        id="NombreModal" -->
        <div class="modal fade" id="NuevoDestino">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title-registro"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="Cerrar()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Nro. Documento</label>
                            <input type="text" v-model="perdest_nro_doc" class="form-control" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Tipo Documento</label>
                            <input type="text" v-model="perdest_tipo_doc" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Fecha de Documento</label>
                            <input type="text" v-model="perdest_fechadestino" class="form-control" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Grado en el Destino</label>
                            <input type="text" v-model="perdest_grado" class="form-control" disabled>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Organismo</label>
                            <select class="form-control" v-model="perdest_destn1_codigo" v-on:change="changeItem1(rowId, $event)" :class="{ 'is-invalid' : $v.perdest_destn1_codigo.$error, 'is-valid':!$v.perdest_destn1_codigo.$invalid }">
                                <option value="" disabled>SELECCIONE</option>
                                <option v-for="destinos_nivel1 in arrayDestinos_nivel1" :key="destinos_nivel1.id" :value="destinos_nivel1.id"  v-text="destinos_nivel1.descripcion"></option>
                            </select>
                            <div class="invalid-feedback">
                                <span v-if="!$v.perdest_destn1_codigo.required">Este campo es Requerido</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Gran Unidad</label>
                            <select class="form-control" v-model="perdest_destn2_codigo" v-on:change="changeItem2(rowId, $event)" :class="{ 'is-invalid' : $v.perdest_destn2_codigo.$error, 'is-valid':!$v.perdest_destn2_codigo.$invalid }">
                                <option value="" disabled>SELECCIONE</option>
                                <option v-for="destinos_nivel2 in arrayDestinos_nivel2" :key="destinos_nivel2.id" :value="destinos_nivel2.id"  v-text="destinos_nivel2.descripcion"></option>                        
                            </select>
                            <div class="invalid-feedback">
                                <span v-if="!$v.perdest_destn2_codigo.required">Este campo es Requerido</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Repartición</label>
                            <select class="form-control" v-model="perdest_destn3_codigo" v-on:change="changeItem3(rowId, $event)" :class="{ 'is-invalid' : $v.perdest_destn3_codigo.$error, 'is-valid':!$v.perdest_destn3_codigo.$invalid }">
                                <option value="" disabled>SELECCIONE</option>
                                <option v-for="destinos_nivel3 in arrayDestinos_nivel3" :key="destinos_nivel3.id" :value="destinos_nivel3.id"  v-text="destinos_nivel3.descripcion"></option>
                            </select>
                            <div class="invalid-feedback">
                                <span v-if="!$v.perdest_destn3_codigo.required">Este campo es Requerido</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Subrepartición</label>
                            <select class="form-control" v-model="perdest_destn4_codigo" :class="{ 'is-invalid' : $v.perdest_destn4_codigo.$error, 'is-valid':!$v.perdest_destn4_codigo.$invalid }">
                                <option value="" disabled>SELECCIONE</option>
                                <option v-for="destinos_nivel4 in arrayDestinos_nivel4" :key="destinos_nivel4.id" :value="destinos_nivel4.id"  v-text="destinos_nivel4.descripcion"></option>
                            </select>
                            <div class="invalid-feedback">
                                <span v-if="!$v.perdest_destn4_codigo.required">Este campo es Requerido</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Primer Cargo</label>
                            <v-select
                                label="descripcion"
                                :options="arrayCargos"                      
                                v-model="valor" :class="{ 'is-invalid' : $v.valor.$error, 'is-valid':!$v.valor.$invalid }">                     
                                <template v-slot:no-options="{ search, searching }">
                                <template v-if="searching">
                                    Lo sentimos, no hay opciones de coincidencia "<em>{{
                                    search
                                    }}"</em>.
                                </template>
                                <em v-else
                                    >Lo sentimos, no hay opciones de coincidencia.</em>
                                </template>
                            </v-select>
                            <div class="invalid-feedback">
                                <span v-if="!$v.valor.required">Este campo es Requerido</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label" for="text-input">Segundo Cargo</label>
                            <v-select
                                label="descripcion"
                                :options="arrayCargos"                      
                                v-model="valor2" >                     
                                <template v-slot:no-options="{ search, searching }">
                                <template v-if="searching">
                                    Lo sentimos, no hay opciones de coincidencia "<em>{{
                                    search
                                    }}"</em>.
                                </template>
                                <em v-else
                                    >Lo sentimos, no hay opciones de coincidencia.</em>
                                </template>
                            </v-select>                                   
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label" for="text-input">Observación</label>
                            <textarea name="textarea" class="form-control" rows="3" v-model="perdest_observaciones" style="text-transform:uppercase"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="RegistrarDestino()">Registrar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      
        <div class="modal fade" id="EditarDestino">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title-edit"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="Cerrar()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input" >Nro. Documento</label>
                                <input type="text" v-model="perdest_nro_docA" class="form-control" :class="{ 'is-invalid' : $v.perdest_nro_docA.$error, 'is-valid':!$v.perdest_nro_docA.$invalid }" disabled>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_nro_docA.required">Este campo es Requerido</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Tipo Documento</label>
                                <select class="form-control" v-model="perdest_tipo_docA" :class="{ 'is-invalid' : $v.perdest_tipo_docA.$error, 'is-valid':!$v.perdest_tipo_docA.$invalid }" disabled>
                                    <option value="ORDEN GENERAL DE DESTINOS">ORDEN GENERAL DE DESTINOS</option>
                                </select>
                                <div class="invalid-feedback">
                                        <span v-if="!$v.perdest_tipo_docA.required">Este campo es Requerido</span>
                                    </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Fecha de Documento</label>
                                <input type="date" v-model="perdest_fechadestinoA" class="form-control" :class="{ 'is-invalid' : $v.perdest_fechadestinoA.$error, 'is-valid':!$v.perdest_fechadestinoA.$invalid }" disabled>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_fechadestinoA.required">Este campo es Requerido</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Grado en el Destino</label>
                                <select class="form-control" v-model="perdest_gradoA" :class="{ 'is-invalid' : $v.perdest_gradoA.$error, 'is-valid':!$v.perdest_gradoA.$invalid }" disabled>
                                    <option v-for="grados in arrayGrados" :key="grados.id" :value="grados.id"  v-text="grados.abreviatura"></option>
                                </select>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_gradoA.required">Este campo es Requerido</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Organismo</label>
                                <select class="form-control" v-model="perdest_destn1_codigoA" v-on:change="changeItem1(rowId, $event)" :class="{ 'is-invalid' : $v.perdest_destn1_codigoA.$error, 'is-valid':!$v.perdest_destn1_codigoA.$invalid }">
                                    <option value="0" disabled>SELECCIONE</option>
                                    <option v-for="destinos_nivel1 in arrayDestinos_nivel1" :key="destinos_nivel1.id" :value="destinos_nivel1.id"  v-text="destinos_nivel1.descripcion"></option>
                                </select>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_destn1_codigoA.required">Este campo es Requerido</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Gran Unidad</label>
                                <select class="form-control" v-model="perdest_destn2_codigoA" v-on:change="changeItem2(rowId, $event)" :class="{ 'is-invalid' : $v.perdest_destn2_codigoA.$error, 'is-valid':!$v.perdest_destn2_codigoA.$invalid }">
                                    <option value="0" disabled>SELECCIONE</option>
                                    <option v-for="destinos_nivel2 in arrayDestinos_nivel2" :key="destinos_nivel2.id" :value="destinos_nivel2.id"  v-text="destinos_nivel2.descripcion"></option>                        
                                </select>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_destn2_codigoA.required">Este campo es Requerido</span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="col-md-2 form-control-label" for="text-input">Repartición</label>
                                <select class="form-control" v-model="perdest_destn3_codigoA" v-on:change="changeItem3(rowId, $event)" :class="{ 'is-invalid' : $v.perdest_destn3_codigoA.$error, 'is-valid':!$v.perdest_destn3_codigoA.$invalid }">
                                    <option value="0" disabled>SELECCIONE</option>
                                    <option v-for="destinos_nivel3 in arrayDestinos_nivel3" :key="destinos_nivel3.id" :value="destinos_nivel3.id"  v-text="destinos_nivel3.descripcion"></option>
                                </select>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_destn3_codigoA.required">Este campo es Requerido</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Subrepartición</label>
                                <select class="form-control" v-model="perdest_destn4_codigoA" :class="{ 'is-invalid' : $v.perdest_destn4_codigoA.$error, 'is-valid':!$v.perdest_destn4_codigoA.$invalid }">
                                    <option value="0" disabled>SELECCIONE</option>
                                    <option v-for="destinos_nivel4 in arrayDestinos_nivel4" :key="destinos_nivel4.id" :value="destinos_nivel4.id"  v-text="destinos_nivel4.descripcion"></option>
                                
                                </select>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_destn4_codigoA.required">Este campo es Requerido</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Primer Cargo</label>
                                <select class="form-control" v-model="perdest_cargo1A" :class="{ 'is-invalid' : $v.perdest_cargo1A.$error, 'is-valid':!$v.perdest_cargo1A.$invalid }">
                                        <option value="0" disabled>SELECCIONE</option>
                                        <option v-for="cargos in arrayCargos" :key="cargos.id" :value="cargos.id"  v-text="cargos.descripcion"></option>
                                </select>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_cargo1A.required">Este campo es Requerido</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">Segundo Cargo</label>
                                <select class="form-control" v-model="perdest_cargo2A">
                                    <option value="0" disabled>SELECCIONE</option>
                                    <option v-for="cargos in arrayCargos" :key="cargos.id" :value="cargos.id"  v-text="cargos.descripcion"></option>
                                </select>                                 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-control-label" for="text-input">Observación</label>
                                <textarea name="textarea" class="form-control" rows="3" v-model="perdest_observacionesA"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="EditarDestino()">Actualizar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="FirmasOGD">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title-edit"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="Cerrar()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input" >Comandante FAB</label>
                                <input type="text" v-model="cmdte" class="form-control">
                                <!-- <input type="text" v-model="perdest_nro_docA" class="form-control" :class="{ 'is-invalid' : $v.perdest_nro_docA.$error, 'is-valid':!$v.perdest_nro_docA.$invalid }" disabled>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_nro_docA.required">Este campo es Requerido</span>
                                </div> -->
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input" >Comandante en Jefe</label>
                                <input type="text" v-model="cmdteJefe" class="form-control">
                                <!-- <input type="text" v-model="perdest_nro_docA" class="form-control" :class="{ 'is-invalid' : $v.perdest_nro_docA.$error, 'is-valid':!$v.perdest_nro_docA.$invalid }" disabled>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_nro_docA.required">Este campo es Requerido</span>
                                </div> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input" >Ministro de Defensa</label>
                                <input type="text" v-model="minDef" class="form-control">
                                <!-- <input type="text" v-model="perdest_nro_docA" class="form-control" :class="{ 'is-invalid' : $v.perdest_nro_docA.$error, 'is-valid':!$v.perdest_nro_docA.$invalid }" disabled>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_nro_docA.required">Este campo es Requerido</span>
                                </div> -->
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input" >Presidente</label>
                                <input type="text" v-model="presidente" class="form-control">
                                <!-- <input type="text" v-model="perdest_nro_docA" class="form-control" :class="{ 'is-invalid' : $v.perdest_nro_docA.$error, 'is-valid':!$v.perdest_nro_docA.$invalid }" disabled>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.perdest_nro_docA.required">Este campo es Requerido</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="reporteOGD()">Generar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
//import { required, minLength, between } from 'vuelidate/lib/validators'
import { required, minLength, maxLength, alpha, numeric, email, sameAs} from "vuelidate/lib/validators";
export default {
    data() {
        // const today = new Date();
        const today = new Date();
        const gestion4 = today.getFullYear().toString();
        const gestion2 = gestion4.slice(-2);
        return {
            //RECIBIMOS LA VARIABLE EN ESTE CASO (d)
            per_codigo: this.$route.params.d,
            arrayPersonalDestinos : [],
            arrayPersonalDestinos2 : [],
            arrayDatosPersonal : [],
            arrayGrados : [],
            arrayDatosPersonalProfesion : [],

            cmdte : '',
            cmdteJefe : '',
            minDef : '',
            presidente : '',
            numeral : 0,

            errorDestinosActualizar : 0,
            errorMostrarMsjDestinosActualizar : [],

            ano_actual : gestion4,
            ano_actual2 : gestion2,
            gestion : '',
            per_cmi : '',
            per_cmil : '',
            //VARIABLES MODAL
            rowId : 0,
            modal : 0,
            tituloModal : '',
            tipoAccion : 0,
            per_paterno : '',
            per_materno : '',
            per_nombre : '',
            per_cm : '',
            //VARIABLES REGISTRAR DESTINO
            perdest_nro_doc : '',
            perdest_tipo_doc : '',
            perdest_fechadestino : '',
            perdest_grado : '',
            perdest_destn1_codigo : '',
            perdest_destn2_codigo : '',
            perdest_destn3_codigo : '',
            perdest_destn4_codigo : '',
            perdest_promo : 0,
            perdest_cargo1 : 0,
            perdest_cargo2 : 0,
            perdest_observaciones : '',
            //VARIABLES EDITAR DESTINO
            idPersonalDestino : 0,
            perdest_nro_docA : '',
            perdest_tipo_docA : '',
            perdest_fechadestinoA : '',
            perdest_gradoA : '',
            perdest_destn1_codigoA : '',
            perdest_destn2_codigoA : '',
            perdest_destn3_codigoA : '',
            perdest_destn4_codigoA : '',
            promocionA : 0,
            perdest_promoA : 0,
            perdest_cargo1A : '',
            perdest_cargo2A : '',
            perdest_observacionesA : '',
            //ARRAYS
            arrayDestinos_nivel1 : [],
            arrayDestinos_nivel2 : [],
            arrayDestinos_nivel3 : [],
            arrayDestinos_nivel4 : [],
            //VARIABLES SELECT
            arrayCargos : [],
            valor : [],
            valor2 : [],
            valorA : [],
            valorA2 : [],
            //FIN VARIABLES SELCT
            //arrayCargos2 : [],
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

    validations:{
        
            // perdest_nro_doc : { required },
            // perdest_tipo_doc : { required },
            // perdest_fechadestino : { required },
            // perdest_grado : { required },
            perdest_destn1_codigo : { required },
            perdest_destn2_codigo : { required },
            perdest_destn3_codigo : { required },
            perdest_destn4_codigo : { required },
            valor : { required },

            perdest_nro_docA : { required },
            perdest_tipo_docA : { required },
            perdest_fechadestinoA : { required },
            perdest_gradoA : { required },
            perdest_destn1_codigoA : { required },
            perdest_destn2_codigoA : { required },
            perdest_destn3_codigoA : { required },
            perdest_destn4_codigoA : { required },
            perdest_cargo1A : { required },

            validationGroupReg: ['perdest_destn1_codigo', 'perdest_destn2_codigo', 'perdest_destn3_codigo', 'perdest_destn4_codigo','valor'],
            validationGroupEdit: ['perdest_nro_docA', 'perdest_tipo_docA', 'perdest_fechadestinoA', 'perdest_gradoA', 'perdest_destn1_codigoA', 'perdest_destn2_codigoA', 'perdest_destn3_codigoA', 'perdest_destn4_codigoA','perdest_cargo1A']

    },

    mounted() {
        //this.ver();
        this.listarPersonalDestinos(this.per_codigo);

        this.datosPersonal(this.per_codigo);

        this.selectGrado();

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

        fechaactual(date){
            const today = new Date();
            console.log(today);
            today.setHours(0, 0, 0, 0);
            return  date > new Date(today.getTime());
        },

        listarPersonalDestinos(per_codigo,page){
            let me = this;
            axios
          .post("/listarPersonalDestinos", {
            per_codigo : per_codigo,
            page:page
            
          })
          .then(function (response) {
        
           me.arrayPersonalDestinos = response.data.cargo1.data
           me.arrayPersonalDestinos2 = response.data.cargo2
           me.pagination = response.data.pagination
           
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
        },

        datosPersonal(per_codigo){
            let me = this;
            axios
          .post("/datosPersonal", {
            per_codigo : per_codigo,
          })
          .then(function (response) {
            console.log(response);
            me.arrayDatosPersonal = response.data.personal_datos;
            me.arrayDatosPersonalProfesion = response.data.profesiones;

          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
        },

        selectGrado(){
            let me = this;
            axios
        
            .post("/listarGrado", {
                division : me.arrayDatosPersonal.division
            })
            .then(function (response) {
                console.log(response)
                me.arrayGrados = response.data.listar_grado;
                // me.pagination = response.data.pagination;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        },

        cambiarPagina(page){
            let me = this;
            //Actualiza la pagina actual
            me.pagination.current_page= page;
            //Envia la peticion para visualizar la data de esa pagina
            me.listarPersonalDestinos(me.per_codigo,page);
        },

        changeItem1: function changeItem1(rowId, event) {
            this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
            this.selectbuscarDestinos_nivel2(event.target.value);
        },
        changeItem2: function changeItem2(rowId, event) {
            this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
            this.selectbuscarDestinos_nivel3(event.target.value);
        },
        changeItem3: function changeItem3(rowId, event) {
            this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
            this.selectbuscarDestinos_nivel4(event.target.value);
        },
        selectDestinos_nivel1(){
            let me =this;
            var url='/destinos_nivel1/selectDestinos_nivel1';
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                me.arrayDestinos_nivel1 = respuesta.destino1; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
        },

        selectDestinos_nivel2(){
            let me =this;
            var url='/destinos_nivel2/selectDestinos_nivel2';
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                me.arrayDestinos_nivel2 = respuesta.destinos2; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
        },

        selectDestinos_nivel3(){
            let me =this;
            var url='/destinos_nivel3/selectDestinos_nivel3';
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                me.arrayDestinos_nivel3 = respuesta.destino3; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
        },

        selectDestinos_nivel4(){
            let me =this;
            var url='/destinos_nivel4/selectDestinos_nivel4';
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                me.arrayDestinos_nivel4 = respuesta.destino4; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
        },
            
        selectbuscarDestinos_nivel2(depa)
        {
            let me =this;
           
            me.buscarD= depa;
            me.arrayDestinos_nivel2=[];
          //  me.prov_codigo=0;
            var url='/destinos_nivel2/selectbuscarDestinos_nivel2?buscar=' + depa;
            me.selected = url;
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                me.arrayDestinos_nivel2 = respuesta.destinos2; 
                
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

        selectbuscarDestinos_nivel3(depa)
        {
            let me =this;
            me.buscarD= depa;
            me.arrayDestinos_nivel3=[];
          //  me.prov_codigo=0;
            var url='/destinos_nivel3/selectbuscarDestinos_nivel3?buscar=' + depa;
            me.selected = url;
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                me.arrayDestinos_nivel3 = respuesta.destino3; 
                
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

        selectbuscarDestinos_nivel4(depa)
        {
            let me =this;
            me.buscarD= depa;
            me.arrayDestinos_nivel4=[];
          //  me.prov_codigo=0;
            var url='/destinos_nivel4/selectbuscarDestinos_nivel4?buscar=' + depa;
            me.selected = url;
            axios.get(url).then(function (response) {

                var respuesta = response.data;
                me.arrayDestinos_nivel4 = respuesta.destino4; 
                
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

        listarCargos(){
            let me = this;
            axios
            .post("/listarCargos", {
                filtro : me.arrayDatosPersonal.subescid,
            })
            .then(function (response) {
        //Respuesta de la peticion
            me.arrayCargos = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });
        },

        obtenerPromocion(){
           this.per_cm = this.arrayDatosPersonal.per_cm;
                //obtiene la gestion actual
            var fecha = new Date();
            var ano = fecha.getFullYear();
            this.gestion = ano;
            //obtiene variable.toString a varchar
            var ano1 = ano.toString()
            //para extraer
            var ano2 = ano1.substring(2,4);
            this.ano_actual = parseInt(ano2);
            
            //var per_cm1 = this.per_cm;
            //this.per_cmil = this.per_cm.substring(3,5);

            this.per_cmi = this.per_cm.substring(3,5);
            this.per_cmil = parseInt(this.per_cmi);

            if (this.per_cmil >= 0 && this.per_cmil <= this.ano_actual){
                this.perdest_promo = 2000 + this.per_cmil;
            }
            else{
                this.perdest_promo = 1900 + this.per_cmil;
            }
        },

        Cerrar(){
            this.$v.$reset()
        },

        NuevoDestino(){
            this.$v.$reset(),
            //PONER DE CERO EL MODAL ANTES DE REGISTRAR
            this.idPersonalDestino = 0,
            this.perdest_nro_doc = '02/'+this.ano_actual2,
            this.perdest_tipo_doc = 'ORDEN GENERAL DE DESTINOS',
            this.perdest_fechadestino = '31/12/'+this.ano_actual,
            this.perdest_grado = this.arrayDatosPersonal.gra_abreviatura,
            this.perdest_destn1_codigo = '',
            this.perdest_destn2_codigo = '',
            this.perdest_destn3_codigo = '',
            this.perdest_destn4_codigo = '',
            this.valor = [],
            this.valor2 = [],
            this.perdest_observaciones = '',
            //FIN PONER A CERO MODAL
            $('#NuevoDestino').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
            $(".modal-title-registro").text("Registrar Nuevo Destino");
            this.obtenerPromocion()
            this.selectDestinos_nivel1()
            this.selectDestinos_nivel2()
            this.selectDestinos_nivel3()
            this.selectDestinos_nivel4()
            this.selectbuscarDestinos_nivel2(this.perdest_destn1_codigo)
            this.selectbuscarDestinos_nivel3(this.perdest_destn2_codigo)
            this.selectbuscarDestinos_nivel4(this.perdest_destn3_codigo)
            this.selectGrado()
            this.listarCargos()
        },

        RegistrarDestino(){
            this.$v.$reset();
            if(!this.$v.validationGroupReg.$invalid){
                swal.fire({
                    title: 'Esta seguro de registrar este destino', // TITULO 
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
                        //CODIGO HA SER VALIDADO
                        let me = this;
                        axios
                        .post("/registrarDestino", {
                        //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                            perdest_percodigo : me.per_codigo,
                            perdest_nro_doc : me.perdest_nro_doc,
                            perdest_tipo_doc : me.perdest_tipo_doc,
                            perdest_fechadestino : me.gestion+'-12-31',
                            perdest_destn1_codigo : me.perdest_destn1_codigo,
                            perdest_destn2_codigo : me.perdest_destn2_codigo,
                            perdest_destn3_codigo : me.perdest_destn3_codigo,
                            perdest_destn4_codigo : me.perdest_destn4_codigo,
                            perdest_grado : me.arrayDatosPersonal.idgrado,
                            perdest_cargo1 : me.valor.id,
                            perdest_cargo2 : me.valor2.id,
                            promocion : me.perdest_promo,
                            perdest_observaciones : me.perdest_observaciones.toUpperCase(),
                            //filtro : me.arrayDatosPersonal.subescid,
                        })
                        .then(function (response) {
                            //Respuesta de la peticion
                            console.log(response);
                            $('#NuevoDestino').modal('hide');
                            me.listarPersonalDestinos(me.per_codigo);
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                    }else{
                        console.log('no empezamos');
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

        abrirEditar(personalDestinos,arrayDatosPersonal){
            let me =this;
            this.$v.$reset(),
            this.idPersonalDestino = personalDestinos.idpersonal_destinos,
            this.perdest_nro_docA = personalDestinos.nro_doc,
            this.perdest_tipo_docA = personalDestinos.tipo_doc,
            this.perdest_fechadestinoA = personalDestinos.fechadestino,
            this.perdest_fechadestinoA = this.perdest_fechadestinoA.substring(0,10);
                                        var info10 = this.perdest_fechadestinoA.split('-');
                                        this.perdest_fechadestinoA = info10[0] + '-' + info10[1] + '-' + info10[2];
            this.perdest_gradoA = arrayDatosPersonal.idgrado,
            this.perdest_destn1_codigoA = personalDestinos.d1_cod,
            this.perdest_destn2_codigoA = personalDestinos.d2_cod,
            this.perdest_destn3_codigoA = personalDestinos.d3_cod,
            this.perdest_destn4_codigoA = personalDestinos.d4_cod,
            this.perdest_cargo1A = personalDestinos.idcargo,
            this.perdest_cargo2A = me.arrayPersonalDestinos2.find(function(el) { 
                return el.idpersonal_destinos == personalDestinos.idpersonal_destinos; 
                } ).idcargo2,
            this.perdest_promoA = this.perdest_promo,
            this.perdest_observacionesA = personalDestinos.observacion,
            $('#EditarDestino').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
            $(".modal-title-edit").text("DESTINO: "+arrayDatosPersonal.gra_abreviatura+arrayDatosPersonal.estu_abreviatura+' '+arrayDatosPersonal.per_nombre+' '+arrayDatosPersonal.per_paterno+' '+arrayDatosPersonal.per_materno);
            this.obtenerPromocion()
            this.selectDestinos_nivel1()
            this.selectDestinos_nivel2()
            this.selectDestinos_nivel3()
            this.selectDestinos_nivel4()
            this.selectbuscarDestinos_nivel2(this.perdest_destn1_codigoA)
            this.selectbuscarDestinos_nivel3(this.perdest_destn2_codigoA)
            this.selectbuscarDestinos_nivel4(this.perdest_destn3_codigoA)
            this.selectGrado()
            this.listarCargos()
        },

        EditarDestino(){
            this.$v.$reset();
            if(!this.$v.validationGroupEdit.$invalid){
                swal.fire({
                    title: 'Esta seguro de Cambiar de Destino', // TITULO 
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
                        //CODIGO HA SER VALIDADO
                        let me = this;
                        axios
                        .put("/editarDestino", {
                    //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                        idPersonalDestino : me.idPersonalDestino,
                        // perdest_codigocambio : me.per_codigo,
                        // perdest_nro_doc : me.perdest_nro_docA,
                        // perdest_tipo_doc : me.perdest_tipo_docA,
                        perdest_gra_doc : me.perdest_gradoA,
                        // perdest_fechadestino : me.perdest_fechadestinoA,
                        perdest_destn1_codigo : me.perdest_destn1_codigoA,
                        perdest_destn2_codigo : me.perdest_destn2_codigoA,
                        perdest_destn3_codigo : me.perdest_destn3_codigoA,
                        perdest_destn4_codigo : me.perdest_destn4_codigoA,
                        perdest_cargo1 : me.perdest_cargo1A,
                        perdest_cargo2 : me.perdest_cargo2A,
                        // promocion : me.perdest_promo,
                        perdest_observaciones : me.perdest_observacionesA,
                    })
                    .then(function (response) {
                        //Respuesta de la peticion
                        
                        $('#EditarDestino').modal('hide');
                        me.listarPersonalDestinos(me.per_codigo);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        });
                    }else{
                        console.log('no empezamos');
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

        abrirOGD(){
            let me =this;
            this.$v.$reset(),
            this.cmdte = '',
            this.cmdteJefe = '',
            this.minDef = '',
            this.presidente = '',
            $('#FirmasOGD').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
            $(".modal-title-edit").text("Firmas OGD");
        },

        desactivarDestino(personalDestinos){
            //if(!this.$v.$invalid){
                swal.fire({
                    title: 'Esta seguro de eliminar este destino', // TITULO 
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
                        //CODIGO HA SER VALIDADO
                        let me =this;
                        this.idPersonalDestino = personalDestinos.idpersonal_destinos,
                        axios
                        .put('/desactivarDestino', {
                    //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                        idPersonalDestino : me.idPersonalDestino,
                        per_codigo : me.per_codigo,
                    })
                    .then(function (response) {
                        //Respuesta de la peticion
                        
                        me.listarPersonalDestinos(me.per_codigo);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        });
                    }else{
                        console.log('no empezamos');
                    }
                })  
        },

        EnvioDesglose(datos){
            this.$router.push({
                name: "Desglose",
                //ENVIO DE DATOS
                params:{
                    d: datos
                }
                
            });
        },

        EnvioCertAsc(datos){
            this.$router.push({
                name: "CertDestAsc",
                //ENVIO DE DATOS
                params:{
                    d: datos
                }
                
            });
        },

        EnvioCertFront(datos){
            this.$router.push({
                name: "CertDestFront",
                //ENVIO DE DATOS
                params:{
                    d: datos
                }
                
            });
        },

        EnvioCertDesgl(datos){
            this.$router.push({
                name: "CertDestDesgl",
                //ENVIO DE DATOS
                params:{
                    d: datos
                }
                
            });
        },

        EnvioDesgServ (datos){
            this.$router.push({
                name: "CertDesglServ",
                //ENVIO DE DATOS
                params:{
                    d: datos,
                    div: this.arrayDatosPersonal.division
                }
                
            });
        },

        reporteOGD(){
            this.$v.$reset()
            // if(!this.$v.$invalid){
            // window.open('http://192.168.3.77/ordenDestinos');
            // window.open('http://127.0.0.1/ordenDestinos');
            // window.open('http://sipefab.fab.bo/ordenDestinos?cmdtefab='+cmdteFAB+'&cmdteffaa='+cmdteFFAA+'&mindef='+minDEF+'&presidente='+presidente);
            window.open('http://127.0.0.1:8000/ordenDestinos');
            // }
            // else{
            //     this.$v.$touch();
            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'Ingrese todos los datos requeridos',
            //         showConfirmButton: false,
            //         timer: 2000
            //     })  
            // }
        },

        Atras(){
            this.$router.push({
                name: "ListarPersonalDestinos"
                //ENVIO DE DATOS
                // params:{
                //     d: datos
                // }
                
            });
        },

    },
}
</script>
<style>
    .dat {
        width: 100%;
        
    }
</style>