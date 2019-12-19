<template>
    <div class>
        <div class="card bg-light mb-3">
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
                <div class="card  table-responsive">
                    <table class="table table-table-striped">
                        <thead class="card-header table-header">
                            <th>Id</th>
                            <th>Nombre</th>
                            <th class="text-right">Unidades en Almacen</th>
                            <th class="text-right">Unidades Pedidas</th>                          
                        </thead>
                        <tbody class="card-footer table-body">
                            <responsestock-component
                                v-for="(articulo) in articulosMostrados"
                                :key="articulo.AutoId"
                                :articulo="articulo"
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
            articulo: {}
        };
    },
    beforeMount() {
        this.getArticulos();
    },
    methods: {
        getArticulos() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/stock")
                .then(response => {
                    this.articulos = response.data;
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
            axios
                .get("/api/articulos")
                .then(response => {
                    this.articulosNombre = response.data;
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
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
</style>
