
<template>
  <div>
    <h1 class="text-center">Gestionar Establecimientos</h1>
    <hr>


     <!-- Button to Open the Modal -->
    <button @click="modificar=false; abrirModal();" type="button" class="btn btn-primary my-4">Nuevo</button>

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
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Ubicación</th>
          <th scope="col" colspan="2" class="text-center">Accion</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="users in user" :key="users.id">
          <th scope="row">{{ users.id }}</th>
          <td>{{ users.name }}</td>
          <td>{{ users.email }}</td>
          <td>{{ users.rol }}</td>
          <td>
               <button  @click="modificar=true; abrirModal(esta);" class="btn btn-secondary">Editar</button>
            <button @click="eliminar(esta.id)" class="btn btn-danger">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
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
    async listar() {
      const res = await axios.get('/est-tabla');
      this.est = res.data;
    },

    async eliminar(id) {
      const res = await axios.put('/establecimientos/' + id);
      swal("Exito!", "El establecimiento se ha eliminado!", "success");
      this.listar();
    },

    async guardar() {
      if(this.modificar){
        const res = await axios.put('/establecimientos/'+this.id, this.establecimiento);
        swal("Exito!", "El establecimiento se ha editado!", "success");
      }else{
        const res = await axios.post('/establecimientos', this.establecimiento);
        swal("Exito!", "El establecimiento se ha creado!", "success");
      }
      this.cerrarModal();
      this.listar();
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
    background: rgba(131, 145, 146, 0.705);
  }
</style>
