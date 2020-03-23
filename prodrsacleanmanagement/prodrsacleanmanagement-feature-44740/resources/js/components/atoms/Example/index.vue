<template>
  <button
    @click="$emit('Action')"
  >
    {{ name }}
  </button>
</template>

<script>
export default {
    name: "Example",
    components: {},
    data() {
        return {
            name: this.buttonName,
        };
    },
    props: {
        buttonName: {
            type: String,
            default: "",
            required: false
        }
    }
};
</script>

<style scoped>
</style>