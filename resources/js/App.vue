<template>
    <div>
        <router-link :to="{name: 'home'}">Accueil</router-link>
        <router-link :to="{name: 'boutique'}">Boutique</router-link>

        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "App"
};
</script>