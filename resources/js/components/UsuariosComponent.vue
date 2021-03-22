
<template>
   <div class="card" style="background-color: #fff">
        <div class="card-header bg-primary mb-3">
            <h3 class="text-left">Gestionar Usuarios<button @click="modificar=false; abrirModal();" type="button" class="btn btn-light float-right">Nuevo Usuario</button></h3>
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
              <label>Nombre</label>
              <input  v-model="usuarios.name" type="text" class="form-control" id="name" placeholder="Nombre del usuario">
            </div>
            <div class="my-4">
              <label>Email</label>
              <input v-model="usuarios.email" type="text" class="form-control" id="email" placeholder="Ingrese una direccion de email">
            </div>
             <div class="my-4">
              <label>Password</label>
              <input v-model="usuarios.password" type="password" class="form-control" id="password" placeholder="Ingrese una contraseña">
            </div>
            <div class="my-4">
              <label>Rol</label>
                 <div v-if="usuarios.rol == '1'">
                    <select id="rol" v-model="usuarios.rol" class="form-control">
                         <option  value='1' selected>Administrador</option> 
                         <option  value='2'>Usuario</option> 
                    </select>
                </div>
                <div v-else-if="usuarios.rol == '2'">
                    <select id="rol" v-model="usuarios.rol" class="form-control">
                        <option  value='1'>Administrador</option> 
                        <option  value='2' selected>Usuario</option> 
                    </select>
                </div>
                <div v-else>
                    <select id="rol" v-model="usuarios.rol " class="form-control">
                        <option disabled value="">Elige un rol para el usuario..</option>
                        <option value=1>Administrador</option> 
                        <option value=2>Usuario</option> 
                    </select>
                </div>              
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
          <th>Email</th>
          <th>Rol</th>
          <th>Accion</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="users in user" :key="users.id">
          <th scope="row">{{ users.id }}</th>
          <td>{{ users.name }}</td>
          <td>{{ users.email }}</td>
          <td>{{ users.roles[0].name }}</td>
          <td>
            <button  @click="modificar=true; abrirModal(users);" class="btn btn-secondary btn-sm">Editar</button>
            <button @click="eliminar(users.id)" class="btn btn-danger btn-sm">Eliminar</button>
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
        usuarios:{
        name:'',
        email:'',
        password:'',
        rol:'',
        },
        id:0,
        modificar:true,
        modal:0,
        tituloModal:'',
        user:[],
        
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

    async listar() {
      const res = await axios.get('/user-tabla');
      this.user = res.data;
      this.tabla();
    },

    async eliminar(id) {
      const res = await axios.put('/usuarios/' + id);
      swal("Exito!", "El Usuario se ha eliminado!", "success");
      this.listar();
    },

    async guardar() {
      if(this.modificar){

        const res = await axios.put('/usuarios/'+this.id, this.usuarios);
        swal("Exito!", "El Usuario se ha editado!", "success");
        
      }else{
       
         await axios.post('/usuarios', this.usuarios).then(res=>{ 
                 this.cerrarModal();
                 this.listar();
                 swal("Exito!", "El Usuario se ha creado!", "success");}).catch(function (error){
                     var array = Object.values(error.response.data.errors)
                     array.forEach(element => swal(String(element)))
                     console.log(array)
                 });
      }
     
    },

      abrirModal(data={}){
      this.modal=1;
      if(this.modificar){
        this.id=data.id;
        this.tituloModal="Modificar Usuario";
        this.usuarios.name=data.name;
        this.usuarios.email=data.email;
        this.usuarios.password=data.password;
        this.usuarios.rol=data.roles[0].id;
      }else{
        this.id=0;
        this.tituloModal="Crear Usuario";
        this.usuarios.name='';
        this.usuarios.email='';
        this.usuarios.password='';
        this.usuarios.rol='';
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
