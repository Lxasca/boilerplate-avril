<template>
    <div>
        <h1>Livraison</h1>

        <!-- choix des livraisons -->
        <section>
            <div>
                Livraison type 1
            </div>

            <div>
                Livraison type 2
            </div>

            <div>
                Livraison type 3
            </div>
        </section>


        <router-link :to="{ name: 'panier-paiement' }">
            Paiement
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'LivraisonPage'
}
</script>