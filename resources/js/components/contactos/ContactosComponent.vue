<template>
  <div class>
    <div class="card">
      <div class="card-body">
        <nav aria-label="Page navigation example" class>
                    <ul class="pagination">
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != 1"
                                @click="page = 1"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/inicio.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != 1"
                                @click="page--"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/anterior.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-for="(pageNumber, index) in pages.slice(
                                    page - 1,
                                    page + 5
                                )"
                                @click="page = pageNumber"
                                :key="index"
                            >
                                {{ pageNumber }}
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                @click="page++"
                                v-if="page < pages.length"
                                class="page-link"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/siguiente.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item ">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != pages.length"
                                @click="page = pages.length"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/final.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                    </ul>
                </nav>
        <div class="card table-responsive">
          <table class="table">
            <thead class="card-header">
              <th>Id</th>
              <th>Nombre</th>
              <th>Direccion</th>
              <th>Nif</th>
              <th>Telefono</th>
              <th>Email</th>
              <th class="d-flex justify-content-around">
                <div>Borrar</div>
                <div>Editar</div>
              </th>
            </thead>
            <tbody class="card-footer">
              <responsecontacto-component
                v-for="(contacto,index) in contactosMostrados"
                :key="index"
                :contacto="contacto"
                @delete="borrarcontacto(contacto)"
                @guardar="actualizarcontacto(contacto)"
              ></responsecontacto-component>
            </tbody>
          </table>
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
      contacto: []
    };
  },
  mounted() {
    this.getContactos();
  },
  methods: {
    borrarcontacto(contacto) {
      document.getElementById("app").style.cursor = "progress";
      axios
        .get("/api/delcontactos/" + contacto.AutoId)
        .then(response => {
          
          function buscarregistro(objeto) {
            return contacto.AutoId == objeto.AutoId;
          }
          var found = this.contactos.findIndex(buscarregistro);
          this.contactos.splice(found, 1);
          paginate(this.contactos);
          document.getElementById("app").style.cursor = "auto";
        })
        .catch(e => {console.log(e);
        document.getElementById("app").style.cursor = "auto";});
    },

    getContactos() {
      document.getElementById("app").style.cursor = "progress";
      axios
        .get("/api/contactos")
        .then(response => {
          this.contactos = response.data;
          console.log(this.contactos);
          document.getElementById("app").style.cursor = "auto";
        })
        .catch(e => {console.log(e);
        document.getElementById("app").style.cursor = "auto";});
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

    actualizarcontacto(contacto) {
      document.getElementById("app").style.cursor = "progress";
      axios
        .put("/api/contactos/" + contacto.AutoId, contacto)
        .then(response => {
          this.contactos[contacto.AutoId] = response.data;
          document.getElementById("app").style.cursor = "auto";
        })
        .catch(e =>{ console.log(e);
        document.getElementById("app").style.cursor = "auto";});
    }
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
    width: 60px;
    height: 60px;
    
}
button.page-link {
    font-size: 11px;
    color: #2f3031;
    font-weight: 300;
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
