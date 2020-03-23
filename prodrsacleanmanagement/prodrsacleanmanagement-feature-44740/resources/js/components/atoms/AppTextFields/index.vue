<template>
  <span :style="style">
    {{ label }}
  </span>
</template>

<script>
export default {
    name: "AppText",
    data() {
        return {
            style: {
                "font-size": this.fontSize,
                "line-height": this.lineHeight,
                "font-weight": this.fontWeight,
                "color": this.color,
            }
        }
    },
    props: {
        label:{
            type:String,
            default:''
        },
        fontSize: {
            type: String,
            default: "16px"
        },
        lineHeight: {
            type: String,
            default: "16px"
        },
        fontWeight: {
            type: String,
            default: "300"
        },
        color: {
            type: String,
            default: "#000000"
        }

    },
}
</script>

<style scoped>

</style>
