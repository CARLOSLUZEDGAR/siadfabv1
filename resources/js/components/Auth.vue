<template>
    <div class="login-dark">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
                <!-- <i class="icon ion-ios-locked-outline"></i> -->
            </div>
            <div class="form-group">
                <input
                class="form-control"
                type="email"
                name="email"
                placeholder="Email"
                v-model="fillLogin.cEmail"
                />
            </div>
            <div class="form-group">
                <input
                class="form-control"
                type="password"
                name="password"
                placeholder="Password"
                v-model="fillLogin.cContraseña"
                />
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit" @click.prevent="login()" >Ingresar</button>
            </div>
        </form>
    </div>   
   
</template>

<script>
export default {
  data() {
    return {
      fillLogin: {
        cEmail: "",
        cContraseña: "",
      },
      error: 0,
      permisos: [],
      
    };
  },
  methods: {
      login(){
        let me = this;
        if (me.validarLogin()) {
            return;
        }
        me.opcionesToastr();
        axios
            .post("/authenticate/ingreso", {
                email: me.fillLogin.cEmail,
                password: me.fillLogin.cContraseña
            })
            .then(function (response) {
                
                // if (response.data.code == 400) {
                //     console.log(response);
                //     toastr.error('El usuario ya inicio sesión, cierre su sesión anterior.')
                //     me.fillLogin.cContraseña = ""
                // } 
                if (response.data.code == 401) {
                    console.log(response);
                    toastr.error('Las credenciales que ingreso no estan registrados.')
                    me.fillLogin.cContraseña = ""
                } 
                if (response.data.code == 200) {
                    toastr.success('Las credenciales son correctas.')
                    me.ListarPermisos(response.data.authUser.id)
                    me.$router.push({
                        name: "Principal",
                    });
                    location.reload();
                }
            })
            .catch(function (error) {
            // handle error
            console.log(error);
        })
      },
      validarLogin(){
          this.opcionesToastr();
          this.error = 0;
          if (!this.fillLogin.cEmail && !this.fillLogin.cContraseña) {
              toastr.error('Debe introducir sus credenciales de acceso.')
              return 1;
          }
          if (!this.fillLogin.cEmail) {
              toastr.error('Debe introducir su Correo Institucional.')
              this.error = 1;
          }
          if (!this.fillLogin.cContraseña) {
              toastr.error('Debe introducir su Contraseña.')
              this.error = 1
          }
          return this.error;
      },
      ListarPermisos(id){
          let me = this;
          axios
          .post("/listarPermisos", {
              id: id
            })
            .then(function (response) {
                me.permisos = response.data
            })
      },
      opcionesToastr(){
        toastr.options = {
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
      }
  },
};
</script>

<style>
</style>