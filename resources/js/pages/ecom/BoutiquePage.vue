<template>
    <h1>Boutique</h1>

    <section>
        <div v-for="product in products" :key="product.id">
            <div class="card">
                <h5>
                    {{ product.name }}
                </h5>

                <p>
                    {{ truncate(product.description) }}
                </p>

                <p>
                    {{ product.price }}€
                </p>

                <p v-if="product.stock < 10">
                    Seulement {{ product.stock }} produits en stock
                </p>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';

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
        getProducts() {
            axios
            .get('/products')
            .then((response) => {
                this.products = response.data;
            })
        },
        truncate(text) {
            return text.length > 100 ? text.substring(0, 100) + ' ...' : text;
        }
    }
}
</script>