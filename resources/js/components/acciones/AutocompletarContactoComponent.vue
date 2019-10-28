<template>
 
  <div class="card-body sombra">
    <div class="autocomplete form-group">
      <label for="querySearch">Cliente</label>
      <input
        @blur="onBlur=true"
        @focus="onFocus=true;onBlur=false "
        class="form-control input"
        type="text"
        v-model="querySearch"
        name="querySearch"
        v-on:keyup="getResult()"
        v-on:keydown="keyDown"
        placeholder=""
        autocomplete="off"
      />
      <div class="autocomplete-items" v-if="onFocus">
        <div
          v-for="(contacto, index) in contactos"
          @click="querySearch=contacto.Nombre;direccionForm=contacto.Direccion;telefonoForm=contacto.Telefono;onFocus=false;"
          :key="index"
        >
          <strong>{{contacto.Nombre.substr(0,autocomplete.lenght)}}</strong>
        </div>
      </div>
      
    </div>
    <div class="form-group">
      <label for="direccion">Direccion</label>
      <input        
        class="form-control input"
        type="text"
        v-model="direccionForm"
        name="direccion"

        autocomplete="off"
      />
    </div>
     <div class="form-group">
          <label for="telefono">Telefono</label>
          <input type="text" class="form-control input" name="telefono" v-model="telefonoForm" autocomplete="off"/>
        </div>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      querySearch: "",
      contactos: [],
      currentFocus: '',
      autocomplete: "",
      onBlur: true,
      onFocus: false,
      upcForm:'',
      direccionForm:'',
      telefonoForm:'',
    };
  },
  mounted() {
    var vm = this;
    document.addEventListener("click", function(e) {
      vm.onBlur ? (vm.onFocus = false) : false;
    });
  },
  methods: {
    addActive() {
      var vm = this;
      if (!vm.contactos) return false;
      if (vm.currentFocus >= vm.contactos.length) vm.currentFocus = 0;
      if (vm.currentFocus < 0) vm.currentFocus = vm.contactos.length - 1;
    },
    getResult() {
      this.contactos = [];
      if (this.querySearch.length > -1) {
        axios.get("/api/searchcontacto/" + this.querySearch).then(response => {
           console.log(response.data);
          response.data.forEach(contacto => {
            this.contactos.push(contacto);
           
          });
        });
      }
    },
    keyDown(e) {
      var vm = this;
      
      if (e.keycode == 40) {
        vm.currentFocus++;
        vm.addActive();
      } else if (e.keyCode == 38) {
        vm.currentFocus--;
        vm.addActive();
      }
    }
  }
};
</script>