<template>
  <v-container
    fluid
    fill-height
    class="home-hero"
    style="max-height: 100vh;"
  >
    <div
      class="fixed-top"
      style="left:initial; margin: 30px"
    >
      <AppLink
        label="Dashboard"
        path="dashboard"
        :is-new-window="false"
      />
    </div>

    <v-layout
      justify-center
      align-center
      column
      pa-5
    >
      <div class="display-4 font-weight-black white--text text-xs-center">
        WELCOME
      </div>
      <div
        class="display-4 font-weight-black white--text text-xs-center mb-3"
      >
        TO RSA
      </div>
      <div class="display-1 font-weight-bold white--text text-xs-center">
        It is a Cleaning Management Version.
      </div>
      <v-btn
        fab
        class="mt-5 brown darken-4"
      >
        <v-icon
          large
          color="white"
        >
          expand_more
        </v-icon>
      </v-btn>
    </v-layout>
  </v-container>
</template>

<script>
import AppLink from '@/js/components/atoms/AppLink';

export default {
    name: 'HomeHero',
    components: {
        AppLink,
    },
};

</script>

<style scoped>
    .home-hero {
        background: url('http://source.unsplash.com/0BhSKStVtdM');
        background-size: cover;
        width: 100%;
        height: 100%;
    }
</style>
