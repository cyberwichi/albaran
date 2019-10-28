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
                :key="pageNumber"
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
            <thead class="card-header table-header">
              <th>Id</th>
              <th>Nombre</th>
              <th class="text-right">Unidades en Almacen</th>
              <th class="text-right">Unidades Pedidas</th>
              <th class="text-right">Unidades Compradas</th>
           
            </thead>
            <tbody class="card-body sombra table-body">
              <responsestock-component
                v-for="(articulo,index) in articulosMostrados"
                :key="articulo.Id"
                :articulo="articulo"
                :articuloNombre="articulosNombre[((index)+perPage*(page-1))]"
              ></responsestock-component>
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
      articulo: {},
      articulosNombre: []
    };
  },
  beforeMount() {
    this.getArticulos();
  },
  methods: {
    getArticulos() {
      axios
        .get("/api/stock")
        .then(response => {
          this.articulos = response.data;
        })
        .catch(e => console.log(e));
      axios
        .get("/api/articulos")
        .then(response => {
          this.articulosNombre = response.data;          
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
  font-size: 14px;
  color: #282a2a;
  font-weight: 200;
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
