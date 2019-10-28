<template>
  <div class>
   
    <div class="card">
    

      <div  class="card-body">
        
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <button type="button" class="page-link" v-if="page != 1" @click="page--">Anterior</button>
              </li>
              <li class="page-item">
                <button
                  type="button"
                  class="page-link"
                  v-for="pageNumber in pages.slice(page-1, page+5)"
                  @click="page = pageNumber"
                >{{pageNumber}}</button>
              </li>
              <li class="page-item">
                <button
                  type="button"
                  @click="page++"
                  v-if="page < pages.length"
                  class="page-link"
                >Siguiente</button>
              </li>
            </ul>
          </nav>
          <div class="card">
            <table class="table">
              <thead class="card-header">
                <td>Id</td>
                <td>Nombre</td>
                <td>Direccion</td>
                <td>Borrar / Editar</td>
              </thead>
              <tbody class="card-body sombra">
                <responsecontacto-component
                  v-for="(contacto,index) in contactosMostrados"
                  :key="index"
                  :contacto="contacto"
                  @delete="borrarcontacto(contacto)"
                  @guardar="actualizarcontacto(index, contacto)"
                ></responsecontacto-component>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editionFlag: true,
      contactos: [],
      page: 1,
      perPage: 9,
      pages: [],
      contacto: [],

    };
  },
  mounted() {
    this.getContactos();
  },
  methods: {
    borrarcontacto(contacto) {
       axios
        .get("/api/delcontactos/" + contacto.AutoId)
        .then(response => {
          console.log(response);
          function buscarregistro(objeto) {
            return contacto.AutoId == objeto.AutoId;
          }
          var found = this.contactos.findIndex(buscarregistro);
          this.contactos.splice(found, 1);
          paginate(this.contactos);
        })
        .catch(e => console.log(e));
    },
    
    getContactos() {
      axios
        .get("/api/contactos")
        .then(response => {
          this.contactos = response.data;
        })
        .catch(e => console.log(e));
    },
    setPages() {
      let numberOfPages = Math.ceil(this.contactos.length / this.perPage);
      for (let index = 1; index <= numberOfPages; index++) {
        this.pages.push(index);
      }
    },
    paginate(contactos) {
      let page = this.page;
      let perPage = this.perPage;
      let from = page * perPage - perPage;
      let to = page * perPage;

      return contactos.slice(from, to);
    },

    editarcontacto(index) {
      this.editionFlag = false;
    },
    guardarcontacto(contacto) {
      this.contactos.push(contacto);
    },

    actualizarcontacto(index, contacto) {
      
       axios
        .put("/api/contactos/"+contacto.AutoId, contacto)
        .then(response => {
          this.contactos[index] = response.data;
        })
        .catch(e => console.log(e));
    },
    

  },
  computed: {
    contactosMostrados() {
      return this.paginate(this.contactos);
    }
  },
  watch: {
    contactos() {
      this.setPages();
    }
  },

  filters: {
    trimWords(value) {
      return (
        value
          .split(" ")
          .splice(0, 20)
          .join(" ") + "..."
      );
    }
  }
};
</script>
<style scoped>
button.page-link {
  display: inline-block;
}
button.page-link {
  font-size: 20px;
  color: #29b3ed;
  font-weight: 500;
}
.offset {
  width: 500px !important;
  margin: 20px auto;
}
tr {
  padding: 15px;
}
td {
  padding: 5px;
}
</style>
