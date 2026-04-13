<template>
    <div v-if="isShowCart">        
        <panier-details-component></panier-details-component>

        <section>
            <router-link :to="{ name: 'panier' }" @click="this.$emit('hide-cart')">
                Mon panier
            </router-link>
        </section>
    </div>
</template>

<script>
import PanierDetailsComponent from './PanierDetailsComponent.vue';

export default {
    name: 'PanierComponent',
    components: {
        PanierDetailsComponent
    },
    props: {
        isShowCart: {
            type: Boolean,
            required: true
        }
    }
}

</script>