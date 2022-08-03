<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
              Repartición
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
                    Buscar Repartición
                  </h3>
              </div>
              <div class="card-body">
                <div class="row form-group"> <!-- Para centrear se pone estos codigos -->
                  <div class="col-md-8 ">
                    <div class="input-group">
                      <select class="form-control col-md-3" v-model="criterio">
                          <option value="nivel1_destinos.descripcion">Organismo</option>
                          <option value="nivel2_destinos.descripcion">Gran Unidad</option>
                          <option value="nivel3_destinos.descripcion">Descripción</option>
                          <option value="departamentos.nombre">Departamento</option>
                      </select>
                      <input type="text" class="form-control col-md-4"  placeholder="Ingrese dato..." style="text-transform:uppercase;" v-model="buscar" @keyup.enter="listarDestinos3(1,buscar,criterio)">
                      <button class="btn btn-primary btn-flat" type="subnmit" @click="listarDestinos3(1,buscar,criterio)">
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
                <button v-if="$auth.can('insert-destniv3')" type="button" @click="NuevoDestinos3()" class="btn btn-secondary btn-sm" style="vertical-align: top; padding: 5px 50px;">
                    <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
                </button>
                <!-- <button v-if="$auth.can('report-destniv3')" type="button"  @click.prevent="GenerarPdfDestinos3()" class="btn btn-info btn-flat btn-sm" style="vertical-align: top">
                    <i class="fas fa-file-pdf"></i>&nbsp;&nbsp;Ver PDF
                </button> -->
              </div>
              <div class="card-body">
                <table  class="table table-bordered table-striped table-sm" >
                  <thead>
                      <tr style="width:100px; text-align:center">
                        <th>Opciones</th>
                        <th>Organismo</th>
                        <th>Gran Unidad</th>
                        <th>Descripción</th>
                        <th>Abreviatura</th>
                        <th>Departamento</th>
                        <th>Provincia</th>
                        <th>Tipo</th>
                        <th>Prioridad</th>
                        <th>Frontera</th>
                        <th>Orden</th>
                        <th>CodMindef</th>
                        <th>Observación</th>
                        <th>Ogd</th>
                        <th>Estado</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr v-for="destinos3 in arrayDestinos3" :key="destinos3.id">
                      <td style="width:100px; text-align:center">
                        <template v-if="destinos3.estado">
                          <button v-if="$auth.can('edit-destniv3')" type="button" @click="abrirEditar(destinos3)" class="btn btn-warning btn-sm" >
                            <i class="fas fa-edit"></i>
                          </button> &nbsp;
                          <button v-if="$auth.can('delete-destniv3')" type="button" class="btn btn-danger btn-sm" @click="DesactivarDestinos3(destinos3.id3)">
                            <i class="fas fa-trash"></i>
                          </button>
                        </template>
                        <template v-else>
                            <button v-if="$auth.can('delete-destniv3')" type="button" class="btn btn-secondary btn-sm" @click="ActivarDestinos3(destinos3.id3)">
                                <i class="far fa-times-circle"></i>
                            </button>
                        </template>
                      </td>
                      <td v-text="destinos3.descripcion1"></td>
                      <td v-text="destinos3.descripcion2"></td>
                      <td v-text="destinos3.descripcion3"></td>
                      <td v-text="destinos3.abreviatura"></td>
                      <td v-text="destinos3.depa_nombre"></td>
                      <td v-text="destinos3.prov_nombre"></td>
                      <td v-text="destinos3.tipo"></td>
                      <td v-text="destinos3.prioridad"></td>
                      <td v-text="destinos3.frontera"></td>
                      <td v-text="destinos3.orden"></td>
                      <td v-text="destinos3.cod_mindef"></td>
                      <td v-text="destinos3.observacion"></td>
                      <td v-text="destinos3.ogd"></td>
                      <td style="width:100px; text-align:center">
                          <div v-if="destinos3.estado">
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

      <div class="modal fade" id="NuevoDestinos3"> <!-- Modal para registro nuevo CERO -->
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">REGISTRAR NUEVA REPARTICIÓN</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
              <div class="form-group row"><!-- destino nivel 1 -->
                <div class="col-md-4">
                <label class="col-md-3 form-control-label" for="text-input">Organismo</label>
                  <select class="form-control" v-model="iddestino1" v-on:change="changeItem1(rowId, $event)" :class="{ 'is-invalid' : $v.iddestino1.$error, 'is-valid':!$v.iddestino1.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino1 in arrayDestinos1" :key="destino1.id" :value="destino1.id" v-text="destino1.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino1.required">Seleccione un valor porfavor</span>
                  </div>
                </div>

                <div class="col-md-8">
                <label class="col-md-6 form-control-label" for="text-input">Gran Unidad</label>
                  <select class="form-control" v-model="iddestino2" :class="{ 'is-invalid' : $v.iddestino2.$error, 'is-valid':!$v.iddestino2.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino2 in arrayDestinos2" :key="destino2.id" :value="destino2.id" v-text="destino2.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino2.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
              </div>

              <div class="form-group row"><!-- descripcion -->
                <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                <div class="col-md-12">
                  <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcion.$error, 'is-valid':!$v.descripcion.$invalid }" style="text-transform:uppercase" maxlength="300">
                  <div class="invalid-feedback">
                    <span v-if="!$v.descripcion.required">Este campo es Requerido</span>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-3"><!-- abreviatura -->
                  <label class="col-md-3 form-control-label" for="text-input">Abreviatura</label>
                  <input type="text" v-model="abreviatura" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.abreviatura.$error, 'is-valid':!$v.abreviatura.$invalid }" style="text-transform:uppercase" maxlength="300">
                  <div class="invalid-feedback">
                    <span v-if="!$v.abreviatura.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-3"><!-- departamento -->
                  <label class="col-md-3 form-control-label" for="text-input">Departamento</label>
                  <select class="form-control" v-model="departamento" v-on:change="changeItem2(rowId, $event)" :class="{ 'is-invalid' : $v.departamento.$error, 'is-valid':!$v.departamento.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.departamento.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-4"><!-- provincia -->
                  <label class="col-md-3 form-control-label" for="text-input">Provincia</label>
                  <select class="form-control" v-model="provincia" :class="{ 'is-invalid' : $v.provincia.$error, 'is-valid':!$v.provincia.$invalid }" placeholder="PROVINCIA">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.provincia.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="col-md-3 form-control-label" for="text-input">Tipo</label>
                  <select class="form-control" v-model="tipo" :class="{ 'is-invalid' : $v.tipo.$error, 'is-valid':!$v.tipo.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="AD">ADMINISTRATIVO</option>
                    <option value="OP">OPERATIVO</option>                                     
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.tipo.required">Este campo es Requerido</span>
                  </div>
                </div>
              
              </div>

              <div class="form-group row"><!-- prioridad -->
                <div class="col-md-3">
                  <label class="col-md-3 form-control-label" for="text-input">Prioridad</label>
                  <select class="form-control" v-model="prioridad" :class="{ 'is-invalid' : $v.prioridad.$error, 'is-valid':!$v.prioridad.$invalid }">
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
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.prioridad.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <label class="col-md-3 form-control-label" for="text-input">Frontera</label>
                  <select class="form-control" v-model="frontera" :class="{ 'is-invalid' : $v.frontera.$error, 'is-valid':!$v.frontera.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="1">SI</option>
                    <option value="0">NO</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.frontera.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="col-md-3 form-control-label" for="text-input">Orden</label>
                  <select class="form-control" v-model="orden" :class="{ 'is-invalid' : $v.orden.$error, 'is-valid':!$v.orden.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.orden.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="col-md-3 form-control-label" for="text-input">CodMinDef</label>
                  <input type="number" v-model="codmindef" class="form-control" placeholder="INGRESE CODIGO" :class="{ 'is-invalid' : $v.codmindef.$error, 'is-valid':!$v.codmindef.$invalid }"  maxlength="10">
                  <div class="invalid-feedback">
                    <span v-if="!$v.codmindef.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-2">
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

              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Observaciones</label>
                <div class="col-md-12">
                  <input class="form-control" v-model="observaciones" placeholder="Ingrese observaciones" style="text-transform:uppercase;" maxlength="300">
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="RegistrarDestino3()">Registrar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
            </div>
          </div>
            <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>
        <!-- /.modal -->

      <div class="modal fade" id="EditarDestinos3"> <!-- Modal para actualizar CERO-->
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">EDITAR REPARTICIÓN</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form-group row"><!-- destino nivel 1 -->
                <div class="col-md-4">
                <label class="col-md-3 form-control-label" for="text-input">Organismo</label>
                  <select class="form-control" v-model="iddestino1A" v-on:change="changeItem1(rowId, $event)" :class="{ 'is-invalid' : $v.iddestino1A.$error, 'is-valid':!$v.iddestino1A.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino1 in arrayDestinos1" :key="destino1.id" :value="destino1.id" v-text="destino1.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino1A.required">Seleccione un valor porfavor</span>
                  </div>
                </div>

                <div class="col-md-8">
                <label class="col-md-6 form-control-label" for="text-input">Gran Unidad</label>
                  <select class="form-control" v-model="iddestino2A" :class="{ 'is-invalid' : $v.iddestino2A.$error, 'is-valid':!$v.iddestino2A.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="destino2 in arrayDestinos2" :key="destino2.id" :value="destino2.id" v-text="destino2.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino2A.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
              </div>

              <div class="form-group row"><!-- descripcion -->
                <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                <div class="col-md-12">
                  <input type="text" v-model="descripcionA" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcionA.$error, 'is-valid':!$v.descripcionA.$invalid }" style="text-transform:uppercase" maxlength="300">
                  <div class="invalid-feedback">
                    <span v-if="!$v.descripcionA.required">Este campo es Requerido</span>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-3"><!-- abreviatura -->
                  <label class="col-md-3 form-control-label" for="text-input">Abreviatura</label>
                  <input type="text" v-model="abreviaturaA" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.abreviaturaA.$error, 'is-valid':!$v.abreviaturaA.$invalid }" style="text-transform:uppercase" maxlength="300">
                  <div class="invalid-feedback">
                    <span v-if="!$v.abreviaturaA.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-3"><!-- departamento -->
                  <label class="col-md-3 form-control-label" for="text-input">Departamento</label>
                  <select class="form-control" v-model="departamentoA" v-on:change="changeItem2(rowId, $event)" :class="{ 'is-invalid' : $v.departamentoA.$error, 'is-valid':!$v.departamentoA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="departamento in arrayDepartamento" :key="departamento.id" :value="departamento.id" v-text="departamento.nombre"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.departamentoA.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-4"><!-- provincia -->
                  <label class="col-md-3 form-control-label" for="text-input">Provincia</label>
                  <select class="form-control" v-model="provinciaA" :class="{ 'is-invalid' : $v.provinciaA.$error, 'is-valid':!$v.provinciaA.$invalid }" placeholder="PROVINCIA">
                    <option value="" disabled>SELECCIONE</option>
                    <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.provinciaA.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="col-md-3 form-control-label" for="text-input">Tipo</label>
                  <select class="form-control" v-model="tipoA" :class="{ 'is-invalid' : $v.tipoA.$error, 'is-valid':!$v.tipoA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="AD">ADMINISTRATIVO</option>
                    <option value="OP">OPERATIVO</option>                                     
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.tipoA.required">Este campo es Requerido</span>
                  </div>
                </div>
              
              </div>

              <div class="form-group row"><!-- prioridad -->
                <div class="col-md-3">
                  <label class="col-md-3 form-control-label" for="text-input">Prioridad</label>
                  <select class="form-control" v-model="prioridadA" :class="{ 'is-invalid' : $v.prioridadA.$error, 'is-valid':!$v.prioridadA.$invalid }">
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
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.prioridadA.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <label class="col-md-3 form-control-label" for="text-input">Frontera</label>
                  <select class="form-control" v-model="fronteraA" :class="{ 'is-invalid' : $v.fronteraA.$error, 'is-valid':!$v.fronteraA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="1">SI</option>
                    <option value="0">NO</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.fronteraA.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="col-md-3 form-control-label" for="text-input">Orden</label>
                  <select class="form-control" v-model="ordenA" :class="{ 'is-invalid' : $v.ordenA.$error, 'is-valid':!$v.ordenA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.ordenA.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="col-md-3 form-control-label" for="text-input">CodMinDef</label>
                  <input type="number" v-model="codmindefA" class="form-control" placeholder="INGRESE CODIGO" :class="{ 'is-invalid' : $v.codmindefA.$error, 'is-valid':!$v.codmindefA.$invalid }"  maxlength="10">
                  <div class="invalid-feedback">
                    <span v-if="!$v.codmindefA.required">Este campo es Requerido</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="col-md-3 form-control-label" for="text-input">Ogd</label>
                  <select class="form-control" v-model="ogdA" :class="{ 'is-invalid' : $v.ogdA.$error, 'is-valid':!$v.ogdA.$invalid }">
                    <option value="" disabled>SELECCIONE</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.ogdA.required">Este campo es Requerido</span>
                  </div>
                </div>
              </div>

              <div class="form-group row">
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
            arrayDestinos3 : [],

            iddestino2 : 0, //para el vue select
            arrayDestinos2 : [],
            
            iddestino1 : 0, //para el vue select
            arrayDestinos1 : [], //arreglo en vacio para almacenar el listado de los destinos1

            departamento : 0, //para el vue select
            arrayDepartamento : [], //arreglo en vacio para almacenar el listado de los destinos1

            provincia : 0, //para el vue select
            arrayProvincia : [], //arreglo en vacio para almacenar el listado de los destinos1

            // Valores para guardar
            descripcion : "",
            abreviatura : "",
            departamento : "",
            provincia : "",
            tipo : "",
            prioridad : "",
            frontera : "",
            orden : "",
            codmindef : "",
            observaciones : "",
            ogd : "",

            // valores para ACTUALZIZAR
            iddestino1A : 0,
            iddestino2A : 0,
            descripcionA : "",
            abreviaturaA : "",
            departamentoA : "",
            provinciaA : "",
            tipoA : "",
            prioridadA : "",
            fronteraA : "",
            ordenA : "",
            codmindefA : "",
            observacionesA : "",
            ogdA : "",
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
            criterio: 'nivel3_destinos.descripcion',

          }
        },

        validations:{
          iddestino1 : { required},
          iddestino2 : {required},
          descripcion: {required},
          abreviatura: {required},
          departamento: {required},
          provincia: {required},
          tipo: {required},
          prioridad: {required},
          frontera: {required},
          orden: {required},
          codmindef: {required},
          ogd: {required},


          iddestino1A : { required},
          iddestino2A : {required},
          descripcionA: {required},
          abreviaturaA: {required},
          departamentoA: {required},
          provinciaA: {required},
          tipoA: {required},
          prioridadA: {required},
          fronteraA: {required},
          ordenA: {required},
          codmindefA: {required},
          ogdA: {required},
          validationGroupReg: ['iddestino1', 'iddestino2','descripcion','abreviatura','departamento','provincia','tipo','prioridad','frontera','orden','codmindef','ogd'],
          validationGroupEdit: ['iddestino1A', 'iddestino2A','descripcionA','abreviaturaA','departamentoA','provinciaA','tipoA','prioridadA','fronteraA','ordenA','codmindefA','ogdA']
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

          listarDestinos3(page,buscar, criterio){
              let me = this;
              var url = '/listarDestino3?page=' + page + '&buscar=' + buscar.toUpperCase() + '&criterio=' + criterio;
              axios
              .get(url)
              .then(function (response) {
                  //Respuesta de la peticion
                  // //Para hacer prueba
                  var respuesta= response.data;
                  me.arrayDestinos3 = respuesta.destino3.data;
                  me.pagination = respuesta.pagination;
              })
              .catch(function (error) {
              // handle error
              console.log(error);
              });
          },

          Cerrar(){
            this.$v.$reset()
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

          selectDepartamento(){
            let me =this;
            var url='/departamento/selectDepartamento';
            axios.get(url).then(function (response) {
                // //para mostrar por consola el select
                var respuesta = response.data;
                me.arrayDepartamento = respuesta.departamento;
                //console.log(me.arrayDepartamento); 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
          },

          selectProvincia(){
            let me =this;
            var url='/provincia/selectProvincia';
            axios.get(url).then(function (response) {
                // //para mostrar por consola el select
                var respuesta = response.data;
                me.arrayProvincia = respuesta.provincia; 
              
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
            this.selectbuscarProvincia(event.target.value);
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

          selectbuscarProvincia(dest)
          {
              let me =this;
              me.buscarD= dest;
              me.arrayDdepartamento=[];
            //  me.prov_codigo=0;
              var url='/provincia/selectbuscarProvincia?buscar=' + dest;
              me.selected = url;
              axios.get(url).then(function (response) {

                var respuesta = response.data;
                  me.arrayProvincia = respuesta.provincia; 
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
            me.listarDestinos3(page,buscar,criterio);
          },

          NuevoDestinos3(){ //UNO
            this.selectDestinos1();
            this.selectDestinos2();
            this.selectDepartamento();
            this.selectProvincia();
            this.iddestino1 = "";
            this.iddestino2 = "";
            this.descripcion = "",
            this.abreviatura = "",
            this.departamento = "",
            this.provincia = "",
            this.tipo = "",
            this.prioridad = "",
            this.frontera = "",
            this.orden = "",
            this.codmindef = "",
            this.observaciones = "",
            this.ogd = "",
            this.selectbuscarDestinos2(this.iddestino1);
            $('#NuevoDestinos3').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
          },

          RegistrarDestino3(){ //DOS
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
                    axios
                    .post("/registrarDestino3", {
                      destn1: me.iddestino1,
                      destn2: me.iddestino2,
                      depa_cod : me.departamento,
                      prov_cod : me.provincia,
                      des: me.descripcion.toUpperCase(),
                      abreviatura : me.abreviatura.toUpperCase(),
                      tip : me.tipo,
                      pri: me.prioridad,
                      fro: me.frontera,
                      ord: me.orden,
                      cod: me.codmindef,
                      obs: me.observaciones.toUpperCase(),
                      ogd: me.ogd
                    })
                    .then(function (response) {
                        // //Para hacer la prueba que valores llegan
                        me.datos = response.data;
                        $('#NuevoDestinos3').modal('hide'); //nos permite cerrar
                        swal.fire(
                          "Aceptado", //TITULO
                          "Se añadio correctamente la Repartición", //TEXTO DE MENSAJE
                          "success" // TIPO DE MODAL (success, warnning, error, info)
                        );
                        me.listarDestinos3(1, '', 'descripcion1'); //Al momento de cerrar esto actualiza la lista
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

          abrirEditar(destinos3){ //UNO_1
            this.iddestino1A = destinos3.d1_cod,
            this.iddestino2A = destinos3.d2_cod,
            this.descripcionA = destinos3.descripcion3,
            this.abreviaturaA = destinos3.abreviatura,
            this.departamentoA = destinos3.depa_cod,
            this.provinciaA = destinos3.prov_cod,
            this.tipoA = destinos3.tipo,
            this.prioridadA = destinos3.prioridad,
            this.fronteraA = destinos3.frontera,
            this.ordenA = destinos3.orden,
            this.codmindefA = destinos3.cod_mindef,
            this.observacionesA = destinos3.observacion,
            this.ogdA = destinos3.ogd,
            this.id = destinos3.id3,
            this.selectDepartamento();
            this.selectbuscarProvincia(this.departamentoA);
            this.selectDestinos1();
            this.selectbuscarDestinos2(this.iddestino1A);
            $('#EditarDestinos3').modal('show');
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
                  axios
                  .put("/editarDestino3", { //Se pone put para el envio de datos
                      id: me.id,
                      destn1: me.iddestino1A,
                      destn2: me.iddestino2A,
                      depa_cod : me.departamentoA,
                      prov_cod : me.provinciaA,
                      des: me.descripcionA.toUpperCase(),
                      abreviatura : me.abreviaturaA.toUpperCase(),
                      tip : me.tipoA,
                      pri: me.prioridadA,
                      fro: me.fronteraA,
                      ord: me.ordenA,
                      cod: me.codmindefA,
                      obs: me.observacionesA.toUpperCase(),
                      ogd: me.ogdA
                  })
                  .then(function (response) {
                      //
                      me.datos = response.data;
                      $('#EditarDestinos3').modal('hide'); //nos permite cerrar
                      swal.fire(
                        "Aceptado", //TITULO
                        "Se modificó correctamente el Destino", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                      )
                      me.listarDestinos3(1, '', 'descripcion3'); //Al momento de cerrar esto actualiza la lista
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

          DesactivarDestinos3(id3){ //DOS_2
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
                .put("/desactivarDestino3", { //Se pone put para el envio de datos
                    'id':id3
                })
                .then(function (response) {
                    //
                    me.datos = response.data;
                    me.listarDestinos3(1, '', 'descripcion3'); //Al momento de cerrar esto actualiza la lista
                    swal.fire(
                        "Aceptado", //TITULO
                        "Se ha Desactivado el destino.", //TEXTO DE MENSAJE
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

          ActivarDestinos3(id3){ //DOS_2
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
                .put("/activarDestino3", { //Se pone put para el envio de datos
                    'id':id3
                })
                .then(function (response) {
                    // 
                    me.datos = response.data;
                    me.listarDestinos3(1, '', 'descripcion3'); //Al momento de cerrar esto actualiza la lista
                    
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

          BuscarDepartamento(depa_codigo){
            let me = this;
            //console.log(me.depa_codigo);
              axios
              .post("/departamento/selectbuscarDepartamento", {
                buscar: depa_codigo
              })
              .then(function (response) {
                me.departamento = response.data.departamento
                me.nombredpto = me.departamento[0]['nombre'];
              })    
              .catch(function (error) {
                // handle error
                console.log(error);
              })
            },

          BuscarProvincia(prov_codigo){
            let me = this;
            //console.log(me.depa_codigo);
              axios
              .post("/provincia/selectbuscarProv", {
                buscar: prov_codigo
              })
              .then(function (response) {
                me.provincia = response.data.provincia
                me.nombreprov = me.provincia[0]['nombre'];
              })    
              .catch(function (error) {
                // handle error
                console.log(error);
              })
          },


          GenerarPdfDestinos3(){
            window.open('http://sipefab.fab.bo/generarPdfDestinos3','_blank');
          }

        },

        mounted() {
            this.listarDestinos3(1, this.buscar, this.criterio); //Esto nos sirve para listar al principio la lista destinos
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