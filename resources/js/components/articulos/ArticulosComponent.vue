<template>
  <div class>
    <div class="card bg-light mb-3">
      <div class="card-body">
        <nav aria-label="Page navigation example" class>
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
          <table class="table table-table-striped table-responsive">
            <thead class="table table-header card-header">
              <th>Id</th>
              <th>Nombre</th>
              <th class="text-right">UPC</th>
              <th class="text-right">fecha Alta</th>
              <th>Borrar / Editar</th>
              
            </thead>
            <tbody class="table table-body card-body sombra">
              <response-component
                v-for="(articulo,index) in articulosMostrados"
                :key="index"
                :articulo="articulo"
                @delete="borrararticulo(articulo)"
                @guardar="actualizararticulo(index, articulo)"
              ></response-component>
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
      articulos: [],
      page: 1,
      perPage: 5,
      pages: [],
      articulo: []
    };
  },
  mounted() {
    this.getArticulos();
  },
  methods: {
    borrararticulo(articulo) {
    
      axios
        .get("/api/delarticulos/" + articulo.AutoId)
        .then(response => {
          console.log(response);
          function buscarregistro(objeto) {
            return articulo.AutoId == objeto.AutoId;
          }
          var found = this.articulos.findIndex(buscarregistro);
          this.articulos.splice(found, 1);
          paginate(this.articulos);
        })
        .catch(e => console.log(e));
    },

    getArticulos() {
      axios
        .get("/api/articulos")
        .then(response => {
          this.articulos = response.data;
        })
        .catch(e => console.log(e));
    },
    setPages() {
      let numberOfPages = Math.ceil(this.articulos.length / this.perPage);
      for (let index = 1; index <= numberOfPages; index++) {
        this.pages.push(index);
      }
    },
    paginate(articulos) {
      let page = this.page;
      let perPage = this.perPage;
      let from = page * perPage - perPage;
      let to = page * perPage;

      return articulos.slice(from, to);
    },

    /* editararticulo(index) {
      this.editionFlag = false;
      
    }, */
    guardararticulo(articulo) {
      this.articulos.push(articulo);
    },

    actualizararticulo(index, articulo) {     
      axios
        .put("/api/articulos/"+articulo.AutoId, articulo)
        .then(response => {
          this.articulos[index] = response.data;
        })
        .catch(e => console.log(e));
    }
  },
  computed: {
    articulosMostrados() {
      return this.paginate(this.articulos);
    }
  },
  watch: {
    articulos() {
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
  font-size: 15px;
  color: #2f3031;
  font-weight: 500;
}
.offset {
  width: 500px !important;
  margin: 20px auto;
}
tr {
}
td {
}
</style>
