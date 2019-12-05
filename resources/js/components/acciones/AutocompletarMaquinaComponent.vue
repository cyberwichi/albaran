<template>
    <div class="card-body sombra">
        <div class="autocomplete form-group">
            <label for="querySearch">Maquina</label>
            <input
                @blur="onBlur = true"
                @focus="
                    onFocus = true;
                    onBlur = false;
                "
                class="form-control col-12"
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
                    v-for="(maquina, index) in maquinas"
                    @click="
                        querySearch = maquina.nombre;
                        idForm = maquina.id;
                        comentariosForm = maquina.comentarios;
                        onFocus = false;
                    "
                    :key="index"
                >
                    <strong>{{
                        maquina.nombre.substr(0, autocomplete.lenght)
                    }}</strong>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="comentarios">Comentarios</label>
            <input
                class="form-control  col-12"
                type="text"
                v-model="comentariosForm"
                name="comentarios"
                readonly
                autocomplete="off"
            />
        </div>
        <div class="form-group">
            <label for="referencia">Referencia</label>
            <input
                class="form-control  col-12"
                type="text"
                v-model="referenciaForm"
                name="referencia"               
                autocomplete="off"
            />
        </div>

        <button
            v-on:click="
                maquina.id = idForm;
                maquina.nombre = querySearch;
                maquina.referencia=referenciaForm;
                $emit('newmaquina', maquina);
                querySearch = '';
                comentariosForm = '';
                referenciaForm='';
            "
        >
            Añadir Maquina
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            idForm: "",
            maquina: {},
            querySearch: "",
            comentariosForm: "",
            maquinas: [],
            currentFocus: "",
            autocomplete: "",
            onBlur: true,
            onFocus: false,
            referenciaForm:"",
            
        };
    },
    mounted() {
        let vm = this;
        document.addEventListener("click", function(e) {
            vm.onBlur ? (vm.onFocus = false) : false;
        });
    },
    methods: {
        addActive() {
            let vm = this;
            if (!vm.maquinas) return false;
            if (vm.currentFocus >= vm.maquinas.length) vm.currentFocus = 0;
            if (vm.currentFocus < 0) vm.currentFocus = vm.maquinas.length - 1;
        },
        getResult() {
            this.maquinas = [];
            if (this.querySearch.length > 2) {
                document.getElementById("app").style.cursor = "progress";
                axios
                    .get("/api/searchmaquina/" + this.querySearch)
                    .then(response => {
                        response.data.forEach(maquina => {
                            this.maquinas.push(maquina);
                        });
                        document.getElementById("app").style.cursor = "auto";
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
