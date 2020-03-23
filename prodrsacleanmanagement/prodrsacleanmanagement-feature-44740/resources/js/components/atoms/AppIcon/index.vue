<template>
  <v-icon
    :color="color"
    :size="size"
  >
    <slot />
  </v-icon>
</template>

<script>
export default {
    name: 'Icon',
    props: {
        color: {
            type: String,
            default: '#a0a9b9',
        },
        size: {
            type: String,
            default: '28px',
        },
    },
    data() {
        return {
        };
    },
};
</script>

<style scoped>
</style>
