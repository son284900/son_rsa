<template>
  <a
    v-if="isNewWindow"
    class="app-link"
    :href="path"
    target="_blank"
  >
    {{ label }}
    <font-awesome-icon icon="external-link-alt" />
  </a>
  <router-link
    v-else
    class="app-link"
    :to="path"
  >
    {{ label }}
  </router-link>
</template>

<script>
export default {
    name: 'AppLink',
    data() {
        return {};
    },
    props: {
        label: {
            type:String,
            default:''
        },
        path: {
            type:String,
            default:''
        },
        isNewWindow: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style scoped>
.app-link {
  color: #fff;
  text-decoration: none;
  margin: 0 4px 0 4px;
    font-size: large;
}
.app-link:hover {
  color: #fff;
  background-color: #24292e;
}
.router-link-exact-active {
  margin-bottom: 4px;
  border-bottom: 2px solid #24292e;
}
</style>
