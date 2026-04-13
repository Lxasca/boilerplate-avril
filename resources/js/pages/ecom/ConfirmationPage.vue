<template>
    <div>
        <h1>
            Etape finale (confirmation)
        </h1>

        <panier-details-component :readonly="true"></panier-details-component>
        
        <router-link :to="{ name: 'panier-paiement-succes'}">
            Commander
        </router-link>
    </div>
</template>

<script>
import PanierDetailsComponent from '../../components/ecom/PanierDetailsComponent.vue';

export default {
    name: "ConfirmationPage",
    components: {
        PanierDetailsComponent
    }
}
</script>