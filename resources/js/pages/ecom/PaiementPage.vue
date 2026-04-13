<template>
    <div>
        <h1>
            Choix du paiement
        </h1>

        <!-- choix du moyen de paiement -->
        <section>
            <div>
                Paiement type 1
            </div>

            <div>
                Paiement type 2
            </div>

            <div>
                Paiement type 3
            </div>
        </section>

        <router-link :to="{ name: 'panier-confirmation' }">
            Paiement
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'PaiementPage'
}
</script>