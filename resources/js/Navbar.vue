<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <router-link class="navbar-brand" :to="home">Blog</router-link>
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                  <router-link class="nav-link" :to="home">Accueil</router-link>
                </li>
                <li class="nav-item">
                  <router-link class="nav-link" :to="signup" v-if="!logged" >Inscription</router-link>
                </li>
                <li class="nav-item">
                  <router-link class="nav-link" :to="login">Connexion</router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link" @click="userlogout" style="cursor:pointer" v-if="logged">
                        <span class="font-weight-bold">{{name.toUpperCase()}}</span> Déconnexion
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  :to="adminPanel">
                        <span class="font-weight-bold">Admin Panel</span>
                    </a>
                </li>
              </ul>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    data(){
        return{
            home : '/',
            login : '/login',
            signup : '/signup',
            logout : '/logout',
            logged : User.isLogged().logged,
            name : User.isLogged().name,
            adminPanel:'admin'

        }
    },
    methods: {
        userlogout(){
            User.logout();
            this.logged = false;
            this.$router.go();
        }
    },
}
</script>
