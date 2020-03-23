<template>
  <span>
    <home-hero />
    <home-details />
  </span>
</template>

<script>
import HomeHero from '@/js/components/organisms/HomeHero';
import HomeDetails from '@/js/components/organisms/HomeDetails';

export default {
    name: 'Home',
    components: {
        HomeHero,
        HomeDetails,
    },
};
</script>