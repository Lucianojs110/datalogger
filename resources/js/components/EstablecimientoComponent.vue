
<template>

  
  
  <div class="card" style="background-color: #fff">
        <div class="card-header bg-primary mb-3">
            <h3 class="text-left">Gestionar Establecimientos <button @click="modificar=false; abrirModal();" type="button" class="btn btn-light float-right">Nuevo Establecimiento</button></h3>
        </div>
   <div class="container p-2 my-2">

 


    <!-- The Modal -->
    <div class="modal" :class="{mostrar: modal}">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{tituloModal}}</h4>
            <button @click="cerrarModal();"  type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="my-4">
              <label for="nombre">Nombre</label>
              <input v-model="establecimiento.nombre" type="text" class="form-control" id="nombre" placeholder="Nombre ">
            </div>
            <div class="my-4">
              <label for="descripcion">descripcion</label>
              <input v-model="establecimiento.descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripcion">
            </div>
            <div class="my-4">
              <label for="ubicacion">Ubicación</label>
              <input v-model="establecimiento.ubicacion" type="text" class="form-control" id="ubicacion" placeholder="Ubicacion">
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button @click="cerrarModal();" type="button" class="btn btn-secondary" data-dismiss="modal">
              Cancelar
            </button>
            <button  @click="guardar();" type="button" class="btn btn-success" data-dismiss="modal">
              Guardar
            </button>
          </div>
        </div>
      </div>
    </div>
    <table class="table" id="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Ubicación</th>
          <th width="200px">Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="esta in est" :key="esta.id">
          <th scope="row">{{ esta.id }}</th>
          <td>{{ esta.nombre }}</td>
          <td>{{ esta.descripcion }}</td>
          <td>{{ esta.ubicacion }}</td>
          <td>
            <button  @click="modificar=true; abrirModal(esta);" class="btn btn-secondary btn-sm">Editar</button>
            <button @click="eliminar(esta.id)" class="btn btn-info btn-sm"> Configurar</button>
            <button @click="eliminar(esta.id)" class="btn btn-danger btn-sm"> Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </div>
</template>

<script>
import swal from 'sweetalert';
export default {
  data() {
    return {
        establecimiento:{
        nombre:'',
        descripcion:'',
        ubicacion:'',
        },
        id:0,
        modificar:true,
        modal:0,
        tituloModal:'',
        est:[],
    };
  },
  methods: {
     tabla() {
        this.$nextTick(()=>{ $('#table').DataTable(
        {"language":{
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }});
        });
    },  

    listar() {
      axios.get('/est-tabla').then(res=>{
      this.est = res.data;
      $('#table').DataTable().destroy();
      this.tabla();
       });
    },

      

    eliminar(id) {
      swal({
        title: 'Esta seguro?',
        text: 'Este archivo sera eliminado definitavemente!',
        icon: 'warning',
        buttons: ["Cancelar", "Si!"],
        }).then((willDelete)=> {
        if (willDelete) {
                 axios.delete('/establecimientos/'+id).then(res=>{
                  this.listar() 
                  swal("Exito!", "El establecimiento se ha eliminado!", "success");
                 }).catch(function (error){
                     var array = Object.values(error.response.data.errors)
                     array.forEach(swal(String(array)))    
                 });        
        } 
    });
    },
    

    guardar() {
      if(this.modificar){
         axios.put('/establecimientos/'+this.id, this.establecimiento).then(res=>{ 
                 this.cerrarModal();
                 this.listar();
                 swal("Exito!", "El establecimiento se ha editado!", "success");}).catch(function (error){
                     var array = Object.values(error.response.data.errors+'<br>')
                     array.forEach(swal(String(array)))
                 });
        
      }else{
         axios.post('/establecimientos', this.establecimiento).then(res=>{ 
                 this.cerrarModal();
                 this.listar();
                 swal("Exito!", "El establecimiento se ha creado!", "success");}).catch(function (error){
                     var array = Object.values(error.response.data.errors)
                     array.forEach(swal(String(array)))
                 });
     
      }
      
    },

      abrirModal(data={}){
      this.modal=1;
      if(this.modificar){
        this.id=data.id;
        this.tituloModal="Modificar Establecimiento";
        this.establecimiento.nombre=data.nombre;
        this.establecimiento.descripcion=data.descripcion;
        this.establecimiento.ubicacion=data.ubicacion;
      }else{
        this.id=0;
        this.tituloModal="Crear Establecimiento";
        this.establecimiento.nombre='';
        this.establecimiento.descripcion='';
        this.establecimiento.ubicacion='';
      }
    },
  
    cerrarModal(){
      this.modal=0;
    },
   
  },

   
   created() {
    this.listar();
  },
 
};
</script>

<style>
  .mostrar{
    display: list-item;
    opacity: 1;
    background: rgba(75, 56, 143, 0.705);
  }
</style>
