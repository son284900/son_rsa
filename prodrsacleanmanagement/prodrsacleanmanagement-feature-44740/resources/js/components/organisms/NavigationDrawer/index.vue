<template>
  <span>
    <v-navigation-drawer
      :mini-variant.sync="mini"
      :value="toggle"
      app
      clipped
      permanent
    >
      <v-list-item>
        <v-btn
          icon
          @click.stop="mini = !mini"
        >
          <Icon>chevron_left</Icon>
        </v-btn>

      </v-list-item>

      <v-divider />

      <v-list
        :dense="true"
        :nav="true"
        :rounded="false"
        :avatar="false"
        :subheader="true"
        :disabled="false"
      >
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          :to="{ name: item.route }"
          active-class="selected"
        >
          <v-list-item-icon>
            <Icon>
              {{ item.icon }}
            </Icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>
              {{ item.title }}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-group
          v-for="item in items_work_gr"
          :key="item.title"
          v-model="item.active"
          :no-action="true"
        >
          <template slot="activator">
            <v-list-item-icon>
              <Icon>
                {{ item.action }}
              </Icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title
                v-text="item.title"
              />
            </v-list-item-content>
          </template>

          <v-list-item
            v-for="subItem in item.items"
            :key="subItem.title"
            link
            :to="{ name: subItem.route }"
            active-class="selected"
          >
            <v-list-item-content>
              <v-list-item-title>
                {{ subItem.title }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
  </span>
</template>

<script>
import { mapGetters } from 'vuex';
import Icon from '@/js/components/atoms/AppIcon';

export default {
    name: 'NavBar',
    components: {
        Icon,
    },
    props: {
        toggle: Boolean,
    },
    computed: {
        ...mapGetters({
            // isLoggedIn: 'auth/isLoggedIn',
            // authUser: 'auth/authUser',
        }),
    },
    data() {
        return {
            items: [
                { title: 'ダッシュボード', icon: 'mdi-view-dashboard', route: 'dashboard' },
            ],
            mini: true,
            items_work_gr: [
                {
                    action: 'mdi-folder-settings-variant',
                    title: 'マスタ管理',
                    items: [
                        { title: '清掃シフトマスタ', route: 'master.shift.list' },
                        { title: '清掃ステータスマスタ', route: 'master.clean.status.list' },
                    ],
                },
            ],
        };
    },
    methods: {},
};
</script>

<style scoped>
    a {
        text-decoration: none;
    }

    .selected {
        background-color: #efefef;
        color: rgba(0, 0, 0, 26);
    }
</style>
// mdi-folder-settings-variant