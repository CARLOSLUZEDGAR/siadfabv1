import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

export default new Router ({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '*',
            component: require('./components/Notfound.vue').default
        },
        {
            path: '/',
            name: 'Inicio',
            component: require('./components/Bienvenida.vue').default
        },
        {
            path: '/plantilla',
            component: require('./components/Plantilla.vue').default
        },
        {
            path: '/nivel1destino',
            name: 'Nivel1destino',
            component: require('./components/Nivel1Destino.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-destn1')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },
        {
            path: '/nivel2destino',
            name: 'Nivel2destino',
            component: require('./components/Nivel2Destino.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-destn2')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },
        {
            path: '/nivel3destino',
            name: 'Nivel3destino',
            component: require('./components/Nivel3Destino.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-destn3')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },
        {
            path: '/nivel4destino',
            name: 'Nivel4destino',
            component: require('./components/Nivel4Destino.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-destn4')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        {
            path: '/listarPersonal',
            name: 'ListarPersonalDestinos',
            component: require('./components/Personal.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-destper')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        {
            path: '/listas',
            name: 'ListasPersonal',
            component: require('./components/ListasPersonal.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-destper')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        {
            path: '/destinosPersonal/:d',
            //name: "nombre_component"
            name: 'DestinosPersonal',
            component: require('./components/DestinosPersonal.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-destper')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        /**
         * Ruta para creacion de usuarios
         */
        {
            path: '/usuarios',
            name: 'Usuarios',
            component:  require('./components/Usuarios/Index.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper') && per.includes('view-user')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        {
            path: '/datosUser',
            name: 'DatosUser',
            component:  require('./components/Usuarios/DatosUser.vue').default
        },

        /**
         * Rutas para cracion de roles
         */
        {
            path: '/roles',
            name: 'Roles',
            component:  require('./components/Roles/Index.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper') && per.includes('view-rol')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        {
            path: '/nuevoRol',
            name: 'NuevoRol',
            component:  require('./components/Roles/Create.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        {
            path: '/editarRol/:id',
            name: 'EditarRol',
            component:  require('./components/Roles/Editar.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        /**
         * Rutas para los permisos
         */
         {
            path: '/permisos',
            name: 'Permisos',
            component:  require('./components/Permisos/Index.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper') && per.includes('view-permi')) {
                    next();
                } else {
                    next(from.path);
                }
            }
        },

        {
            path: '/acercade',
            name: 'Acercade',
            component:  require('./components/AcercaDe.vue').default
        },
        
        {
            path: '/ayuda',
            name: 'Ayuda',
            component:  require('./components/Ayuda.vue').default
        },
    ]


})
