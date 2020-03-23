<template>
  <v-app id="app">
    <div v-if="!$route.meta.hideBar">
      <NavigationBar />
    </div>
    <div v-if="!$route.meta.hideNav">
      <NavigationDrawer :toggle.sync="drawer" />
    </div>
    <!--        <v-content transition="slide-x-transition">-->
    <v-content>
      <router-view />
    </v-content>

    <v-snackbar
      v-model="snackbar.status"
      :color="snackbar.color"
      :top="true"
      :right="true"
      :vertical="true"
    >
      {{ snackbar.text }}
      <v-btn
        color="white"
        text
        @click="snackbar.status = false"
      >
        閉じる
      </v-btn>
    </v-snackbar>
  </v-app>
</template>

<script>
import NavigationDrawer from "@/js/components/organisms/NavigationDrawer";
import NavigationBar from "@/js/components/organisms/NavigationBar";
import { mapState } from "vuex";

export default {
    components: {
        NavigationDrawer,
        NavigationBar
    },
    data() {
        return {
            drawer: true
        };
    },
    computed: {
        ...mapState({
            snackbar: state => state.snackbar,
        })
    }
};
</script>

<style>
* {
  /*background-color: #F8F9FD;*/
  font-size: 16px;
  font-family: "Noto Sans Japanese", serif;
  /*letter-spacing: 0.05em;*/
  /*color: #5A6B81;*/
  /*font-weight: 200;*/
  /*word-break: break-all;*/
}
</style>
