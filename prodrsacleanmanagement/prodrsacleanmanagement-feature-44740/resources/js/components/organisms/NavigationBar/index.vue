<template>
  <v-app-bar
    app
    clipped-left
    flat
    disable-resize-watcher
    permanent
  >
    <!-- <AppLogo :src.sync="path"/> -->

    <div class="flex-grow-1" />
    <!-- <v-btn>
                   icon
                   @click="sample">
                   <Icon>
                       nature_people
                   </Icon>
                </v-btn> -->

    <div class="locale-changer">
      <v-select
        v-model="$i18n.locale"
        item-text="label"
        item-value="value"
        :items="langs"
      />
    </div>

    <v-btn icon>
      <Icon>
        help_outline
      </Icon>
    </v-btn>
    <v-btn icon>
      <Icon>
        account_circle
      </Icon>
    </v-btn>
    <!-- <v-btn
            v-if="isLoggedIn"
            icon
            @click="logout">
            <Icon>
                exit_to_app
            </Icon>
        </v-btn> -->
  </v-app-bar>
</template>

<script>
// import AppLogo from "@/js/components/atoms/AppLogo.vue";
import Icon from "@/js/components/atoms/AppIcon";
import {mapGetters} from "vuex";

export default {
    name: "AppBar",
    components: {
        // AppLogo,
        Icon
    },
    computed: {
        ...mapGetters({
            // isLoggedIn: 'auth/isLoggedIn',
            // authUser: 'auth/authUser',
        }),
    },
    data() {
        return {
            path: '/dashboard',
            isNewWindow:true,
            langs: [
              { label: '日本語', value: 'ja' },
              { label: 'English', value: 'en' },
            ],
        };
    },
    props: {},
    methods: {
        // logout() {
        //     this.$store.dispatch('auth/logout')
        //         .then(() => {
        //             this.$store.dispatch('snackbar/success', {type:'ログアウト'});
        //             this.$router.push({name: 'login'});
        //         })
        //         .catch(() => {
        //             this.$store.dispatch('snackbar/error', {type:'ログアウト', result:{}});
        //         });
        // },
    },
};
</script>

<style scoped>
</style>
