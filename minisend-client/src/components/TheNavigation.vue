<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <router-link to="/" class="navbar-brand" exact tag="a">{{
      appName
    }}</router-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarColor01"
      aria-controls="navbarColor01"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav" v-if="authenticated">
        <li class="nav-item">
          <router-link to="/dashboard" class="nav-link" tag="a" exact
            ><i class="fa fa-home" style="margin-right: 10px"></i
            >Dashboard</router-link
          >
        </li>
        <li class="nav-item">
          <router-link to="/activity" class="nav-link" tag="a" exact
            ><i class="fa fa-sitemap" style="margin-right: 10px"></i
            >Activity</router-link
          >
        </li>
        <li class="nav-item">
          <router-link to="/tokens" class="nav-link" tag="a" exact
            ><i class="fa fa-cog" style="margin-right: 10px"></i>Api
            Tokens</router-link
          >
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown" v-if="authenticated">
          <a
            class="nav-link dropdown-toggle"
            data-toggle="dropdown"
            href="#"
            role="button"
            aria-haspopup="true"
            aria-expanded="false"
            >{{ user.email }}</a
          >
          <div class="dropdown-menu dropdown-menu-right">
            <router-link to="/dashboard" class="dropdown-item"
              >Dashboard</router-link
            >
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" @click.prevent="signOut"
              >Sign out</a
            >
          </div>
        </li>
        <template v-else>
          <li class="nav-item">
            <router-link to="/signin" class="nav-link" tag="a" exact
              >Sign in</router-link
            >
          </li>
          <li class="nav-item">
            <router-link to="/signup" class="nav-link" tag="a" exact
              >Sign up</router-link
            >
          </li>
        </template>
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
    appName() {
      return process.env.VUE_APP_NAME;
    },
  },

  methods: {
    ...mapActions({
      signOutAction: "auth/signOut",
    }),

    signOut() {
      this.signOutAction().then(() => {
        this.$router.replace({
          name: "home",
        });
      });
    },
  },
};
</script>