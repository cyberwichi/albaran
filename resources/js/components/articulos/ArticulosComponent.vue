<template>
    <div class>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <nav aria-label="Page navigation example" class>
                    <ul :key="page" class="pagination">
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
                    <table class="table table-table-striped ">
                        <thead class="table table-header card-header">
                            <th>Id</th>
                            <th>Nombre</th>
                            <th class="text-right">Precio</th>
                            <th class="text-right">Stock</th>
                            <th class="text-right">Fecha Alta</th>
                            <th class="d-flex justify-content-between">
                                <div class="m-2">Borrar</div>
                                <div class="m-2">Editar</div>
                            </th>
                        </thead>
                        <tbody class="table table-body card-body sombra">
                            <response-component
                                v-for="(articulo) in articulosMostrados"
                                :key="articulo.AutoId"
                                :articulo="articulo"
                                @delete="borrararticulo(articulo)"
                                @guardar="actualizararticulo(articulo)"
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
            perPage: 9,
            pages: [],
            articulo: []
        };
    },
    mounted() {
        this.getArticulos();
    },
    methods: {
        borrararticulo(articulo) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/delarticulos/" + articulo.Id)
                .then(response => {                   
                    function buscarregistro(objeto) {
                        return articulo.Id == objeto.Id;
                    }
                    var found = this.articulos.findIndex(buscarregistro);
                    this.articulos.splice(found, 1);
                    this.paginate(this.articulos);
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },

        getArticulos() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/articulos")
                .then(response => {
                    this.articulos = response.data;
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
        },      
        guardararticulo(articulo) {
            this.articulos.push(articulo);
        },

        actualizararticulo(articulo) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .put("/api/articulos/" + articulo.Id, articulo)
                .then(response => {
                    this.articulos[articulo.Id] = response.data;
                    this.paginate(this.articulos);
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
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
    font-weight: 300;
}
.offset {
    width: 500px !important;
    margin: 20px auto;
}
</style>
