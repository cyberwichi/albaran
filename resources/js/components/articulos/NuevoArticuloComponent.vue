<template>
  <div> 
    <div class="card">
      
      <div class="card-body">
        <form action v-on:submit.prevent="nuevoArticulo()" class="card">
          <div class="card-body sombra">
            <div class="form-group">
              <label for="nombre">Nombre Articulo</label>
              <input type="text" class="form-control" name="nombre" v-model="nombreformulario" />
            </div>
            <div class="form-group">
              <label for="upc">UPC</label>
              <input type="text" class="form-control" name="upc" v-model="upcformulario" />
            </div>
            <div class="form-group">
              <label for="fechaalta">Fecha Alta</label>
              <input
                type="datetime-local"
                class="form-control"
                name="fechaalta"
                v-model="fechaaltaformulario"
              />
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
      nombreformulario: "",
      upcformulario: "",
      fechaaltaformulario: "",
  
    };
  },
  methods: {
    nuevoArticulo() {
      let articulo = {
        Id: "",
        Nombre: this.nombreformulario,
        Upc: this.upcformulario,
        fechaalta: this.fechaaltaformulario
      };
      axios
        .post("/api/articulos", articulo)
        .then(response => (articulo.Id = response.data.Id));
      this.$emit("new", articulo);

      this.nombreformulario = "";
      this.upcformulario = "";
      this.fechaaltaformulario = "";
      this.vermas = false;
    },
   
  }
};
</script>
