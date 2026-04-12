<template>
    <h1>Boutique</h1>

    <section>
        <div v-for="product in products" :key="product.id">
            <div class="card">
                <h5>
                    {{ product.name }}
                </h5>

                <p>
                    {{ formatTruncate(product.description) }}
                </p>

                <p>
                    {{ formatPrice(product.price) }}
                </p>

                <p v-if="product.stock < 10">
                    Seulement {{ product.stock }} produits en stock
                </p>

                <section>

                    <router-link :to="{ name: 'boutique-produit', params: { slug: product.slug } }">
                        Voir plus
                    </router-link>
                    
                    <button @click="add(product.id)">
                        Ajouter au panier
                    </button>
                </section>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import { useCartStore } from '../../../src/stores/cartStore';
import { formatPrice, formatTruncate } from '../../../src/helpers/format';

export default {
    name: 'BoutiquePage',
    data() {
        return {
            products: []
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        formatPrice, formatTruncate,
        getProducts() {
            axios
            .get('/products')
            .then((response) => {
                this.products = response.data;
            })
        },
        add(productId) {
            const cartStore = useCartStore();
            cartStore.add(productId);
        },
    }
}
</script>