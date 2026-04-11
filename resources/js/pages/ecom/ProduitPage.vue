<template>
    <div v-if="product">
        <h1>Produit page détails</h1>

        <div class="card">
            <h5>
                {{ product.name }}
            </h5>

            <p>
                {{ product.description }}
            </p>

            <p>
                {{ product.price }}€
            </p>

            <p v-if="product.stock < 10">
                Seulement {{ product.stock }} produits en stock
            </p>

            <section>
                <button>
                    Ajouter au panier
                </button>
            </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ProduitPage',
    data() {
        return {
            product: null
        }
    },
    mounted() {
        const slug = this.$route.params.slug;
        this.getProduct(slug);
    },
    methods: {
        getProduct(slug) {
            axios
            .get(`/product/${slug}`)
            .then((response) => {
                this.product = response.data;
            })

        }
    }
}
</script>