<template>
    <tr class="linea">
        <td>
            <p>{{ albaran.id }}</p>
        </td>
        <td>
            <p v-if="albaran.aviso">{{ albaran.aviso.tb_contacto.Nombre }}</p>
            <p v-else>CLIENTE NO REGISTRADO VER PARTE</p>

        </td>
        <td>
            <p>{{ albaran.aviso_id }}</p>
        </td>
        <td class>
            <p>{{ albaran.created_at | moment("DD/MM/YYYY, h:mm a") }}</p>
        </td>
        <td class>
            <p>{{ albaran.observaciones }}</p>
        </td>

        <td>
            <div class="botonesaccion d-flex justify-content-around">
                <img
                    class="mr-4"
                    src="/img/Delete.png"
                    width="20px"
                    height="20px"
                    v-on:click="borraralbaran()"
                />
                <img
                    v-scroll-to="'#albaran'"
                    class="mr-4"
                    src="/img/eye2.png"
                    width="20px"
                    height="20px"
                    alt
                    v-on:click="editaralbaran()"
                />
                <a v-on:click="enviar()">
                    <img
                        v-scroll-to="'#albaran'"
                        class="mr-4"
                        src="/img/sendmail.png"
                        width="20px"
                        height="20px"
                    />
                </a>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    props: ["albaran"],
    data() {
        return {
            flageditar: false,
            noterminado: "bg-danger",
            terminado: "bg-success",
            terminado2: "hidden",
            terminado3: "bg-primary"
        };
    },
    mounted() {},
    methods: {
        borraralbaran() {
            this.$emit("delete", this.albaran);
        },
        editaralbaran() {
            (this.flageditar = true), this.$emit("ver", this.albaran);
        },
        guardaralbaran() {
            (this.flageditar = false), this.$emit("guardar", this.albaran);
        },
        enviar() {
       
            axios.get("/api/enviar/" + this.albaran.id).then(
                response=>{
                   this.$emit("mensaje", "Envio Correcto"); 
                }
            );
        }
    },
    computed: {},
    watch: {},

    filters: {}
};
</script>
<style scoped>
.linea td{
    padding: 1px;
}
</style>
