<template>
    <div class="">
        <div class="card">
            <div class="card-body">
                <form
                    action=""
                    v-on:submit.prevent="nuevoEmpleado()"
                    class="card"
                >
                    <div class="card-body sombra">
                        <div class="form-group">
                            <label for="name">Nombre Empleado</label>
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                v-model="name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input
                                type="text"
                                class="form-control"
                                name="telefono"
                                v-model="telefono"
                            />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                name="email"
                                v-model="email"
                            />
                        </div>
                        <div class="form-group">
                            <h5 class="text-center">
                                Activo
                                <input
                                    type="checkbox"
                                    class="form-control"
                                    name="activo"
                                    v-model="activo"
                                />
                            </h5>

                            <div
                                v-bind:class="[
                                    activo ? terminado : noterminado,
                                    'form-control'
                                ]"
                            ></div>
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
            name: "",
            telefono: "",
            activo: true,
            email:"",
            noterminado: "bg-danger",
            terminado: "bg-success"
        };
    },
    methods: {
        nuevoEmpleado() {
            let empleado = {
                name: this.name,
                telefono: this.telefono,
                activo: this.activo,
                email:this.email,
                appcode:''
            };
            document.getElementById("app").style.cursor = "progress";
            axios.post("/api/empleados", empleado).then(response => {
                empleado.Id = response.data.Id;
                document.getElementById("app").style.cursor = "auto";
            });

            this.$emit("new", empleado);
            this.name = "";
            this.telefono = "";
            this.activo = true;
            this.email="";
        }
    }
};
</script>
