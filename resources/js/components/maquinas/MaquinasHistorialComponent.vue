<template>
    <div class>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <form>
                    <label for="referencia">
                        Numero de serie a Buscar
                    </label>
                    <input type="text" v-model="referencia" />
                    <button v-on:click.prevent="buscarreferencia">
                        Buscar
                    </button>
                </form>
                <div v-if="tiposdemaquina">
                    Encontradas {{ tiposdemaquina.length }} maquinas con este numero de serie
                    <div v-for="maq in tiposdemaquina" :key="maq.id">
                        <button class="text-uppercase" v-on:click.prevent="listamaquina(maq.id)">
                            {{ maq.nombre }}
                        </button>
                    </div>
                </div>
                <div v-else>
                    Ninguna maquina con este numero de serie
                </div>

                <div v-if="ver">
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
                                <th>Numero de Parte</th>
                                <th>Fecha</th>
                                <th class="d-flex justify-content-between">
                                    <div class="m-2">Ver Parte</div>
                                </th>
                            </thead>
                            <tbody class="table table-body card-body sombra">
                                <tr
                                    v-for="maquina in maquinasMostrados"
                                    :key="maquina.albaran_id"
                                >
                                    <td>
                                        {{ maquina.albaran_id }}
                                    </td>
                                    <td>
                                        {{
                                            maquina.created_at
                                                | moment("DD/MM/YYYY, h:mm a")
                                        }}
                                    </td>
                                    <td>
                                        <img
                                            class="m-3"
                                            src="/img/eye2.png"
                                            width="40px"
                                            height="40px"
                                            v-on:click="veralbaran(maquina.albaran_id)"
                                           
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        <vistaalbaran-component v-if="albaranver" :albaran="albaran"></vistaalbaran-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            referencia: "",
            tiposdemaquina: [],
            maquinas: [],
            maquinas2: [],
            page: 1,
            perPage: 9,
            pages: [],
            maquina: {},
            ver: null,
            albaran:[],
            albaranver:false,          
        };
    },
    mounted() {},
    methods: {
        veralbaran(id){
            /* axios.get("api/albaran/"+id).then(response=>{
                console.log(this.albaran);
                this.albaran=response.data[0];
                  console.log(this.albaran);
                this.albaranver=true;

            }) */
            window.open('/albaranes/parte'+id+'.pdf', '_blank','width=800,height=600');
        },
        buscarreferencia() {
            this.tiposdemaquina = [];  
            this.ver=null;  
            this.albaranver=false; 
            document.getElementById("app").style.cursor = "progress";
            if (this.referencia) {
                axios
                    .get("/api/maquinashistorial/" + this.referencia)
                    .then(response => {
                        this.maquinas = response.data;
                        let maquina_id = 0;
                        this.maquinas.forEach(element => {
                            if (element.maquina_id != maquina_id) {
                                maquina_id = element.maquina_id;
                                axios
                                    .get("/api/maquinas/" + element.maquina_id)
                                    .then(response => {
                                        this.tiposdemaquina.push(response.data);
                                        document.getElementById(
                                            "app"
                                        ).style.cursor = "auto";
                                    });
                                
                            }
                            
                        });
                        document.getElementById("app").style.cursor =
                                    "auto";
                    });

            } else {
                document.getElementById("app").style.cursor = "auto";
            }
        },
        listamaquina(id) {
            this.maquinas2 = [];
            
            this.maquinas.forEach(element => {
                if (element.maquina_id == id) {
                    this.maquinas2.push(element);
                }
            });
            this.ver = true;
        },
        setPages() {
            this.pages=[];
            let numberOfPages = Math.ceil(this.maquinas2.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate(maquinas2) {
            let page = this.page;
            let perPage = this.perPage;
            let from = page * perPage - perPage;
            let to = page * perPage;

            return maquinas2.slice(from, to);
        }
    },
    computed: {
        maquinasMostrados() {
            return this.paginate(this.maquinas2);
        }
    },
    watch: {
        maquinas2() {
            this.setPages();
        },
       
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
