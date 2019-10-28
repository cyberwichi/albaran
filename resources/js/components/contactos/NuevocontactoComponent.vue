<template> 

 <div class="">
    <div class="card">
    
    <div class="card-body">
      <form action="" v-on:submit.prevent="nuevoContacto()" class="card">
        
      <div class="card-body sombra">
          <div class="form-group">
          <label for="nombre">Nombre Contacto</label>
          <input type="text" class="form-control" name="nombre" v-model="nombreformulario"/>
        </div>
        <div class="form-group">
          <label for="direccion">Direccion</label>
          <input type="text" class="form-control" name="direccion" v-model="direccionformulario"/>
        </div>
      </div>
      <div class="text-center">
         <button type="submit" class="btn btn-primary w-50 mt-3 center">guardar</button>

      </div>

       
       
        
      </form>
    </div>
  </div>
 </div>
</template>

<script>
export default {
  data: function() {
    return {
      
      nombreformulario:"",
      direccionformulario:"",
   
    };
  },
  methods: {
    nuevoContacto(){
      let contacto={
        Id:'',
        Nombre:this.nombreformulario,
        Direccion:this.direccionformulario,
        
      }
      axios.post('/api/contactos', contacto).then(response=>contacto.Id=response.data.Id);
      
      this.$emit('new', contacto);
      this.nombreformulario="";
      this.direccionformulario="";
      
      this.vermas=false;

    },


  }
}
</script>
