<template>
    <div class="">
        <div class="card">
            <div class="card-body">
                <form
                    action=""
                    v-on:submit.prevent="nuevoContacto()"
                    class="card"
                >
                    <div class="card-body sombra">
                        <div class="form-group">
                            <label for="nombre">Nombre Cliente</label>
                            <input
                                type="text"
                                class="form-control"
                                name="nombre"
                                v-model="nombreformulario"
                            />
                        </div>
                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <input
                                type="text"
                                class="form-control"
                                name="direccion"
                                v-model="direccionformulario"
                            />
                        </div>
                        <div class="form-group">
                            <label for="nif">Nif</label>
                            <input
                                type="text"
                                class="form-control"
                                name="nif"
                                v-model="nifformulario"
                            />
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input
                                type="text"
                                class="form-control"
                                name="telefono"
                                v-model="telefonoformulario"
                            />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                v-model="emailformulario"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn  mt-3 center">
                            <img src="/img/Save.png" width="50px" alt />
                        </button>
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
            direccionformulario: "",
            nifformulario: "",
            telefonoformulario:'',
            emailformulario:''

        };
    },
    methods: {
        nuevoContacto() {
            let contacto = {
                Id: "",
                Nombre: this.nombreformulario,
                Direccion: this.direccionformulario,
                Nif: this.nifformulario,
                Telefono: this.telefonoformulario,
                Email: this.emailformulario
            };
            document.getElementById("app").style.cursor = "progress";
            axios.post("/api/contactos", contacto).then(response => {
                contacto.Id = response.data.Id;
                document.getElementById("app").style.cursor = "auto";
            });

            this.$emit("new", contacto);
            this.nombreformulario = "";
            this.direccionformulario = "";
            this.nifformulario = "";
            this.telefonoformulario = "";
            this.emailformulario = "";
            this.vermas = false;
        }
    }
};
</script>
