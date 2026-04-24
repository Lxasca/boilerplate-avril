<template>
    <div>
        <h1>Accueil</h1>
        <collections-component></collections-component>
    </div>
</template>

<script>
import CollectionsComponent from '../components/ecom/CollectionsComponent.vue';
export default {
    name: "HomePage",
    components: { CollectionsComponent }
};
</script>